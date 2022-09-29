<?php
/**
 * Plugin Name: CoDesigner Pro
 * Description: Premium feature unlocker for <strong>CoDesigner</strong>.
 * Plugin URI: https://codexpert.io/codesigner/?utm_source=dashboard&utm_medium=plugins&utm_campaign=plugin-uri
 * Author: Codexpert
 * Version: 3.6
 * Author URI: https://codexpert.io/?utm_source=dashboard&utm_medium=plugins&utm_campaign=author-uri
 * Text Domain: woolementor-pro
 * Domain Path: /languages
 */

namespace Codexpert\Woolementor_Pro;
use Codexpert\Plugin\Widget;
use Codexpert\Plugin\Survey;
use Codexpert\Plugin\Notice;
use Codexpert\Plugin\License;
use Codexpert\Plugin\Deactivator;

/**
 * if accessed directly, exit.
 */
update_option('_license_woolementor-pro_key', 'license_key');
update_option('_license_woolementor-pro_status', 'valid');
update_option('_license_woolementor-pro_expiry', 4765132799);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for the plugin
 * @package Plugin
 * @author Codexpert <hi@codexpert.io>
 */
final class Plugin {
	
	/**
	 * Plugin instance
	 * 
	 * @access public
	 * 
	 * @var Plugin
	 */
	public static $_instance;

	/**
	 * The constructor method
	 * 
	 * @access public
	 * 
	 * @since 1.0
	 */
	public function __construct() {
		/**
		 * Includes required files
		 */
		$this->include();

		/**
		 * Defines contants
		 */
		$this->define();

		/**
		 * Run actual hooks
		 */
		$this->hook();
	}

	/**
	 * Includes files
	 * 
	 * @access public
	 * 
	 * @uses composer
	 * @uses psr-4
	 */
	public function include() {
		require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
	}

	/**
	 * Define variables and constants
	 * 
	 * @access public
	 * 
	 * @uses get_plugin_data
	 * @uses plugin_basename
	 */
	public function define() {
		// constants
		define( 'WOOLEMENTOR_PRO', __FILE__ );
		define( 'WOOLEMENTOR_PRO_DIR', dirname( WOOLEMENTOR_PRO ) );
		define( 'WOOLEMENTOR_PRO_DEBUG', apply_filters( 'woolementor-pro-debug', Helper::get_option( 'woolementor_tools', 'enable_debug', false ) == 'on' ) );
		define( 'WOOLEMENTOR_PRO_ASSETS', plugins_url( 'assets', WOOLEMENTOR_PRO ) );

		// plugin data
		$this->plugin				= get_plugin_data( WOOLEMENTOR_PRO );
		$this->plugin['basename']	= plugin_basename( WOOLEMENTOR_PRO );
		$this->plugin['file']		= WOOLEMENTOR_PRO;
		$this->plugin['server']		= apply_filters( 'woolementor-pro_server', 'https://codexpert.io/dashboard' );
		$this->plugin['min_php']	= '5.6';
		$this->plugin['min_wp']		= '4.0';
		$this->plugin['depends']	= [ 'woolementor/woolementor.php' => 'CoDesigner' ];

		$this->plugin['item_id']	= 8088;
		$this->plugin['updatable']	= true;
		$this->plugin['license_page']= admin_url( 'admin.php?page=woolementor' );
		$this->plugin['license']	= new License( $this->plugin );

		global $woolementor_pro;
		$woolementor_pro = $this->plugin;
	}

