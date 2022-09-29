<?php

/**
 * @var $this \WPStaging\Backend\Pro\Notices\Notices
 * @var $viewsNoticesPath
 * @see \WPStaging\Backend\Pro\Notices\Notices::messages
 */

use WPStaging\Backend\Notices\Notices;

?>
<div class="notice notice-warning wpstg-entire-clone-server-config-notice">
    <p>
        <strong><?php _e('WP STAGING - Clone Multisite Network', 'wp-staging'); ?></strong> <br/>
        <?php
        $server = $_SERVER['SERVER_SOFTWARE'];
        if (stripos($server, 'apache') === 0) {
            _e("We are unable to add an .htaccess file for this staging multisite network. It is required to make sure network URLs work properly. You will need to add this file manually.", "wp-staging");
        } else {
            $server = strtoupper($server);
            _e("Your site runs on {$server} webserver. Please configure your server to make sure your staging network site URLs work properly.", "wp-staging");
        }

        echo sprintf(__(' Read <a href="%s" target="_blank">this article</a> on how to do it.', 'wp-staging'), 'https://wp-staging.com/docs/activate-permalinks-staging-site/#NGINX_Multisite_in_Subfolder/');
        ?>
    </p>
    <p>
      <?php Notices::renderNoticeDismissAction(
          $viewsNoticesPath,
          'entire_clone_server_config',
          '.wpstg_dismiss_entire_clone_server_config_notice',
          '.wpstg-entire-clone-server-config-notice'
      ) ?>
    </p>
</div>
