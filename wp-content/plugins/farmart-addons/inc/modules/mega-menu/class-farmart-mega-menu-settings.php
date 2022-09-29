<?php

namespace Farmart\Addons\Modules\Mega_Menu;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private $option = 'farmart_mega_menu';

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'settings_api_init' ) );

		if ( get_option( 'farmart_mega_menu' ) == '1' ) {
			return;
		}

		$this->load();
		$this->init();
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_nav_menu_walker' ) );
	}

	/**
	 * Load files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function load() {
		if ( is_admin() ) {
			require_once FARMART_ADDONS_DIR . 'inc/modules/mega-menu/class-farmart-mega-menu-walker-edit.php';
			require_once FARMART_ADDONS_DIR . 'inc/modules/mega-menu/class-farmart-mega-menu-edit.php';
		}
	}

	/**
	 * Initialize
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	private function init() {
		if ( is_admin() ) {
			return \Farmart\Addons\Modules\Mega_Menu\Edit::instance();
		}
	}

	/**
	 * Change the default nav menu walker
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function edit_nav_menu_walker() {
		return '\Farmart\Addons\Modules\Mega_Menu\Walker_Edit';
	}

	/**
	 * Add  field in 'Settings' > 'Writing'
	 * for enabling CPT functionality.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function settings_api_init() {
		add_settings_section(
			'farmart_mega_menu_section',
			'<span id="mega-menu-options">' . esc_html__( 'Mega Menu', 'farmart' ) . '</span>',
			array( $this, 'writing_section_html' ),
			'writing'
		);

		add_settings_field(
			$this->option,
			'<span class="mega-menu-options">' . esc_html__( 'Mega Menu', 'farmart' ) . '</span>',
			array( $this, 'disable_field_html' ),
			'writing',
			'farmart_mega_menu_section'
		);
		register_setting(
			'writing',
			$this->option,
			'intval'
		);
	}

	/**
	 * Add writing setting section
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function writing_section_html() {
		?>
        <p>
			<?php esc_html_e( 'Use these settings to disable mega menu of navigation on your site', 'farmart' ); ?>
        </p>
		<?php
	}

	/**
	 * HTML code to display a checkbox true/false option
	 * for the Services CPT setting.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function disable_field_html() {
		?>

        <label for="<?php echo esc_attr( $this->option ); ?>">
            <input name="<?php echo esc_attr( $this->option ); ?>"
                   id="<?php echo esc_attr( $this->option ); ?>" <?php checked( get_option( $this->option ), true ); ?>
                   type="checkbox" value="1"/>
			<?php esc_html_e( 'Disable Mega Menu for this site.', 'farmart' ); ?>
        </label>

		<?php
	}
}