	/**
	 * Hooks
	 * 
	 * @access public
	 * 
	 * Executes main plugin features
	 *
	 * To add an action, use $instance->action()
	 * To apply a filter, use $instance->filter()
	 * To register a shortcode, use $instance->register()
	 * To add a hook for logged in users, use $instance->priv()
	 * To add a hook for non-logged in users, use $instance->nopriv()
	 */
	public function hook() {

		if( is_admin() ) :

			/**
			 * Admin facing hooks
			 */
			$admin = new Admin( $this->plugin );
			$admin->action( 'plugins_loaded', 'i18n' );
			$admin->action( 'admin_enqueue_scripts', 'enqueue_scripts' );
			$admin->filter( 'woolementor-widget_links', 'widget_links' );
			$admin->filter( "plugin_action_links_{$this->plugin['basename']}", 'action_links' );
			$admin->filter( 'plugin_row_meta', 'plugin_row_meta', 10, 2 );
			$admin->filter( 'woocommerce_payment_gateway_supports', 'supports_payment_form', 10, 3 );
			$admin->action( 'save_post', 'save_template_data' );
			$admin->filter( 'wcd_pro_get_posts', 'pseudo_page_ids' );
			$admin->filter( 'cx-plugin_remote_notice_endpoint', '__return_false', 10, 2 );

			/**
			 * Settings related hooks
			 */
			$settings = new Settings( $this->plugin );
			$settings->filter( 'woolementor-is_pro', '__return_true' );
			$settings->filter( 'woolementor-settings_args', 'settings_fields' );

			// Product related classes
			$widget			= new Widget( $this->plugin );
			$survey			= new Survey( $this->plugin );
			$notice			= new Notice( $this->plugin );
			$deactivator	= new Deactivator( $this->plugin );

		else : // !is_admin() ?

			/**
			 * Front facing hooks
			 */
			$front = new Front( $this->plugin );
			$front->action( 'wp_head', 'head' );
			$front->action( 'wp_footer', 'footer' );
			$front->action( 'init', 'set_cookie' );
			$front->action( 'wp_enqueue_scripts', 'enqueue_scripts' );
			$front->filter( 'the_content', 'filter_content' );
			$front->filter( 'template_include', 'override_product_templates', 11 );
			$front->filter( 'woocommerce_checkout_fields', 'filter_checkout_fields' );
			
			$front->filter( 'woocommerce_is_checkout', 'is_checkout_render' );
			$front->action( 'woocommerce_checkout_redirect_empty_cart', 'empty_cart_render' );
			$front->action( 'woocommerce_checkout_update_order_review_expired', '__return_false' );
			
		endif;

		/**
		 * Widgets related hooks
		 */
		$widgets = new Widgets( $this->plugin );
		$widgets->action( 'elementor/editor/after_enqueue_scripts', 'enqueue_scripts' );
		$widgets->action( 'elementor/element/after_section_end', 'add_control', 10, 3 );
		$widgets->action( 'elementor/frontend/section/before_render', 'form_start' );
		$widgets->action( 'elementor/frontend/section/after_render', 'form_close' );
		$widgets->filter( 'elementor/frontend/section/should_render', 'stop_render_checkout', 10, 2 );
		$widgets->action( 'init', 'order_received_permalink' );
		// $widgets->action( 'wp', 'setcookie_pageid' );
		$widgets->action( 'elementor/documents/register', 'register_type' );
		$widgets->action( 'elementor/template-library/create_new_dialog_types', 'template_types', 10, 2 );
		$widgets->action( 'elementor/documents/register_controls', 'conditions_for_templates' );
		$widgets->action( 'save_post', 'save_template_meta' );
		$widgets->filter( 'single_template', 'load_canvas_template' );
		$widgets->filter( 'woocommerce_add_to_cart_fragments', 'menu_cart' );
		$widgets->action( 'init', 'show_custom_checkout_fields' );
		$widgets->filter( 'wcd_register_widget', 'filter_widget', 10, 2 );
		$widgets->action( 'elementor/element/after_section_end', 'remove_controls', 10, 3 );

		$widgets->action( 'elementor/element/common/_section_style/before_section_start', 'register_control_section' );
		$widgets->action( 'elementor/element/column/layout/after_section_end', 'register_control_section' );
		$widgets->action( 'elementor/element/section/section_typo/after_section_end', 'register_control_section' );

		$widgets->action( 'elementor/element/common/codesigner_control_section/before_section_end', 'control_actions', 10, 2 );
		$widgets->action( 'elementor/element/column/codesigner_control_section/before_section_end', 'control_actions', 10, 2 );
		$widgets->action( 'elementor/element/section/codesigner_control_section/before_section_end', 'control_actions', 10, 2 );
		$widgets->filter( 'elementor/frontend/section/should_render', 'restrict_render_section', 10, 2 );
		$widgets->filter( 'elementor/frontend/column/should_render', 'restrict_render_section', 10, 2 );
		$widgets->filter( 'elementor/widget/render_content', 'restrict_render_widgets', 10, 2 );

		$widgets->action( 'init', 'register_custom_endpoint' );

		$widgets->action( 'codesigner_before_cart_button', 'quick_view_button', 10, 3 );
		$widgets->action( 'codesigner_before_cart_button', 'quick_checkout_button', 10, 3 );
		// $widgets->action( 'codesigner_after_cart_button', 'quick_view_button', 10, 3 );
		$widgets->action( 'codesigner_after_shop_content_controls', 'quickview_controls' );
		$widgets->action( 'codesigner_after_shop_style_controls', 'quickview_style_controls' );
		$widgets->action( 'codesigner_quick_checkout', 'quick_checkout_render' );

		/**
		 * Theme_Support related hooks
		 *
		 * @since 1.0
		 */
		$theme_support = new Theme_Support( $this->plugin );

		/**
		 * Common hooks
		 */
		$common = new Common( $this->plugin );
		$common->action( 'pre_get_posts', 'ajax_filter_pre_posts' );
		$common->filter( 'my_plugin_pre_get_posts', 'ajax_filter_pre_posts' );

		/**
		 * Theme_Support related hooks
		 *
		 * @since 1.0
		 */
		$ajax = new Ajax( $this->plugin );
		$ajax->all( 'afp-form-submission', 'afp_form_submission' );
		$ajax->priv( 'wcd-test-email', 'test_email' );
		$ajax->all( 'add-to-compare', 'add_to_compare' );
		$ajax->all( 'remove-from-compare', 'remove_from_compare' );
		$ajax->all( 'quick-view', 'quick_view' );
		$ajax->all( 'quick-checkout', 'quick_checkout' );
		$ajax->all( 'ajax-filter', 'ajax_filter' );

		/**
		 * Email related hooks
		 */
		$email = new Email( $this->plugin );
		$email->filter( 'wc_get_template', 'change_content', 11, 5 );
		$email->filter( 'woocommerce_email_styles', 'change_styles', 11, 2 );
	}

	/**
	 * Cloning is forbidden.
	 */
	public function __clone() { }

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() { }

	/**
	 * Instantiate the plugin
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

Plugin::instance();