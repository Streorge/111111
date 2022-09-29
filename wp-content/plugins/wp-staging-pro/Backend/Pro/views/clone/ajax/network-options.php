<?php
/**
 * @var stdClass $options
 *
 * @see \WPStaging\Backend\Modules\Jobs\Scan::start For details on $options.
 */

$isDisabled = false;
$isChecked  = false;
if (!empty($options->current) && $options->current !== null) {
    $isDisabled = true;
    $isChecked  = isset($options->existingClones[$options->current]['networkClone']) ? $options->existingClones[$options->current]['networkClone'] : false;
    $isChecked  = filter_var($isChecked, FILTER_VALIDATE_BOOLEAN);
}
?>

<p class="wpstg--advance-settings--checkbox">
    <label for="wpstg_network_entire_clone"><?php _e('Clone Entire Network'); ?></label>
    <input type="checkbox" id="wpstg_network_clone" name="wpstg_network_clone" value="true" <?php echo $isChecked ? 'checked' : '' ?> <?php echo $isDisabled ? 'disabled' : '' ?> />
    <span class="wpstg--tooltip">
        <img class="wpstg--filter--svg wpstg--dashicons" src="<?php echo $scan->getInfoIcon(); ?>" alt="info" />
        <span class="wpstg--tooltiptext">
            <?php _e('Clone the entire multisite network as a staging multisite.', 'wp-staging'); ?>
            <br/> <br/>
            <b><?php _e('Note', 'wp-staging') ?>: </b> <?php _e('Changing this option resets all selected database tables. Use the menu link "Database Tables" below to select all desired tables.', 'wp-staging'); ?>
            <br/>
            <br/>
            <span class="wpstg--red"> <?php _e('Though cloning of the entire multisite network works with the same database, it is recommended to use another database to keep the multisite network completely separated from the production network.', 'wp-staging'); ?></span>
        </span>
    </span>
</p>
