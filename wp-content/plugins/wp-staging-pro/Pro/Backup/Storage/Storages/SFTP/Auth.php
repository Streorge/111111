<?php

namespace WPStaging\Pro\Backup\Storage\Storages\SFTP;

use WPStaging\Pro\Backup\Storage\AbstractStorage;
use Exception;
use WPStaging\Pro\Backup\Storage\Storages\SFTP\Clients\ClientInterface;
use WPStaging\Pro\Backup\Storage\Storages\SFTP\Clients\FtpClient;
use WPStaging\Pro\Backup\Storage\Storages\SFTP\Clients\FtpCurlClient;
use WPStaging\Pro\Backup\Storage\Storages\SFTP\Clients\FtpException;
use WPStaging\Pro\Backup\Storage\Storages\SFTP\Clients\SftpClient;

use function WPStaging\functions\debug_log;

class Auth extends AbstractStorage
{

    public function __construct()
    {
        $this->identifier = 'sftp';
        $this->label = 'FTP / SFTP';
    }

    public function authenticate()
    {
        // no-op
    }

    /**
     * @return bool
     */
    public function testConnection()
    {
        $options = [];
        $options['ftpType'] = $_POST['ftp_type'];
        $options['host'] = $_POST['host'];
        $options['port'] = $_POST['port'];
        $options['username'] = $_POST['username'];
        $options['password'] = $_POST['password'];
        $options['passphrase'] = $_POST['passphrase'];
        $options['key'] = $_POST['key'];
        $options['ssl'] = !empty($_POST['ssl']) && $_POST['ssl'] === 'true';
        $options['passive'] = !empty($_POST['passive']) && $_POST['passive'] === 'true';

        $client = $this->getClient($options);
        if ($client === false) {
            return false;
        }

        $result = $client->login();
        if ($result === false) {
            debug_log("Test Connection Error: " . $client->getError());
        }

        return $result;
    }

    /**
     * @param array $options Optional
     *
     * @return ClientInterface|false
     */
    public function getClient($options = null)
    {
        if ($options === null) {
            $options = $this->getOptions();
        }

        if ($options['ftpType'] === 'sftp') {
            return new SftpClient($options['host'], $options['username'], $options['password'], $options['key'], $options['passphrase'], $options['port']);
        }

        if (apply_filters('wpstg.ftpclient.forceUseFtpExtension', false) === false) {
            try {
                return new FtpCurlClient($options['host'], $options['username'], $options['password'], $options['ssl'], $options['passive'], $options['port']);
            } catch (FtpException $ex) {
                debug_log("Curl Extension Not Loaded");
            }
        }

        try {
            return new FtpClient($options['host'], $options['username'], $options['password'], $options['ssl'], $options['passive'], $options['port']);
        } catch (FtpException $ex) {
            debug_log("FTP Extension Not Loaded");
        }

        return false;
    }

    /**
     * @param array $settings
     * @return bool
     */
    public function updateSettings($settings)
    {
        $options = $this->getOptions();
        $ftpType = !empty($settings['ftp_type']) ? $settings['ftp_type'] : '';
        $host = !empty($settings['host']) ? $settings['host'] : '';
        $port = !empty($settings['port']) ? $settings['port'] : '';
        $username = !empty($settings['username']) ? $settings['username'] : '';
        $password = !empty($settings['password']) ? $settings['password'] : null;
        $key = !empty($settings['key']) ? $settings['key'] : null;
        $ssl = isset($settings['ssl']) && $settings['ssl'] === 'true';
        $passive = isset($settings['passive']) && $settings['passive'] === 'true';
        $passphrase = !empty($settings['passphrase']) ? $settings['passphrase'] : null;
        $location = isset($settings['location']) ? $settings['location'] : null;
        $backupsToKeep = isset($settings['max_backups_to_keep']) ? $settings['max_backups_to_keep'] : 2;
        // Earlt bail if options already the same
        if (
            array_key_exists('ftpType', $options) &&
            $options['ftpType'] === $ftpType &&
            $options['host'] === $host &&
            $options['port'] === $port &&
            $options['username'] === $username &&
            $options['username'] === $password &&
            $options['passphrase'] === $passphrase &&
            $options['key'] === $key &&
            $options['ssl'] === $ssl &&
            $options['passive'] === $passive &&
            $options['location'] === $location &&
            $options['maxBackupsToKeep'] === $backupsToKeep
        ) {
            return true;
        }

        $options['ftpType'] = $ftpType;
        $options['host'] = $host;
        $options['port'] = $port;
        $options['username'] = $username;
        $options['password'] = $password;
        $options['passphrase'] = $passphrase;
        $options['key'] = $key;
        $options['location'] = $location;
        $options['maxBackupsToKeep'] = $backupsToKeep;
        $options['ssl'] = $ssl;
        $options['passive'] = $passive;

        $options['isAuthenticated'] = false;

        $client = $this->getClient($options);
        if ($client !== false) {
            $result = $client->login();
            if ($result === false) {
                debug_log($client->getError());
            }

            $options['isAuthenticated'] = $result;
        }

        return $this->saveOptions($options);
    }

    /**
     * Clean all FTP / SFTP Settings,
     * Also unauthenticate the provider
     */
    public function revoke()
    {
        $options = $this->getOptions();

        // Early bail if already unauthenticated
        if ($options['isAuthenticated'] === false) {
            return true;
        }

        $options['isAuthenticated'] = false;
        $options['ftpType'] = '';
        $options['host'] = '';
        $options['username'] = '';
        $options['password'] = '';
        $options['key'] = '';
        $options['passphrase'] = '';
        $options['location'] = '';

        return parent::saveOptions($options);
    }

    public function cleanBackups()
    {
        $options = $this->getOptions();
        $client = $this->getClient($options);

        $client->login();

        $files = $client->getFiles($options['location']);
        if (!is_array($files)) {
            return false;
        }

        foreach ($files as $file) {
            $result = $client->deleteFile($file['name']);
            if ($result === false) {
                return false;
            }
        }

        return true;
    }

    public function isBackupUploaded($backupFile)
    {
        $options = $this->getOptions();
        $client = $this->getClient($options);

        $client->login();

        $files = $client->getFiles($options['location']);
        if (!is_array($files)) {
            return false;
        }

        foreach ($files as $file) {
            if ($file['name'] === $backupFile) {
                return true;
            }
        }

        return false;
    }
}
