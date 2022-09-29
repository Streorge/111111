<?php
/**
 * All Widgets facing functions
 */

namespace Codexpert\Woolementor_Pro;

use Codexpert\Plugin\Base;
use \Elementor\Repeater;
use \Elementor\Plugin as Elementor;
use \Elementor\Controls_Manager;
use \Elementor\Core\Documents_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
Use \Elementor\Core\Schemes\Typography;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Widgets
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Widgets extends Base {

	/**
	 * Constructor function
	 *
	 * @since 1.0
	 */
	public function __construct( $plugin ) {
		$this->slug = $plugin['TextDomain'];
		$this->name = $plugin['Name'];
		$this->version = $plugin['Version'];
	}

	public function enqueue_scripts() {

		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';

		wp_enqueue_style( "{$this->slug}-widgets", plugins_url( "assets/css/style{$min}.css", WOOLEMENTOR_PRO ), '', $this->version, 'all' );
		// enqueue JavaScript
		if ( wcd_is_pro_activated() ) {
			wp_enqueue_script( "{$this->slug}-widgets", plugins_url( "assets/js/widgets{$min}.js", WOOLEMENTOR_PRO ), [], $this->version, true );

			$localized = array(
				'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
			);
			wp_localize_script( $this->slug . '-widgets', 'WOOLEMENTOR_PRO', apply_filters( "{$this->slug}-localized", $localized ) );
		}
	}

	/**
	 * Adds a new control in the editor
	 *
	 * @since 1.1
	 */
	public function add_control( $element, $section_id, $args ) {
		if ( 'section' === $element->get_name() && 'section_structure' == $section_id ) {
			$element->start_controls_section(
				'woolementor',
				[
					'tab' => Controls_Manager::TAB_LAYOUT,
					'label' => __( 'CoDesigner', 'woolementor-pro' ),
				]
			);

			$element->add_control(
				'contains_checkout',
				[
					'type'			=> Controls_Manager::SWITCHER,
					'label'			=> __( 'Contains Checkout?', 'woolementor-pro' ),
					'description'	=> __( 'Does this section contain CoDesigner Checkout Form?', 'woolementor-pro' ),
				]
			);

	        $element->add_control(
				'thankyou_page_location', [
					'label' 	=> __( 'Thankyou Screen', 'woolementor-pro' ),
					'type' 		=> Controls_Manager::SELECT2,
					'options' 	=> [
						'default'	=> __( 'Current Page', 'woolementor-pro' ),
						'custom'	=> __( 'Seperate Page', 'woolementor-pro' ),
					],
					'condition' => [
	                    'contains_checkout' => 'yes'
	                ],
				]
			);

	        $element->add_control(
				'thankyou_page_id', [
					'label' 	=> __( 'Select ThankYou Page', 'woolementor-pro' ),
					'type' 		=> Controls_Manager::SELECT2,
					'options' 	=> Helper::get_posts( [ 'post_type' => 'page' ] ),
					'condition' => [
	                    'contains_checkout' => 'yes',
	                    'thankyou_page_location' => 'custom'
	                ],
				]
			);

			$element->add_control(
				'contains_thankyou',
				[
					'type'			=> Controls_Manager::SWITCHER,
					'label'			=> __( 'Contains ThankYou?', 'woolementor-pro' ),
					'description'	=> __( 'Does this section contain CoDesigner ThankYou widget?', 'woolementor-pro' ),
					'separator'		=> 'before',
				]
			);

			$element->add_control(
				'custom_thankyou',
				[
					'type'			=> Controls_Manager::SWITCHER,
					'label'			=> __( 'Custom ThankYou?', 'woolementor-pro' ),
					'description'	=> __( 'Is this a seperate page than the Checkout Page?', 'woolementor-pro' ),
					'condition' => [
	                    'contains_thankyou' => 'yes',
	                ],
				]
			);

			$element->add_control(
				'contains_orderpay',
				[
					'type'			=> Controls_Manager::SWITCHER,
					'label'			=> __( 'Contains Order-pay?', 'woolementor-pro' ),
					'description'	=> __( 'Does this section contain CoDesigner Order pay section', 'woolementor-pro' ),
					'separator'		=> 'before',
				]
			);

			$element->end_controls_section();
		}
	}

	public function conditions_for_templates( $element ) {

		if( !isset( $_GET['post'] ) || get_post_type( $_GET['post'] ) != 'elementor_library' ) return;

		$template_type =  get_post_meta( $_GET['post'], '_elementor_template_type', true );
		if ( in_array( $template_type , [ 'wl-header', 'wl-single', 'wl-footer', 'wl-archive' ] ) ) {
			$element->start_controls_section(
				'wl_conditions',
				[
					'tab' => Controls_Manager::TAB_SETTINGS,
					'label' => __( 'Conditions', 'woolementor-pro' ),
				]
			);
		}

		if ( in_array( $template_type , [ 'wl-header', 'wl-footer' ] ) ) {
			$element->add_control(
				'page_includes',
				[
					'label' 		=> __( 'Include Pages', 'woolementor-pro' ),
					'type' 			=> Controls_Manager::SELECT2,
					'multiple' 		=> true,
					'label_block' 	=> true,
					'options' 		=> [ 0 => __( 'All', 'woolementor-pro' ) ] + Helper::get_posts( [ 'post_type' => 'page' ], false ),
				]
			);

			$element->add_control(
				'post_includes',
				[
					'label' 		=> __( 'Include Posts', 'woolementor-pro' ),
					'type' 			=> Controls_Manager::SELECT2,
					'multiple' 		=> true,
					'label_block' 	=> true,
					'options' 		=> [ 0 => __( 'All', 'woolementor-pro' ) ] + Helper::get_posts( [ 'post_type' => 'post' ], false ),
				]
			);
		}

		if ( in_array( $template_type , [ 'wl-header', 'wl-footer', 'wl-single' ] ) ) {
			$element->add_control(
				'product_includes',
				[
					'label' 		=> __( 'Include Products', 'woolementor-pro' ),
					'type' 			=> Controls_Manager::SELECT2,
					'multiple' 		=> true,
					'label_block' 	=> true,
					'options' 		=> [ 0 => __( 'All', 'woolementor-pro' ) ] + Helper::get_posts( [ 'post_type' => 'product' ], false ),
				]
			);
		}
		
		if ( in_array( $template_type , [ 'wl-archive', 'wl-header', 'wl-footer' ] ) ) {

			$element->add_control(
				'tax_includes',
				[
					'label' 		=> __( 'Include categories', 'woolementor-pro' ),
					'type' 			=> Controls_Manager::SELECT2,
					'multiple' 		=> true,
					'label_block' 	=> true,
					'options' 		=> [ 0 => __( 'All', 'woolementor-pro' ), 'shop' => __( 'Shop Only', 'woolementor-pro' ) ] + wcd_get_terms()
				]
			);
		}
		if ( in_array( $template_type , [ 'wl-header', 'wl-single', 'wl-footer', 'wl-archive' ] )) {
			$element->end_controls_section();
		}

		if ( in_array( $template_type , [ 'wl-email' ] ) ) {
			$element->start_controls_section(
				'wcd_test_email',
				[
					'tab' => Controls_Manager::TAB_SETTINGS,
					'label' => __( 'Test Email', 'woolementor-pro' ),
				]
			);

			$element->add_control(
				'wcd_test_email_html',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<div class="wcd-test-email-wrapper">
						<form action="" id="wcd-test-email-form">
						<input type="hidden" name="action" value="wcd-test-email">
						<input type="hidden" name="template_id" value="'. get_the_ID() .'">
							'. wp_nonce_field( $this->slug ) .'
							<input type="email" name="email" placeholder="'. __( 'Input your email and hit the button below', 'woolementor-pro' ) .'" required>
							<input type="submit" id="wcd-send-email" style="margin-top: 5px; background: #05bb3b; color: #fff; border-color: transparent;" value="'. __( 'Send Email', 'woolementor-pro' ) .'">
							<div id="wcd-email-notification" style="text-align: center;border: 1px solid #05bb3b;margin-top: 5px;padding: 8px;border-radius: 4px;color: #05bb3b;background: #05bb3b0a;display:none;"></div>
						</form>
					</div>',
				]
			);

			$element->end_controls_section();
		}
	}

	/**
	 * Starting <form> tag
	 *
	 * @since 1.1
	 */
	public function form_start ( $element ) {
		$settings = $element->get_settings_for_display();	

		if( $settings['contains_checkout'] == 'yes' ) {
			echo apply_filters( 'woolementor-checkout_form_tag', '<form name="checkout" method="post" class="checkout woocommerce-checkout" action="" enctype="multipart/form-data" novalidate="novalidate">' );
		}

		/**
		 * custom thankyou page
		 *
		 * @since 3.3
		 * @author Al Imran Akash<alimranakash.bd@gmail@gmail.com>
		 */
		if ( $settings['custom_thankyou'] == 'yes' ) {
			add_filter( 'woolementor-is_allowed', '__return_true' );
			add_filter( 'render_contains_thankyou', '__return_true' );
		}

		if ( 'custom' == $settings['thankyou_page_location'] && $settings['thankyou_page_id'] > 0 ) {

			$page_id = $settings['thankyou_page_id'];

			global $wp;
			if ( is_checkout() && ! empty( $wp->query_vars['order-received'] ) ) {
				$key = sanitize_text_field( $_GET['key'] );
				wp_redirect( get_permalink( $page_id ) . '?key=' . $key );
				exit;
			}
		}
	}

	/**
	 * Closing </form> tag
	 *
	 * @since 1.1
	 */
	public function form_close( $element ) {
		$settings = $element->get_settings_for_display();

		if( $settings['contains_checkout'] == 'yes' ) {
			echo '</form>';
		}
	}

	public function custom_checkout_page_id( $checkout_page_id  ) {
		if( is_admin() ) return $checkout_page_id;

		global $post;
		$post_id = $post->ID;

		if ( isset( $_COOKIE['wl_current_page_id'] ) ) {
			$post_id = codesigner_sanitize_number( $_COOKIE['wl_current_page_id'] );
		}
		$elementor_data = get_post_meta( $post_id, '_elementor_data', true );
		$_data 			= json_decode( $elementor_data );

		if( isset( $_data[0]->settings->contains_checkout ) ) {
			return $post_id;
		}

	    return $checkout_page_id;
	}

	public function order_received_permalink() {
		$slug = get_option( 'woocommerce_checkout_order_received_endpoint' );
		add_rewrite_endpoint( $slug . '/[0-9]+', EP_PERMALINK | EP_PAGES );
	}

	public function setcookie_pageid() {
		if( wp_doing_ajax() ) return;
		global $wp;

		$page = url_to_postid( home_url( $wp->request ) );
		if( $page != 0 ) {
			setcookie( 'wl_current_page_id', $page, time() + HOUR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
		}
	}

	public function register_type( Documents_Manager $manager ) {
		$types = wcd_get_template_types();
		foreach ( $types as $key => $type ) {
			$manager->register_document_type( "{$key}", "Codexpert\Woolementor_Pro\Templates\\{$type['class']}" );
		}
	}

	/**
	 * Register template types
	 *
	 * @since 1.3.0
	 */
	public function template_types( $types, $document_types ) {
		$_types = wcd_get_template_types();

		return $types + $_types;
	}

	public function save_template_meta( $post_id )	{
		
		if ( !in_array( get_post_meta( $post_id, '_elementor_template_type', true ), [ 'wl-header', 'wl-footer', 'wl-archive', 'wl-single' ] ) ) return;

		$data = json_decode( wp_unslash( $_POST['actions'] ) )->save_builder->data->settings;

		if ( isset( $data->page_includes ) && count( $data->page_includes ) > 0 ) {
			update_post_meta( $post_id, 'wl_page_includes', $data->page_includes );
		}
		else {
			delete_post_meta( $post_id, 'wl_page_includes' );
		}

		if ( isset( $data->post_includes ) && count( $data->post_includes ) > 0 ) {
			update_post_meta( $post_id, 'wl_post_includes', $data->post_includes );
		}
		else {
			delete_post_meta( $post_id, 'wl_post_includes' );
		}

		if ( isset( $data->product_includes ) && count( $data->product_includes ) > 0 ) {
			update_post_meta( $post_id, 'wl_product_includes', $data->product_includes );
		}
		else {
			delete_post_meta( $post_id, 'wl_product_includes' );
		}

		if ( isset( $data->tax_includes ) && count( $data->tax_includes ) > 0 ) {
			update_post_meta( $post_id, 'wl_tax_includes', $data->tax_includes );

			if( count( array_intersect( [ 'shop', 0 ], $data->tax_includes ) ) > 0 ) {
				$page_includes 		= get_post_meta( $post_id, 'wl_page_includes', true ) ? : [];
				$page_includes[] 	= '"' . wc_get_page_id( 'shop' ) . '"';
				update_post_meta( $post_id, 'wl_page_includes', $page_includes );
			}
		}
		else {
			delete_post_meta( $post_id, 'wl_tax_includes' );
		}
	}

	public function load_canvas_template( $single_template ) {
		global $post;

		if ( in_array( get_post_meta( $post->ID, '_elementor_template_type', true ), [ 'wl-header', 'wl-footer', 'wl-email' ] ) ) {
			return ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';
		}

		return $single_template;
	}

	public function stop_render_checkout( $should_render, $object )	{
		$settings = $object->get_settings_for_display();

		if ( isset( $settings['contains_checkout'] ) && $settings['contains_checkout'] == 'yes'  && ( is_order_received_page() || wcd_is_order_pay_page() ) ) {
			return apply_filters( 'render_contains_checkout', false );
		}
		elseif ( isset( $settings['contains_thankyou'] ) && $settings['contains_thankyou'] == 'yes'  && !is_order_received_page() ) {
			return apply_filters( 'render_contains_thankyou', false );
		}
		elseif ( isset( $settings['contains_orderpay'] ) && $settings['contains_orderpay'] == 'yes'  && !wcd_is_order_pay_page() ) {
			return apply_filters( 'render_contains_orderpay', false );
		}

		return $should_render;
	}

	public function menu_cart( $fragments ) {
		$product_count 	= WC()->cart->get_cart_contents_count();
		$sub_total 		= WC()->cart->get_cart_subtotal();

		$fragments['sup.wlmc-count-number'] 		= '<sup class="wlmc-count-number">' . $product_count . '</sup>';
		$fragments['span.wlmc-total'] 				= '<span class="wlmc-total">' . $sub_total . '</span>';
		$fragments['span.wlmc-modal-count-number'] 	= '<span class="wlmc-modal-count-number">' . $product_count . '</span>';

		ob_start();
		echo '<div class="widget_shopping_cart_content">';
		woocommerce_mini_cart();
		echo '</div>';
		$fragments['div.widget_shopping_cart_content'] = ob_get_clean();
	    
	    return $fragments;
	}

	public function get_custom_checkout_fields( $order ) {

		$meta_datas = $order->get_meta_data();
		
		$metas = [];
		foreach ( $meta_datas as $meta_data ) {
			$metas[ $meta_data->get_data()['key'] ] = $meta_data->get_data()['value'];
		}
		
		return $metas;
	}

	public function show_custom_checkout_fields(){

		$wl_fields_sections = get_option( '_wcd_checkout_fields', [] );
		if ( empty( $wl_fields_sections ) )return;

		foreach ( $wl_fields_sections as $key => $section ) {
			if ( !empty( $section ) ) {
				foreach( $section as $field ){
					if ( isset( $field["{$key}_show_in_thankyou"] ) && ( $field["{$key}_show_in_thankyou"] != '' || $field["{$key}_show_in_thankyou"] != 'disable' ) ) {
		// Helper::pri( $field );
						$hook 		= $field["{$key}_show_in_thankyou"];
						$meta_label	= $field["{$key}_input_label"];
						$meta_name 	= $field["{$key}_input_name"];
						add_action( $hook, function( $order ) use( $meta_name, $meta_label ){

							if ( !is_object( $order ) ) {
								$order = wc_get_order( $order );
							}

							$order_id 	= $order->get_id();
							$meta_datas = $this->get_custom_checkout_fields($order);
							if ( isset( $meta_datas[ $meta_name ] ) ) {
								echo "<p>{$meta_label}: {$meta_datas[ $meta_name ]}</p>";
							}
						});
					}// end if $field['show_in_thankyou']

					if ( isset( $field["{$key}_show_in_editpage"] ) && ( $field["{$key}_show_in_editpage"] != '' || $field["{$key}_show_in_editpage"] != 'disable' ) ) {

						$hook 		= $field["{$key}_show_in_editpage"];
						$meta_label	= $field["{$key}_input_label"];
						$meta_name 	= $field["{$key}_input_name"];
						add_action( $hook, function( $order ) use( $meta_name, $meta_label ){
							if ( !is_object( $order ) ) {
								$order = wc_get_order( $order );
							}

							$order_id = $order->get_id();
							$meta_datas = $this->get_custom_checkout_fields($order);
							if ( isset( $meta_datas[ $meta_name ] ) ) {
								echo "<p>{$meta_label}: {$meta_datas[ $meta_name ]}</p>";
							}
						});
					}// end if $field['show_in_editpage']

					if ( isset( $field["{$key}_show_in_mail"] ) && ( $field["{$key}_show_in_mail"] != '' || $field["{$key}_show_in_mail"] != 'disable' ) ) {

						$hook 		= $field["{$key}_show_in_mail"];
						$meta_label	= $field["{$key}_input_label"];
						$meta_name 	= $field["{$key}_input_name"];
						add_action( $hook, function( $order ) use( $meta_name, $meta_label ){
							if ( !is_object( $order ) ) {
								$order = wc_get_order( $order );
							}

							$order_id = $order->get_id();
							$meta_datas = $this->get_custom_checkout_fields($order);
							if ( isset( $meta_datas[ $meta_name ] ) ) {
								echo "<p>{$meta_label}: {$meta_datas[ $meta_name ]}</p>";
							}
						});
					}// end if $field['show_in_editpage']

				} //end foreach $section
			}// end if $section
		}//endforeach $wl_fields_sections
	}

	public function filter_widget( $should_register, $widget ){

		if( !isset( $_GET['post'] ) ) return $should_register;

		$post_id 			= codesigner_sanitize_number( $_GET['post'] );
		$post_type 			= get_post_type( $post_id );
		$lib_type 			= get_post_meta( $post_id, '_elementor_template_type', true );
		$allowed_widgets 	= woolementor_widgets_by_category( 'woolementor-email' );

		if ( $post_type == 'elementor_library' && $lib_type =='wl-email' && !in_array( $widget, array_keys( $allowed_widgets ) ) ) {
			return false;
		}

		else if( $post_type == 'elementor_library' && $lib_type !='wl-email' && in_array( $widget, array_keys( $allowed_widgets ) ) ){
			return false;
		}
		else if( $post_type != 'elementor_library' && in_array( $widget, array_keys( $allowed_widgets ) ) ){
			return false;
		}

		return $should_register;
	}

	public function remove_controls( $element, $section_id, $args ) {
		if( !isset( $_GET['post'] ) || get_post_type( $_GET['post'] ) != 'elementor_library' ) return;

		$template_type =  get_post_meta( $_GET['post'], '_elementor_template_type', true );

		$remove_controls = [ 
			'section_effects', 
			'section_custom_attributes_pro', 
			'_section_background', 
			'_section_border', 
		];

		if ( $template_type == 'wl-email' ) {
			foreach ( $remove_controls as $remove_control ) {
				if ( $section_id == $remove_control ) {
					$element->remove_control( $remove_control );
				}
			}
			
		}
	}

	/**
	 * Adds a new control in the editor
	 *
	 * @since 3.0.3
	 */
	public function register_control_section( $element ) {
		
		$element->start_controls_section(
			'codesigner_control_section',
			[
				'tab' => Controls_Manager::TAB_ADVANCED,
				'label' => __( 'Content Restriction', 'woolementor-pro' ),
			]
		);

		$element->end_controls_section();
	}

	public function control_actions( $element, $args ) {

		$element->add_control(
			'enable_restriction',
			[
				'label'        => __( 'Enable Restriction', 'woolementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'woolementor-pro' ),
				'label_off'    => __( 'No', 'woolementor-pro' ),
				'return_value' => 'yes',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'condition_title',
			[
				'label' => __( 'Condition Name', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Condition Name', 'woolementor-pro' ),
				'label_block'	=> true
			]
		);

		$repeater->add_control(
			'conditions_relation',
			[
				'label'		=> __( 'Relation with the previous set', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'options' 	=> [
					'and' 	=> __( 'AND', 'woolementor-pro' ),
					'or' 	=> __( 'OR', 'woolementor-pro' ),
				],
				'default'   => 'and'
			]
		);

		$repeater->add_control(
			'condition_base',
			[
				'label'		=> __( 'Condition Base', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'options' 	=> wcd_show_content_to(),
				'default'	=> 'user',
				'label_block'	=> true
			]
		);

		$repeater->add_control(
			'is_user',
			[
				'label'		=> __( 'User is', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'options' 	=> [
					'loggedin' => __( 'Logged in', 'woolementor-pro' ),
					'loggedout' => __( 'Not Logged in', 'woolementor-pro' ),
				],
				'default'   => 'loggedin',
				'condition'	=> [
					'condition_base' => 'user'
				],
				'label_block'	=> true
			]
		);

		$repeater->add_control(
			'is_user_id',
			[
				'label'		=> __( 'User ID is', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::NUMBER,
				'condition'	=> [
					'condition_base' => 'user_id'
				]
			]
		);

		$repeater->add_control(
			'is_user_role',
			[
				'label'		=> __( 'User Role is', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'options'	=> wcd_show_content_to_roles(),
				'label_block'	=> true,
				'default'	=> 'subscriber',
				'condition'	=> [
					'condition_base' => 'user_role'
				]
			]
		);

		$repeater->add_control(
			'date_condition',
			[
				'label'		=> __( 'Current Time is', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'options'	=> [
					'greater_than' 	=> __( 'Greater Than', 'woolementor-pro' ),
					'less_than' 	=> __( 'Less Than', 'woolementor-pro' ),
				],
				'default' => 'greater_than',
				'label_block'	=> true,
				'condition'	=> [
					'condition_base' => 'date_time'
				]
			]
		);

		$repeater->add_control(
			'date',
			[
				'label'		=> __( '', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DATE_TIME,
				'label_block'	=> true,
				'default'	=> date('Y-m-d h:i'),
				'condition'	=> [
					'condition_base' => 'date_time'
				]
			]
		);

		$repeater->add_control(
			'query_key',
			[
				'label'		=> __( 'Query String contains the Key', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXT,
				'label_block'	=> true,
				'default'	=> 'query',
				'condition'	=> [
					'condition_base' => 'query_string'
				]
			]
		);

		$repeater->add_control(
			'query_relation',
			[
				'label'		=> __( 'And the value is', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'options'	=> [
					'equal' 		=> __( 'Equal To', 'woolementor-pro' ),
					'not_equal' 	=> __( 'Not Equal To', 'woolementor-pro' ),
					'greater_than' 	=> __( 'Greater Than', 'woolementor-pro' ),
					'less_than' 	=> __( 'Less Than', 'woolementor-pro' ),
				],
				'default' => 'equal',
				'label_block'	=> true,
				'condition'	=> [
					'condition_base' => 'query_string'
				]
			]
		);

		$repeater->add_control(
			'query_value',
			[
				'label'		=> __( '', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXT,
				'label_block'	=> true,
				'default'	=> 'value',
				'condition'	=> [
					'condition_base' => 'query_string'
				]
			]
		);

		$repeater->add_control(
			'purchased',
			[
				'label'		=> __( 'Customer ', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'options'	=> [
					'purchased' 	=> __( 'Has Purchased', 'woolementor-pro' ),
					'not_purchased' => __( 'Hasn\'t Purchased', 'woolementor-pro' ),
				],
				'default' => 'purchased',
				'condition'	=> [
					'condition_base' => 'customer_purchased'
				]
			]
		);

		$repeater->add_control(
			'product_ids',
			[
				'label'		=> __( 'The Product(s)', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXT,
				'description' => __( 'Input Product IDs separated by a comma delimiter' ),
				'condition'	=> [
					'condition_base' => 'customer_purchased'
				]
			]
		);

		$repeater->add_control(
			'order_status',
			[
				'label'		=> __( 'Customer Has Order(s) with status(es)', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT2,
				'options'	=> function_exists( 'wc_get_order_statuses' ) ? wc_get_order_statuses() : [],
				'default' 	=> 'wc-completed',
				'multiple' 	=> true,
				'label_block'	=> true,
				'condition'	=> [
					'condition_base' => 'customer_order'
				]
			]
		);

		$element->add_control(
			'woolementor_condition_list',
			[
				'label' => __( 'Show the content if-', 'woolementor-pro' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'condition_title' => __( 'Condition #1', 'woolementor-pro' ),
					],
					[
						'condition_title' => __( 'Condition #2', 'woolementor-pro' ),
					],
				],				
				'condition'   	=> [
					'enable_restriction'  	=> 'yes',
				],
				'separator' 	=> 'before',
				'title_field' => '{{{ condition_title }}}',
			]
		);

		do_action( 'codesigner_before_message_control', $element );

		$element->add_control(
			'show_message',
			[
				'type'			=> Controls_Manager::SELECT,
				'label'			=> __( 'Show Alternate Content', 'woolementor-pro' ),
				'description'	=> __( 'What should it display if the above conditions don\'t meet.', 'woolementor-pro' ),
				'options' => [
					'nomessage' => __( 'Nothing', 'woolementor-pro' ),
					'text' 		=> __( 'Static Text', 'woolementor-pro' ),
					'template' 	=> __( 'A \'Section\' Template', 'woolementor-pro' )
				],
				'default'		=> 'text',
				'separator' 	=> 'before',
				'condition'   	=> [
					'enable_restriction'  => 'yes'
				],
			]
		);

		$element->add_control(
			'message_text',
			[
				'type'			=> Controls_Manager::WYSIWYG,
				'label'			=> __( 'Your Message', 'woolementor-pro' ),
				'description'	=> __( 'This message will be shown as an alternate of your content', 'woolementor-pro' ),
				'default'      	=> __( 'This content is restricted!', 'woolementor-pro' ),
				'condition'   => [
					'enable_restriction'  	=> 'yes',
					'show_message'  		=> 'text'
				],
			]
		);

		$element->add_control(
			'message_template',
			[
				'type'			=> Controls_Manager::SELECT,
				'label'			=> __( 'Choose a <strong>Section</strong> template', 'woolementor-pro' ),
				'description'	=> __( 'This template will be shown as an alternate of your main content', 'woolementor-pro' ),
				'options' 		=> wcd_get_template_list( 'section' ),
				'label_block' 	=> true,
				'condition'   => [
					'enable_restriction'  	=> 'yes',
					'show_message'  		=> 'template'
				],
			]
		);
	}

	public function quickview_controls( $element ) {

		$shop_widgets = woolementor_widgets_by_category();

		if ( !in_array( $element->id, array_keys( $shop_widgets ) ) ) return;
		
		$element->start_controls_section(
			'codesigner_quickview_content_section',
			[
				'tab' => Controls_Manager::TAB_CONTENT,
				'label' => __( 'Quick View', 'woolementor-pro' ),
			]
		);
		
		$element->add_control(
			'quick_view_show_hide',
			[
				'label'        => __( 'Enable Quick View', 'woolementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'woolementor-pro' ),
				'label_off'    => __( 'No', 'woolementor-pro' ),
				'return_value' => 'yes',
			]
		);

		$element->add_control(
			'quick_view_template',
			[
				'label' 		=> __( 'Quick View Templates', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> wcd_get_template_list( 'section' ),
				'label_block' 	=> true,
				'condition' 	=> [
                    'quick_view_show_hide' => 'yes'
                ],
			]
		);
		
		$element->end_controls_section();
		
		$element->start_controls_section(
			'codesigner_quickcheckout_content_section',
			[
				'tab' => Controls_Manager::TAB_CONTENT,
				'label' => __( 'Quick Checkout', 'woolementor-pro' ),
			]
		);
		
		$element->add_control(
			'quick_checkout_show_hide',
			[
				'label'        => __( 'Enable Quick Checkout', 'woolementor-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'woolementor-pro' ),
				'label_off'    => __( 'No', 'woolementor-pro' ),
				'return_value' => 'yes',
			]
		);
		
		$element->end_controls_section();
	}

	public function quickview_style_controls( $element ) {
		
		$element->start_controls_section(
			'codesigner_quickview_style_section',
			[
				'tab' => Controls_Manager::TAB_STYLE,
				'label' => __( 'Quick View', 'woolementor-pro' ),
				'condition' 	=> [
                    'quick_view_show_hide' => 'yes'
                ],
			]
		);
		
        $element->add_control(
            'quickview_icon',
            [
                'label'         => __( 'Icon', 'woolementor-pro' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'far fa-eye',
                    'library'   => 'fa-solid',
                ],
            ]
        );

        $element->add_responsive_control(
            'quickview_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wcd-quick-view-wrap button' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-sm-product-view a.wl-sm-quick-view' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $element->add_responsive_control(
            'quickview_area_size',
            [
                'label'     => __( 'Area Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wcd-quick-view-wrap button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-sm-product-view a.wl-sm-quick-view' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $element->add_responsive_control(
            'quickview_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wcd-quick-view-wrap button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-sm-product-view a.wl-sm-quick-view' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $element->start_controls_tabs(
            'quickview_normal_separator',
            [
                'separator' => 'before'
            ]
        );

        $element->start_controls_tab(
            'quickview_normal',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $element->add_control(
            'quickview_icon_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sm-product-view a.wl-sm-quick-view' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wcd-quick-view-wrap button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $element->add_control(
            'quickview_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sm-product-view a.wl-sm-quick-view' => 'background: {{VALUE}}',
                    '.wl {{WRAPPER}} .wcd-quick-view-wrap button' => 'background: {{VALUE}}',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'quickview_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wcd-quick-view-wrap button, .wl {{WRAPPER}} .wl-sm-product-view a.wl-sm-quick-view',
            ]
        );

        $element->end_controls_tab();

        $element->start_controls_tab(
            'quickview_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $element->add_control(
            'quickview_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sm-product-view a.wl-sm-quick-view:hover' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wcd-quick-view-wrap button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $element->add_control(
            'quickview_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sm-product-view a.wl-sm-quick-view:hover' => 'background: {{VALUE}}',
                    '.wl {{WRAPPER}} .wcd-quick-view-wrap button:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'quickview_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wcd-quick-view-wrap button:hover, .wl {{WRAPPER}} .wl-sm-product-view a.wl-sm-quick-view:hover',
            ]
        );

        $element->end_controls_tab();
        $element->end_controls_tabs();

        $element->add_control(
			'quickview_modal_heading',
			[
				'label' 	=> __( 'Popup Modal', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$element->add_control(
			'quickview_modal_active_mode',
			[
				'label' 	=> __( 'Active Mode', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Show', 'woolementor-pro' ),
				'label_off' => __( 'Hide', 'woolementor-pro' ),
				'return_value' => 'yes',
				'default' 	=> '',
			]
		);

		$element->add_control(
			'quickview_modal_position',
			[
				'label' 	=> __( 'Fixed Position', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Yes', 'woolementor-pro' ),
				'label_off' => __( 'No', 'woolementor-pro' ),
				'return_value' => 'absolute',
				'default' 	=> 'fixed',
				'selectors' 	=> [
                    '.wl .wcd-quick-view-modal' => 'position: {{VALUE}}',
                ],
			]
		);

		$element->add_control(
			'quickview_modal_overlay_heading',
			[
				'label' 	=> __( 'Overlay Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'quickview_card_overlay',
                'label'     => __( 'Overlay Color', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl .wcd-quick-view-modal-overlay',
            ]
        );

        $element->add_responsive_control(
            'quickview_card_width',
            [
                'label'     => __( 'Modal Width', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em', '%' ],
                'selectors' => [
                    '.wl .wcd-quick-view-modal-wrapper' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 300,
                        'max'   => 1000
                    ],
                    'em'    => [
                        'min'   => 10,
                        'max'   => 50
                    ],
                    '%'    => [
                        'min'   => 10,
                        'max'   => 100
                    ],
                ],
				'separator' => 'before',
            ]
        );

        $element->add_responsive_control(
            'quickview_card_height',
            [
                'label'     => __( 'Modal Height', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em', '%' ],
                'selectors' => [
                    '.wl .wcd-quick-view-modal-inner' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 300,
                        'max'   => 1000
                    ],
                    'em'    => [
                        'min'   => 10,
                        'max'   => 50
                    ],
                    '%'    => [
                        'min'   => 10,
                        'max'   => 100
                    ],
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'quickview_card_background',
                'label'     => __( 'Background', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl .wcd-quick-view-modal-wrapper',
                'fields_options' => [
                    'background' =>[
                        'default' => 'classic'
                    ],
                    'color' =>[
                        'default' => '#fff'
                    ]
                ]
            ]
        );

        $element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'quickview_card_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '.wl .wcd-quick-view-modal-wrapper',
                'separator' => 'before',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top'       => '1',
                            'right'     => '1',
                            'bottom'    => '1',
                            'left'      => '1',
                            'isLinked'  => true,
                        ],
                    ],
                    'color' => [
                        'default' => 'var(--wl-light-gray)',
                    ],
                ],
			]
		);

		$element->add_responsive_control(
            'quickview_card_border_radius',
            [
                'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%' ],
                'selectors' 	=> [
                    '.wl .wcd-quick-view-modal-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $element->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'quickview_card_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor-pro' ),
				'selector' 	=> '.wl .wcd-quick-view-modal-wrapper',
			]
		);

		$element->add_control(
			'quickview_modal_title',
			[
				'label' 	=> __( 'Title', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $element->add_control(
			'quickview_title_color',
			[
				'label' 	=> __( 'Title Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
                'selectors' => [
                    '.wl .wcd-quick-view-modal-heading' => 'color: {{VALUE}}',
                ],
                'default' => 'color: var(--wl-gray);'
			]
		);

		$element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'quickview_title_typography',
				'label' => __( 'Typography', 'woolementor-pro' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '.wl .wcd-quick-view-modal-heading',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 15 ] ],
                    // 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
			]
		);

		$element->add_control(
			'quickview_modal_close_icon',
			[
				'label' 	=> __( 'Close Icon', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $element->add_control(
			'quickview_close_icon_color',
			[
				'label' 	=> __( 'Title Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
                'selectors' => [
                    '.wl .wcd-quick-view-modal-close' => 'color: {{VALUE}}',
                ],
                'default'   => '#100'
			]
		);

        $element->add_responsive_control(
            'quickview_close_icon_size',
            [
                'label'     => __( 'Modal Width', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px' ],
                'selectors' => [
                    '.wl .wcd-quick-view-modal-close' => 'font-size: {{SIZE}}{{UNIT}} !important',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 5,
                        'max'   => 100
                    ]
                ],
            ]
        );

        $element->add_control(
            'quickview_close_icon_offset_toggle',
            [
                'label' 		=> __( 'Offset', 'woolementor' ),
                'type' 			=> Controls_Manager::POPOVER_TOGGLE,
                'label_off' 	=> __( 'None', 'woolementor' ),
                'label_on' 		=> __( 'Custom', 'woolementor' ),
                'return_value' 	=> 'yes',
                'default'  => 'yes',
            ]
        );

        $element->start_popover();

        $element->add_responsive_control(
            'quickview_close_icon_offset_x',
            [
                'label' 		=> __( 'Offset Left', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -500,
                        'max' 	=> 500,
                    ],
                ],
                'selectors'     => [
                    '.wl .wcd-quick-view-modal-close' => 'right: {{SIZE}}{{UNIT}}'
                ],
                'render_type' 	=> 'ui',
            ]
        );

        $element->add_responsive_control(
            'quickview_close_icon_offset_y',
            [
                'label' 		=> __( 'Offset Top', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -500,
                        'max' 	=> 500,
                    ],
                ],
                'selectors' 	=> [
                    '.wl .wcd-quick-view-modal-close' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $element->end_popover();

		$element->add_control(
			'quickview_modal_loader',
			[
				'label' 	=> __( 'Loader', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $element->add_control(
			'quickview_close_loader_color',
			[
				'label' 	=> __( 'Loader Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
                'selectors' => [
                    '.wl .wcd-quick-view-loader:after' => 'border-color: {{VALUE}} transparent {{VALUE}} transparent;',
                ],
                'default'   => '#fff'
			]
		);

        $element->add_responsive_control(
            'quickview_close_loader_size',
            [
                'label'     => __( 'Loder Area', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px' ],
                'selectors' => [
                    '.wl .wcd-quick-view-loader:after' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 100
                    ]
                ],
            ]
        );

        $element->add_responsive_control(
            'quickview_close_loader_width',
            [
                'label'     => __( 'Loder Width', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px' ],
                'selectors' => [
                    '.wl .wcd-quick-view-loader:after' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 100
                    ]
                ],
            ]
        );

        $element->end_controls_section();
		
		$element->start_controls_section(
			'codesigner_quick_checkout_style_section',
			[
				'tab' => Controls_Manager::TAB_STYLE,
				'label' => __( 'Quick Checkout', 'woolementor-pro' ),
				'condition' 	=> [
                    'quick_checkout_show_hide' => 'yes'
                ],
			]
		);
		
        $element->add_control(
            'quick_checkout_icon',
            [
                'label'         => __( 'Icon', 'woolementor-pro' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'fas fa-shopping-basket',
                    'library'   => 'fa-solid',
                ],
            ]
        );

        $element->add_responsive_control(
            'quick_checkout_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wcd-quick-checkout-wrap button' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $element->add_responsive_control(
            'quick_checkout_area_size',
            [
                'label'     => __( 'Area Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wcd-quick-checkout-wrap button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $element->add_responsive_control(
            'quick_checkout_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wcd-quick-checkout-wrap button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $element->start_controls_tabs(
            'quick_checkout_normal_separator',
            [
                'separator' => 'before'
            ]
        );

        $element->start_controls_tab(
            'quick_checkout_normal',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $element->add_control(
            'quick_checkout_icon_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wcd-quick-checkout-wrap button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $element->add_control(
            'quick_checkout_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wcd-quick-checkout-wrap button' => 'background: {{VALUE}}',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'quick_checkout_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wcd-quick-checkout-wrap button',
            ]
        );

        $element->end_controls_tab();

        $element->start_controls_tab(
            'quick_checkout_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $element->add_control(
            'quick_checkout_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wcd-quick-checkout-wrap button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $element->add_control(
            'quick_checkout_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wcd-quick-checkout-wrap button:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'quick_checkout_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wcd-quick-checkout-wrap button:hover',
            ]
        );

        $element->end_controls_tab();
        $element->end_controls_tabs();

        $element->add_control(
			'quick_checkout_modal_heading',
			[
				'label' 	=> __( 'Popup Modal', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$element->add_control(
			'quick_checkout_modal_active_mode',
			[
				'label' 	=> __( 'Active Mode', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Show', 'woolementor-pro' ),
				'label_off' => __( 'Hide', 'woolementor-pro' ),
				'return_value' => 'yes',
				'default' 	=> '',
			]
		);

		$element->add_control(
			'quick_checkout_modal_overlay_heading',
			[
				'label' 	=> __( 'Overlay Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'quick_checkout_card_overlay',
                'label'     => __( 'Overlay Color', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl .wcd-quick-checkout-wrapper',
            ]
        );

        $element->add_responsive_control(
            'quick_checkout_card_width',
            [
                'label'     => __( 'Modal Width', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em', '%' ],
                'selectors' => [
                    '.wl .wcd-quick-checkout-wrap-panel' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 300,
                        'max'   => 1000
                    ],
                    'em'    => [
                        'min'   => 10,
                        'max'   => 50
                    ],
                    '%'    => [
                        'min'   => 10,
                        'max'   => 100
                    ],
                ],
				'separator' => 'before',
            ]
        );

        $element->add_responsive_control(
            'quick_checkout_card_height',
            [
                'label'     => __( 'Modal Height', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em', '%' ],
                'selectors' => [
                    '.wl .wcd-quick-checkout-wrap-panel' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 300,
                        'max'   => 1000
                    ],
                    'em'    => [
                        'min'   => 10,
                        'max'   => 50
                    ],
                    '%'    => [
                        'min'   => 10,
                        'max'   => 100
                    ],
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'quick_checkout_card_background',
                'label'     => __( 'Background', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl .wcd-quick-checkout-wrap-panel',
                'fields_options' => [
                    'background' =>[
                        'default' => 'classic'
                    ],
                    'color' =>[
                        'default' => '#fff'
                    ]
                ]
            ]
        );

        $element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'quick_checkout_card_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '.wl .wcd-quick-checkout-wrap-panel',
                'separator' => 'before',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top'       => '1',
                            'right'     => '1',
                            'bottom'    => '1',
                            'left'      => '1',
                            'isLinked'  => true,
                        ],
                    ],
                    'color' => [
                        'default' => 'var(--wl-light-gray)',
                    ],
                ],
			]
		);

		$element->add_responsive_control(
            'quick_checkout_card_border_radius',
            [
                'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%' ],
                'selectors' 	=> [
                    '.wl .wcd-quick-checkout-wrap-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $element->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'quick_checkout_card_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor-pro' ),
				'selector' 	=> '.wl .wcd-quick-checkout-wrap-panel',
			]
		);

		// $element->add_control(
		// 	'quick_checkout_modal_title',
		// 	[
		// 		'label' 	=> __( 'Title', 'woolementor-pro' ),
		// 		'type' 		=> Controls_Manager::HEADING,
		// 		'separator' => 'before',
		// 	]
		// );

  //       $element->add_control(
		// 	'quick_checkout_title_color',
		// 	[
		// 		'label' 	=> __( 'Title Color', 'woolementor-pro' ),
		// 		'type' 		=> Controls_Manager::COLOR,
  //               'selectors' => [
  //                   '.wl .wcd-quick-view-modal-heading' => 'color: {{VALUE}}',
  //               ],
  //               'default' => 'color: var(--wl-gray);'
		// 	]
		// );

		// $element->add_group_control(
		// 	Group_Control_Typography::get_type(),
		// 	[
		// 		'name' => 'quick_checkout_title_typography',
		// 		'label' => __( 'Typography', 'woolementor-pro' ),
		// 		'scheme' => Typography::TYPOGRAPHY_1,
		// 		'selector' => '.wl .wcd-quick-view-modal-heading',
  //               'fields_options'    => [
  //                   'typography'    => [ 'default' => 'yes' ],
  //                   'font_size'     => [ 'default' => [ 'size' => 15 ] ],
  //                   // 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
  //                   'font_family'   => [ 'default' => 'Montserrat' ],
  //                   'font_weight'   => [ 'default' => 500 ],
  //               ],
		// 	]
		// );

		$element->add_control(
			'quick_checkout_modal_close_icon',
			[
				'label' 	=> __( 'Close Icon', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $element->add_control(
			'quick_checkout_close_icon_color',
			[
				'label' 	=> __( 'Title Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
                'selectors' => [
                    '.wl .wcd-quick-view-modal-close' => 'color: {{VALUE}}',
                ],
                'default'   => '#100'
			]
		);

        $element->add_responsive_control(
            'quick_checkout_close_icon_size',
            [
                'label'     => __( 'Modal Width', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px' ],
                'selectors' => [
                    '.wl .wcd-quick-view-modal-close' => 'font-size: {{SIZE}}{{UNIT}} !important',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 5,
                        'max'   => 100
                    ]
                ],
            ]
        );

        $element->add_control(
            'quick_checkout_close_icon_offset_toggle',
            [
                'label' 		=> __( 'Offset', 'woolementor' ),
                'type' 			=> Controls_Manager::POPOVER_TOGGLE,
                'label_off' 	=> __( 'None', 'woolementor' ),
                'label_on' 		=> __( 'Custom', 'woolementor' ),
                'return_value' 	=> 'yes',
                'default'  => 'yes',
            ]
        );

        $element->start_popover();

        $element->add_responsive_control(
            'quick_checkout_close_icon_offset_x',
            [
                'label' 		=> __( 'Offset Left', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -500,
                        'max' 	=> 500,
                    ],
                ],
                'selectors'     => [
                    '.wl .wcd-quick-view-modal-close' => 'right: {{SIZE}}{{UNIT}}'
                ],
                'render_type' 	=> 'ui',
            ]
        );

        $element->add_responsive_control(
            'quick_checkout_close_icon_offset_y',
            [
                'label' 		=> __( 'Offset Top', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -500,
                        'max' 	=> 500,
                    ],
                ],
                'selectors' 	=> [
                    '.wl .wcd-quick-view-modal-close' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $element->end_popover();

		$element->add_control(
			'quick_checkout_modal_loader',
			[
				'label' 	=> __( 'Loader', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $element->add_control(
			'quick_checkout_close_loader_color',
			[
				'label' 	=> __( 'Loader Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
                'selectors' => [
                    '.wl .wcd-loader:after' => 'border-color: {{VALUE}} transparent {{VALUE}} transparent;',
                ],
                'default'   => '#fff'
			]
		);

        $element->add_responsive_control(
            'quick_checkout_close_loader_size',
            [
                'label'     => __( 'Loder Area', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px' ],
                'selectors' => [
                    '.wl .wcd-loader:after' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 100
                    ]
                ],
            ]
        );

        $element->add_responsive_control(
            'quick_checkout_close_loader_width',
            [
                'label'     => __( 'Loder Width', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px' ],
                'selectors' => [
                    '.wl .wcd-loader:after' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 100
                    ]
                ],
            ]
        );

        $element->end_controls_section();
	}

	public function restrict_render_section( $should_render, $object )	{

		$settings = $object->get_settings_for_display();
		if ( ! isset( $settings['enable_restriction'] ) || $settings['enable_restriction'] != 'yes' ) return $should_render;

		if( wcd_is_eligible( $settings ) ) return $should_render;

		wcd_render_message( $settings );
		
		return false;
	}

	public function restrict_render_widgets( $content, $widget )	{

		$settings = $widget->get_settings_for_display();

		if ( !isset( $settings['enable_restriction'] ) || $settings['enable_restriction'] != 'yes' ) return $content;

		if( wcd_is_eligible( $settings ) ) return $content;

		return wcd_render_message( $settings, false );
	}

	public function register_custom_endpoint(){

		$endpoints = get_option( '_wcd_my_account_tabs', [] );

		if ( empty( $endpoints ) ) return;
		
		foreach ( $endpoints as $endpoint => $label ) {
			add_rewrite_endpoint( $endpoint, EP_ROOT | EP_PAGES );
		}

		flush_rewrite_rules();
	}
	
	/**
	 * Quick view button
	 *
	 * @since 3.0
	 * @author Al Imran Akash<alimranakash.bd@gmail@gmail.com>
	 */
	public function quick_view_button( $product, $widget_id, $settings ) {
		if ( $settings['quick_view_show_hide'] != 'yes' ) return;

		$product_id 	= $product->get_id();
		$_icon      	= $settings['quickview_icon'];
		$icon       	= $_icon['value'];
		$template_id 	= $settings['quick_view_template'];

		echo "<div class='wcd-quick-view-wrap'>";
		echo "<button data-product_id='{$product_id}' data-template_id='{$template_id}'><i class='". esc_attr( $icon ) ."'></i></button>";
		echo "</div>";

		$_config = [
        	'active_mode' => $settings['quickview_modal_active_mode'],
        ];

        if ( wcd_is_edit_mode() ) {
        	?>
			<script>
				jQuery(function($){
					var config 	= <?php echo json_encode( $_config ); ?>;

					if ( config.active_mode == 'yes' ) {
						$('.wl-sc-single-product.wl-sc-left:first-child .wcd-quick-view-wrap button').trigger('click');
					}
					else {
						$('.wcd-quick-view-modal').removeClass('is-visible');
					}
				})
			</script>
			<?php
        }
	}
	
	/**
	 * Quick checkout button
	 *
	 * @since 3.0
	 * @author Al Imran Akash<alimranakash.bd@gmail@gmail.com>
	 * @param $product, $widget_id, $settings
	 */
	public function quick_checkout_button( $product, $widget_id, $settings ) {
		if ( ! is_woocommerce_activated() ) return;
		if ( $settings['quick_checkout_show_hide'] != 'yes' ) return;

		$product_id 	= $product->get_id();
		$_icon      	= $settings['quick_checkout_icon'];
		$icon       	= $_icon['value'];

		$template_id 	= wc_get_page_id( 'checkout' );

		echo "<div class='wcd-quick-checkout-wrap'>";
		echo "<button class='wcd-quick-checkout-button' data-product_id='{$product_id}' data-template_id='{$template_id}'><i class='". esc_attr( $icon ) ."'></i></button>";
		echo "</div>";
	}

	/**
	 * Quick checkout render
	 *
	 * @since 3.0
	 * @author Al Imran Akash<alimranakash.bd@gmail@gmail.com>
	 */
	public function quick_checkout_render( $config ) {
		if ( ! is_woocommerce_activated() ) return;
		if( did_action( 'wcd_quick_checkout_loaded' ) ) return;

		if ( wcd_is_preview_mode() || wcd_is_edit_mode() ) {
			$visible = '';
			$display = 'none';
			if ( $config != '' ) {
				if ( 'yes' == $config['active_mode'] ) {
					$visible = 'is-visible';
					$display = '';
				}
			}

			echo "<div class='wcd-quick-checkout-wrapper ". esc_attr( $visible ) ."' style='display: {$display} ;'>";
			echo "<div class='wcd-quick-checkout-wrapper-overlay'></div>";
			echo "<div class='wcd-quick-checkout-wrap-panel'>";
			echo "<button class='wcd-quick-view-modal-close wcd-quick-view-wrap'>x</button>";

			$template_id = wc_get_page_id( 'checkout' );
			
			echo Elementor::$instance->frontend->get_builder_content( $template_id );

			echo "</div>";
			echo "</div>";

			?>
			<script type="text/javascript">
				jQuery(function($){
					$(document).on("click",".wcd-quick-checkout-button",function(e){
						e.preventDefault();
						$('.wcd-loader-wrapper').show();

						var product_id 	= $(this).data('product_id');

						$.ajax({
							url: WOOLEMENTOR_PRO.ajaxurl,
							data: { 'action':'quick-checkout', 'product_id' : product_id, '_nonce' : WOOLEMENTOR_PRO._nonce },
							type: 'POST',
							dataType: 'JSON',
							success: function(resp) {
								$('.wcd-loader-wrapper').hide();

								$( document.body ).trigger( 'update_checkout' );

								$('.wcd-quick-checkout-wrapper').addClass('is-visible');
								$('.wcd-quick-checkout-wrapper').show();
							}
						});
					});
					
					$(document).on("click",".wcd-quick-view-modal-close",function(e){
						$('.wcd-quick-checkout-wrapper').removeClass('is-visible').hide();
					} );
				})
			</script>
			<?php
        }
        else {
        	add_action( 'wp_footer', function () {
				echo "<div class='wcd-quick-checkout-wrapper' style='display: none;'>";
				echo "<div class='wcd-quick-checkout-wrapper-overlay'></div>";
				echo "<div class='wcd-quick-checkout-wrap-panel'>";
				echo "<button class='wcd-quick-view-modal-close wcd-quick-view-wrap'>x</button>";

				$template_id 	= wc_get_page_id( 'checkout' );
				
				$checkout_html 	= Elementor::$instance->frontend->get_builder_content( $template_id );
				
				if ( in_array( $checkout_html, [ '', null ] ) ) {
					$checkout_html = do_shortcode('[woocommerce_checkout]');
				}

				echo $checkout_html;

				echo "</div>";
				echo "</div>";

				?>
				<script type="text/javascript">
					jQuery(function($){
						$(document).on("click",".wcd-quick-checkout-button",function(e){
							e.preventDefault();
							$('.wcd-loader-wrapper').show();

							var product_id 	= $(this).data('product_id');

							$.ajax({
								url: WOOLEMENTOR_PRO.ajaxurl,
								data: { 'action':'quick-checkout', 'product_id' : product_id, '_nonce' : WOOLEMENTOR_PRO._nonce },
								type: 'POST',
								dataType: 'JSON',
								success: function(resp) {
									$('.wcd-loader-wrapper').hide();

									$( document.body ).trigger( 'update_checkout' );

									$('.wcd-quick-checkout-wrapper').addClass('is-visible');
									$('.wcd-quick-checkout-wrapper').show();
								}
							});
						});
						
						$(document).on("click",".wcd-quick-view-modal-close",function(e){
							$('.wcd-quick-checkout-wrapper').removeClass('is-visible').hide();
						} );
					})
				</script>
				<?php
			} );
        }
		
		do_action( 'wcd_quick_checkout_loaded' );
	}
}