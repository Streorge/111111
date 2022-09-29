<?php /**
 * AJAX handler to store the state of dismissible notices.
 */
function industryup_ajax_notice_handler() {
    if ( isset( $_POST['type'] ) ) {
        // Pick up the notice "type" - passed via jQuery (the "data-notice" attribute on the notice)
        $type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        // Store it in the options table
        update_option( 'dismissed-' . $type, TRUE );
    }
}

add_action( 'wp_ajax_industryup_dismissed_notice_handler', 'industryup_ajax_notice_handler' );

function industryup_deprecated_hook_admin_notice() {
        // Check if it's been dismissed...
        if ( ! get_option('dismissed-get_started', FALSE ) ) {
            // Added the class "notice-get-started-class" so jQuery pick it up and pass via AJAX,
            // and added "data-notice" attribute in order to track multiple / different notices
            // multiple dismissible notice states ?>
            <div class="updated notice notice-get-started-class is-dismissible" data-notice="get_started">
                <div class="industryup-notice clearfix">
                    <div class="industryup-notice-content">
                        <h3>
                            <?php
                        printf( esc_html__( 'Welcome! Thanks for installing %1$s!', 'industryup' ), '<strong>'. wp_get_theme()->get('Name'). '</strong>' );
                        ?>
                        </h3>

                        <div class="panel-column-6">
                        <p><?php echo sprintf(__('Clicking on get started will install & activate and get Defult demo of Industryup.', 'industryup')) ?></p>

                        <a class="industryup-btn-get-started button button-primary button-hero industryup-button-padding" href="#" data-name="" data-slug=""><?php esc_html_e( 'Get started with Industryup', 'industryup' ) ?></a>
                        <?php printf(
                                'or %1$sCustomize theme%2$s</a></span>',
                                '<a target="_blank" href="' . esc_url( admin_url( 'customize.php' ) ) . '">',
                                '</a>'
                            );
                        ?>
                        </div>
                        <div class="panel-column-7">
                        <p><?php echo sprintf(__('Clicking on Get Elementor Demos Button and Get Elementor Premade Template', 'industryup')) ?></p>
                        <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=industryup-getting-started' ) ); ?>" class="button-primary button button-hero" style="text-decoration: none;"><?php echo esc_html__('Get Elementor Demos','industryup'); ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
}

add_action( 'admin_notices', 'industryup_deprecated_hook_admin_notice' );

/* Plugin Install */

add_action( 'wp_ajax_install_act_plugin', 'industryup_admin_info_install_plugin' );

function industryup_admin_info_install_plugin() {
    /**
     * Install Plugin.
     */
    include_once ABSPATH . '/wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

    if ( ! file_exists( WP_PLUGIN_DIR . '/icyclub' ) ) {
        $api = plugins_api( 'plugin_information', array(
            'slug'   => sanitize_key( wp_unslash( 'icyclub' ) ),
            'fields' => array(
                'sections' => false,
            ),
        ) );

        $skin     = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $api->download_link );
    }

    // Activate plugin.
    if ( current_user_can( 'activate_plugin' ) ) {
        $result = activate_plugin( 'icyclub/icyclub.php' );
    }
}