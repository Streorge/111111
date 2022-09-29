<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Responsive\Responsive;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Email_Description extends Widget_Base {

	public $id;
	protected $nav_menu_index = 1;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_PRO_DEBUG' ) && WOOLEMENTOR_PRO_DEBUG ? '' : '.min';
		// wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
		// wp_register_script( "woolementor-{$this->id}", plugins_url( "assets/js/script{$min}.js", __FILE__ ), ['jquery'], '1.1', true );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}", "woolementor-{$this->id}-smartmenus" ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", "woolementor-{$this->id}-sm-blue" ];
	}

	public function get_name() {
		return $this->id;
	}

	public function get_title() {
		return $this->widget['title'];
	}

	public function get_icon() {
		return $this->widget['icon'];
	}

	public function get_categories() {
		return $this->widget['categories'];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_description_layout',
			[
				'label' => __( 'Layout', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$placeholders = [ '%%order_id%%', '%%billing_first_name%%', '%%billing_last_name%%', '%%shipping_first_name%%', '%%shipping_last_name%%' ];
		$this->add_control(
			'email_description_important_note',
			[
				'label' => __( 'Important Note', 'plugin-name' ),
				'type' 	=> Controls_Manager::RAW_HTML,
				'raw' 	=> sprintf( __( 'You can use the placeholders. %s. This will replace with actual order data.', 'woolementor-pro' ), "<code>" . implode( '</code> <code>' ,$placeholders ) . "</code>" ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			]
		);

		$this->add_control(
			'email_description',
			[
				'label' 		=> __( 'Description', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'woolementor-pro' ),
				'placeholder' 	=> __( 'Type your description here', 'woolementor-pro' ),
				'label_block' 	=> true
			]
		);

		$this->add_control(
			'email_description_alignment',
			[
				'label' 	=> __( 'Alignment', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'woolementor-pro' ),
						'icon' 	=> 'eicon-text-align-left',
					],
					'center' 	=> [
						'title' => __( 'Center', 'woolementor-pro' ),
						'icon' 	=> 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'woolementor-pro' ),
						'icon' 	=> 'eicon-text-align-right',
					],
				],
				'selectors' =>[
					'{{WRAPPER}} .wl-email-description' => 'text-align: {{VALUE}};',
				],
				'toggle' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'email_description_section_style',
			[
				'label' => __( 'Style', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'email_description_color',
			[
				'label' 	=> __( 'Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-email-description' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-email-description .wleh-content' => 'color: {{VALUE}}',
				],
				'default'	=> '#000'
			]
		);

		$this->add_control(
			'email_description__bg_color',
			[
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-email-description ' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'email_description__font_size',
			[
				'label' 	=> __( 'Font Size', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'range' 	=> [
					'px' => [
						'min' 	=> 0,
						'max' 	=> 1000,
						'step' 	=> 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-email-description' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-email-description .wleh-content' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'email_description_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'selector' => '{{WRAPPER}} .wl-email-description',
			]
		);

		$this->add_responsive_control(
			'email_description_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-email-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				// 'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'email_description_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-email-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'email_description_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-email-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				// 'separator'		=> 'before',
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings 	= $this->get_active_settings();
		$order_id 	= wcd_is_edit_mode() || wcd_is_preview_mode() ? wcd_get_random_order_id() : wcd_get_current_order_id();

		$order 		= wc_get_order( $order_id );

		if ( ! is_a( $order, 'WC_Order' ) ) return;

		extract( $settings );

		$targets    = [ '%%order_id%%', '%%billing_first_name%%', '%%billing_last_name%%', '%%shipping_first_name%%', '%%shipping_last_name%%' ];
		$replace 	= [ $order->get_id(), $order->get_billing_first_name(), $order->get_billing_last_name(), $order->get_shipping_first_name(), $order->get_shipping_last_name() ];

		$description 	= str_replace( $targets, $replace, $settings['email_description'] );

		echo "<div class='wl-email-description'>". esc_html( $description ) ."</div>";
	}
}