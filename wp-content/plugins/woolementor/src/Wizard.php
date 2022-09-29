<?php
/**
 * All Wizard related functions
 */
namespace Codexpert\Woolementor;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\Setup;
require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
require_once( ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php' );
require_once( ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php' );
/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Wizard
 * @author Codexpert <hi@codexpert.io>
 */
class Wizard extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
		$this->action( 'admin_print_styles', 'enqueue_styles' );
		$this->action( 'admin_print_scripts', 'enqueue_scripts' );
	}

	public function action_links( $links ) {
		$this->admin_url = admin_url( 'admin.php' );

		$new_links = [
			'wizard'	=> sprintf( '<a href="%1$s">%2$s</a>', add_query_arg( [ 'page' => "{$this->slug}_setup" ], $this->admin_url ), __( 'Setup Wizard', 'cx-plugin' ) )
		];
		
		return array_merge( $new_links, $links );
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/wizard.css", WOOLEMENTOR ), '', $this->version, 'all' );
		wp_enqueue_style( 'setting', plugins_url( "/assets/css/widgets-settings.css", WOOLEMENTOR ), '', $this->version, 'all' );
		wp_enqueue_style( 'font-awesome-free', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css' );

	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->slug .'-js', plugins_url( "/assets/js/wizard.js", WOOLEMENTOR ), [], $this->version, true );
	}

	public function render() {
		// update_option( 'woolementor_setup_done', 1 );

		// // force setup once
		// if( get_option( "{$this->slug}_setup_done" ) != 1 ) {
		// 	update_option( "{$this->slug}_setup_done", 1 );
		// 	wp_safe_redirect( add_query_arg( [ 'page' => "{$this->slug}_setup" ], admin_url( 'admin.php' ) ) );
		// 	exit;
		// }

		$back = __( '<i class="fas fa-long-arrow-alt-left"></i> Back', 'woolementor' );

		$this->plugin['steps'] = [
			'welcome'	=> [
				'label'			=> __( 'Welcome', 'woolementor' ),
				'template'		=> WOOLEMENTOR_DIR . '/views/wizard/welcome.php',
				'prev_text'		=> __( '<i class="fas fa-long-arrow-alt-left"></i> Skip Setup & Go to Dashboard', 'woolementor' ),
				'prev_url'		=> add_query_arg( [ 'page' => 'woolementor' ], admin_url( 'admin.php' ) ),
				'next_text'		=> __( 'Next Step', 'woolementor' ),
				'next_url'		=> add_query_arg( [ 'page' => 'woolementor_setup', 'step' => 'configration' ], admin_url( 'admin.php' ) ),
			],
			'configration'	=> [
				'label'			=> __( 'Configration', 'woolementor' ),
				'template'		=> WOOLEMENTOR_DIR . '/views/wizard/configration.php',
				'action'		=> [ $this, 'save_configration' ],
				'prev_text'		=> $back,
				'prev_url'		=> add_query_arg( [ 'page' => 'woolementor_setup', 'step' => 'welcome' ], admin_url( 'admin.php' ) ),
				'next_text'		=> __( 'Next Step', 'woolementor' ),
			],
			'pro-features'	=> [
				'label'			=> __( 'More Features', 'woolementor' ),
				'template'		=> WOOLEMENTOR_DIR . '/views/wizard/pro-features.php',
				'action'		=> [ $this, 'save_pro_features' ],
				'prev_text'		=> $back,
				'prev_url'		=> add_query_arg( [ 'page' => 'woolementor_setup', 'step' => 'configration' ], admin_url( 'admin.php' ) ),
				'next_text'		=> __( 'Next Step', 'woolementor' ),
			],
			'complete'	=> [
				'label'			=> __( 'Complete', 'woolementor' ),
				'template'		=> WOOLEMENTOR_DIR . '/views/wizard/complete.php',
				'action'		=> [ $this, 'install_plugin' ],
				'prev_text'		=> $back,
				'redirect'		=> add_query_arg( [ 'page' => 'woolementor' ], admin_url( 'admin.php' ) )
			],
		];

		if( defined( 'WOOLEMENTOR_PRO' ) ) {
			unset( $this->plugin['steps']['pro-features'] );
		}

		new Setup( $this->plugin );
	}

	public function save_configration() {

		$tools 	= get_option( 'woolementor_tools' ) ? : [];

		if ( isset( $_POST['enable_add-to-cart'] ) ) {
			$tools[ 'add-to-cart-text' ] 	= sanitize_text_field( $_POST['add-to-cart-text'] );
			update_option( 'woolementor_tools', $tools );
		}

		if ( isset( $_POST['redirect_to_checkout'] ) ) {
			$tools[ 'redirect_to_checkout' ] = sanitize_text_field( $_POST['redirect_to_checkout'] );
			update_option( 'woolementor_tools', $tools );
		}

		if ( isset( $_POST['cross_domain_copy_paste'] ) ) {
			$tools[ 'cross_domain_copy_paste' ] = sanitize_text_field( $_POST['cross_domain_copy_paste'] );
			update_option( 'woolementor_tools', $tools );
		}

	}

	public function save_pro_features() {

		if ( isset( $_POST['enable_remind'] ) ) {
			update_option( 'woolementor_remind_upgrade_pro', time() );
		}

	}

	public function install_plugin() {

		$skin     = new \WP_Ajax_Upgrader_Skin();
		$upgrader = new \Plugin_Upgrader( $skin );

		if ( isset( $_POST['image-sizes'] ) ) {
			$upgrader->install( 'https://downloads.wordpress.org/plugin/image-sizes.latest-stable.zip' );
			update_option( 'image-sizes_setup_done', 1 );
			activate_plugin( 'image-sizes/image-sizes.php' );
		}

		if ( isset( $_POST['wc-affiliate'] ) ) {
			$upgrader->install( 'https://downloads.wordpress.org/plugin/wc-affiliate.latest-stable.zip' );
			update_option( 'wc-affiliate_setup', 1 );
			activate_plugin( 'wc-affiliate/wc-affiliate.php' );
		}

		if ( isset( $_POST['restrict-elementor-widgets'] ) ) {
			$upgrader->install( 'https://downloads.wordpress.org/plugin/restrict-elementor-widgets.latest-stable.zip' );
			activate_plugin( 'restrict-elementor-widgets/restrict-elementor-widgets.php' );
		}
	
	}

}
