<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Plugin as Elementor;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Quick_Checkout_Button extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [];
	}

	public function get_style_depends() {
		return [];
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

		/**
		 * Quick CHeckout Button
		 */
		$this->start_controls_section(
			'wcd_qcb_section',
			[
				'label' 		=> __( 'Quick Checkout Button', 'woolementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'wcd_qcb_text',
			[
				'label' 		=> __( 'Button Text', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Buy Now', 'woolementor-pro' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor-pro' ),
			]
		);

		$this->add_responsive_control(
			'wcd_qcb_alignment',
			[
				'label'		=> __( 'Button Alignment', 'woolementor-pro' ),
				'type' 		=>Controls_Manager::CHOOSE,
				'options' 	=> [
					'left' 	=> [
						'title' 	=> __( 'Left', 'woolementor-pro' ),
						'icon' 		=> 'eicon-text-align-left',
					],
					'center' 	=> [
						'title' 	=> __( 'Center', 'woolementor-pro' ),
						'icon' 		=> 'eicon-text-align-center',
					],
					'right' 	=> [
						'title' 	=> __( 'Right', 'woolementor-pro' ),
						'icon' 		=> 'eicon-text-align-right',
					],
				],
				'default' 	=> 'left',
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-quick-checkout-button-wrap' => 'text-align: {{VALUE}}',
				],
			]
		);
		
        $this->add_control(
            'content_source',
            [
                'label'         => __( 'Content Source', 'woolementor' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'current_product'   => __( 'Current Product', 'woolementor' ),
                    'custom'            => __( 'Custom', 'woolementor' ),
                ],
                'default'       => 'current_product' ,
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'product_id',
            [
                'label'     => __( 'Product ID', 'woolementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => get_post_type( get_the_ID() ) == 'product' ? get_the_ID() : '',
                'description'  	=> __( 'Input the base product ID', 'woolementor' ),
                'condition'     => [
                    'content_source' => 'custom'
                ],
            ]
        );

		$this->add_control(
			'wcd_qcb_icon',
			[
				'label' => __( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'wcd_qcb_icon_align',
			[
				'label' => __( 'Icon Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'elementor' ),
					'right' => __( 'After', 'elementor' ),
				],
				'condition' => [
					'wcd_qcb_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * add to cart button
		 */
		$this->start_controls_section(
			'wcd_qcb_style',
			[
				'label' => __( 'Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'wcd_qcb_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wcd-quick-checkout-button',
			]
		);

		$this->start_controls_tabs(
			'wcd_qcb_button',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab( 
			'wcd_qcb_normal',
			[
				'label' 	=> __( 'Normal', 'woolementor-pro' ),
			]
		);

        $this->add_control(
			'wcd_qcb_color',
			[
				'label' 	=> __( 'Text Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-quick-checkout-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wcd_qcb_bg',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wcd-quick-checkout-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'wcd_qcb_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wcd-quick-checkout-button',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'wcd_qcb_hover',
			[
				'label' 	=> __( 'Hover', 'woolementor-pro' ),
			]
		);

        $this->add_control(
			'wcd_qcb_hover_color',
			[
				'label' 	=> __( 'Text Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-quick-checkout-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wcd_qcb_hover_bg',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wcd-quick-checkout-button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'wcd_qcb_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wcd-quick-checkout-button:hover',
			]
		);

		$this->add_control(
			'wcd_qcb_hover_transition',
			[
				'label' 	=> __( 'Transition Duration', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 3,
						'step' 	=> 0.1,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-quick-checkout-button:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wcd_qcb_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wcd-quick-checkout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'wcd_qcb_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wcd-quick-checkout-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wcd_qcb_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wcd-quick-checkout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wcd_qcb_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor-pro' ),
				'selector' => '.wl {{WRAPPER}} .wcd-quick-checkout-button',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! is_woocommerce_activated() ) return;
		$settings 	= $this->get_settings_for_display();
		extract( $settings );
		if ( 'current_product' == $content_source && is_product()  ) {
			global $product;
			$product_id = $product->get_id();
		}
		

		$this->render_editing_attributes();

		echo "<div class='wcd-quick-checkout-button-wrap'>";

		$left_icon 	= '';
		$right_icon = '';

		if ( 'left' == $wcd_qcb_icon_align ) {
			$left_icon = "<i class='". esc_attr( $wcd_qcb_icon['value'] ) ."'></i>";
		}
		else {
			$right_icon = "<i class='". esc_attr( $wcd_qcb_icon['value'] ) ."'></i>";
		}

		echo "<button {$this->get_render_attribute_string( 'wcd_qcb_text' )} data-product_id='{$product_id}' data-template_id=''><i class=''></i>".wp_kses_post( $left_icon ). esc_html( $settings['wcd_qcb_text'] ) .wp_kses_post( $right_icon )."</button>";

		echo "</div>";

		do_action( 'codesigner_quick_checkout' );
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'wcd_qcb_text', 'none' );
		$this->add_render_attribute( 'wcd_qcb_text', 'class', 'wcd-button wcd-quick-checkout-button' );
	}
}

