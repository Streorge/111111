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

class Email_Header extends Widget_Base {

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

	protected function get_nav_menu_index() {
		return $this->nav_menu_index++;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$placeholders = [ '%%order_id%%', '%%billing_first_name%%', '%%billing_last_name%%', '%%shipping_first_name%%', '%%shipping_last_name%%' ];
		$this->add_control(
			'important_note',
			[
				'label' => __( 'Important Note', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::RAW_HTML,
				'raw' 	=> sprintf( __( 'You can use the placeholders. %s. This will replace with actual order data.', 'woolementor-pro' ), "<code>" . implode( '</code> <code>' ,$placeholders ) . "</code>" ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			]
		);

		$this->add_control(
			'email_header_text',
			[
				'label' => __( 'Content', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Order ', 'woolementor-pro' ).'#%%order_id%%',
				'placeholder' => __( 'Type your title here', 'woolementor-pro' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label' 	=> __( 'HTML Tag', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::CHOOSE,
				'options' 	=> [
					'h1' 	=> [
						'title' => __( 'H1', 'woolementor-pro' ),
						'icon' 	=> 'eicon-editor-h1',
					],
					'h2' 	=> [
						'title' => __( 'H2', 'woolementor-pro' ),
						'icon' 	=> 'eicon-editor-h2',
					],
					'h3' 	=> [
						'title' => __( 'H3', 'woolementor-pro' ),
						'icon' 	=> 'eicon-editor-h3',
					],
					'h4' 	=> [
						'title' => __( 'H4', 'woolementor-pro' ),
						'icon' 	=> 'eicon-editor-h4',
					],
					'h5' 	=> [
						'title' => __( 'H5', 'woolementor-pro' ),
						'icon' 	=> 'eicon-editor-h5',
					],
					'h6' 	=> [
						'title' => __( 'H6', 'woolementor-pro' ),
						'icon' 	=> 'eicon-editor-h6',
					],
				],
				'toggle' => true,
			]
		);

		$this->add_control(
			'alignment',
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
					'{{WRAPPER}} .wl-email-header' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .wl-email-header .wleh-content' => 'text-align: {{VALUE}};'
				],
				'toggle' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'payment_default_styles',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'{{WRAPPER}} .wl-email-header h1' => 'margin: 0;',
					'{{WRAPPER}} .wl-email-header h2' => 'margin: 0;',
					'{{WRAPPER}} .wl-email-header h3' => 'margin: 0;',
					'{{WRAPPER}} .wl-email-header h4' => 'margin: 0;',
					'{{WRAPPER}} .wl-email-header h5' => 'margin: 0;',
					'{{WRAPPER}} .wl-email-header h6' => 'margin: 0;',
				],
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' 	=> __( 'Content Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'scheme' 	=> [
					'type' 	=> Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'default'	=> '#000',
				'selectors' => [
					'{{WRAPPER}} .wl-email-header' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-email-header .wleh-content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label' 	=> __( 'Background Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'scheme' 	=> [
					'type' 	=> Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'default'	=> 'transparent',
				'selectors' => [
					'{{WRAPPER}} .wl-email-header ' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_font_size',
			[
				'label' 	=> __( 'Font Size', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'range' 	=> [
					'px' => [
						'min' 	=> 0,
						'max' 	=> 100,
						'step' 	=> 1,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-email-header' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-email-header .wleh-content' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'selector' => '{{WRAPPER}} .wl-email-header',
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-email-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				// 'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-email-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' 		=> [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => true,
				]
				// 'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-email-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings 	= $this->get_active_settings();
		$order_id 	= wcd_is_edit_mode() || wcd_is_preview_mode() ? wcd_get_random_order_id() : wcd_get_current_order_id();
		$order 		= wc_get_order( $order_id );

		if ( ! is_a( $order, 'WC_Order' ) ) return;

		$_header 	= sanitize_text_field( $settings['email_header_text'] );
		$_html_tag 	= sanitize_text_field( $settings['html_tag'] );
		$start_tag 	= !empty( $_html_tag ) ? "<{$_html_tag} class='wleh-content'>" : "";
		$end_tag 	= !empty( $_html_tag ) ? "</{$_html_tag}>" : "";
		$targets    = [ '%%order_id%%', '%%billing_first_name%%', '%%billing_last_name%%', '%%shipping_first_name%%', '%%shipping_last_name%%' ];
		$replace 	= [ $order->get_id(), $order->get_billing_first_name(), $order->get_billing_last_name(), $order->get_shipping_first_name(), $order->get_shipping_last_name() ];

		$header 	= str_replace( $targets, $replace, $_header );
		
		echo "<div class='wl-email-header'>". wp_kses_post( $start_tag ) .esc_html( $header ) .wp_kses_post( $end_tag ) ."</div>";
	}
}