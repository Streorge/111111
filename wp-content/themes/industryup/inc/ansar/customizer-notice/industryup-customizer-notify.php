<?php

class Industryup_Customizer_Notify {

	private $recommended_actions;

	
	private $recommended_plugins;

	
	private static $instance;

	
	private $recommended_actions_title;

	
	private $recommended_plugins_title;

	
	private $dismiss_button;

	
	private $install_button_label;

	
	private $activate_button_label;

	
	private $industryup_deactivate_button_label;

	
	public static function init( $config ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof industryup_Customizer_Notify ) ) {
			self::$instance = new industryup_Customizer_Notify;
			if ( ! empty( $config ) && is_array( $config ) ) {
				self::$instance->config = $config;
				self::$instance->setup_config();
				self::$instance->setup_actions();
			}
		}

	}

	
	public function setup_config() {

		global $industryup_customizer_notify_recommended_plugins;
		global $industryup_customizer_notify_recommended_actions;

		global $install_button_label;
		global $activate_button_label;
		global $industryup_deactivate_button_label;

		$this->recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
		$this->recommended_plugins = isset( $this->config['recommended_plugins'] ) ? $this->config['recommended_plugins'] : array();

		$this->recommended_actions_title = isset( $this->config['recommended_actions_title'] ) ? $this->config['recommended_actions_title'] : '';
		$this->recommended_plugins_title = isset( $this->config['recommended_plugins_title'] ) ? $this->config['recommended_plugins_title'] : '';
		$this->dismiss_button            = isset( $this->config['dismiss_button'] ) ? $this->config['dismiss_button'] : '';

		$industryup_customizer_notify_recommended_plugins = array();
		$industryup_customizer_notify_recommended_actions = array();

		if ( isset( $this->recommended_plugins ) ) {
			$industryup_customizer_notify_recommended_plugins = $this->recommended_plugins;
		}

		if ( isset( $this->recommended_actions ) ) {
			$industryup_customizer_notify_recommended_actions = $this->recommended_actions;
		}

		$install_button_label    = isset( $this->config['install_button_label'] ) ? $this->config['install_button_label'] : '';
		$activate_button_label   = isset( $this->config['activate_button_label'] ) ? $this->config['activate_button_label'] : '';
		$industryup_deactivate_button_label = isset( $this->config['industryup_deactivate_button_label'] ) ? $this->config['industryup_deactivate_button_label'] : '';

	}

	
	public function setup_actions() {

		// Register the section
		add_action( 'customize_register', array( $this, 'industryup_plugin_notification_customize_register' ) );

		// Enqueue scripts and styles
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'industryup_customizer_notify_scripts_for_customizer' ), 0 );

		/* ajax callback for dismissable recommended actions */
		add_action( 'wp_ajax_quality_customizer_notify_dismiss_action', array( $this, 'industryup_customizer_notify_dismiss_recommended_action_callback' ) );

		add_action( 'wp_ajax_ti_customizer_notify_dismiss_recommended_plugins', array( $this, 'industryup_customizer_notify_dismiss_recommended_plugins_callback' ) );

	}

	
	public function industryup_customizer_notify_scripts_for_customizer() {

		wp_enqueue_style( 'industryup-customizer-notify-css', get_template_directory_uri() . '/inc/ansar/customizer-notice/css/industryup-customizer-notify.css', array());
		wp_style_add_data( 'industryup-customizer-notify-css', 'rtl', 'replace' );

		wp_enqueue_style( 'industryup-plugin-install' );
		wp_enqueue_script( 'industryup-plugin-install' );
		wp_add_inline_script( 'plugin-install', 'var pagenow = "customizer";' );

		wp_enqueue_script( 'industryup-updates' );

		wp_enqueue_script( 'industryup-customizer-notify-js', get_template_directory_uri() . '/inc/ansar/customizer-notice/js/industryup-customizer-notify.js', array( 'customize-controls' ));
		wp_localize_script(
			'industryup-customizer-notify-js', 'industryupCustomizercompanionObject', array(
				'industryup_ajaxurl'   => esc_url(admin_url( 'admin-ajax.php' )),
				'template_directory' => esc_url(get_template_directory_uri()),
				'base_path'          => esc_url(admin_url()),
				'activating_string'  => __( 'Activating', 'industryup' ),
			)
		);

	}

	
	public function industryup_plugin_notification_customize_register( $wp_customize ) {

		
		require_once get_template_directory() . '/inc/ansar/customizer-notice/industryup-customizer-notify-section.php';

		$wp_customize->register_section_type( 'Industryup_Customizer_Notify_Section' );

		$wp_customize->add_section(
			new industryup_Customizer_Notify_Section(
				$wp_customize,
				'industryup-customizer-notify-section',
				array(
					'title'          => $this->recommended_actions_title,
					'plugin_text'    => $this->recommended_plugins_title,
					'dismiss_button' => $this->dismiss_button,
					'priority'       => 0,
				)
			)
		);

	}


		public function industryup_customizer_notify_dismiss_recommended_action_callback() {

		global $industryup_customizer_notify_recommended_actions;

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			
			if ( get_option( 'industryup_customizer_notify_show' ) ) {

				$industryup_customizer_notify_show_recommended_actions = get_option( 'industryup_customizer_notify_show' );
				switch ( $_GET['todo'] ) {
					case 'add':
						$industryup_customizer_notify_show_recommended_actions[ $action_id ] = true;
						break;
					case 'dismiss':
						$industryup_customizer_notify_show_recommended_actions[ $action_id ] = false;
						break;
				}
				update_option( 'industryup_customizer_notify_show', $industryup_customizer_notify_show_recommended_actions );
				
			} else {
				$industryup_customizer_notify_show_recommended_actions = array();
				if ( ! empty( $industryup_customizer_notify_recommended_actions ) ) {
					foreach ( $industryup_customizer_notify_recommended_actions as $industryup_lite_customizer_notify_recommended_action ) {
						if ( $industryup_lite_customizer_notify_recommended_action['id'] == $action_id ) {
							$industryup_customizer_notify_show_recommended_actions[ $industryup_lite_customizer_notify_recommended_action['id'] ] = false;
						} else {
							$industryup_customizer_notify_show_recommended_actions[ $industryup_lite_customizer_notify_recommended_action['id'] ] = true;
						}
					}
					echo esc_html($industryup_customizer_notify_show_recommended_actions);
				}
			}
		}
		die(); 
	}

	
	public function industryup_customizer_notify_dismiss_recommended_plugins_callback() {

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			$industryup_lite_customizer_notify_show_recommended_plugins = get_option( 'industryup_customizer_notify_show_recommended_plugins' );

			switch ( $_GET['todo'] ) {
				case 'add':
					$industryup_lite_customizer_notify_show_recommended_plugins[ $action_id ] = false;
					break;
				case 'dismiss':
					$industryup_lite_customizer_notify_show_recommended_plugins[ $action_id ] = true;
					break;
			}
			update_option( 'industryup_customizer_notify_show_recommended_plugins', $industryup_lite_customizer_notify_show_recommended_plugins );
		}
		die(); 
	}

}