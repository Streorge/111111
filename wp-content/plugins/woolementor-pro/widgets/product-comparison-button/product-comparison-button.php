<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Product_Comparison_Button extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}" ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}" ];
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
		 * Button
		 */
		$this->start_controls_section(
			'_sectio_comparison_button',
			[
				'label' 		=> __( 'Button', 'woolementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'content_source',
            [
                'label'     => __( 'Content Source', 'woolementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                	'current' 	=> __( 'Current Product', 'woolementor-pro' ),
                	'custom' 	=> __( 'Custom Product', 'woolementor-pro' ),
                ],
                'default' 	=> 'current'
            ]
        );
		$this->add_control(
            'product_id',
            [
                'label' 	=> __( 'Product ID', 'woolementor-pro' ),
                'type' 		=> Controls_Manager::NUMBER,
                'default' 	=> get_the_ID(),
                'condition'	=> [
                	'content_source' => 'custom'
                ]
            ]
        );

		$this->add_control(
            'button_text',
            [
                'label' 	=> __( 'Text', 'woolementor-pro' ),
                'type' 		=> Controls_Manager::TEXT,
                'default' 	=> 'Product Comparison',
                'separator'	=> 'before'
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'         => __( 'Product Compare Page', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'options'       => wcd_get_pages(),
                'label_block'	=> true,
                'description'	=> __( 'Set a page which you created to show product comparison', 'woolementor-pro' )
            ]
        );

        $this->add_control(
            'btn_action_type',
            [
                'label'     => __( 'Action After Add', 'woolementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                	'stay'		=> __( 'Stay On This page', 'woolementor-pro' )	,
                	'redirect'	=> __( 'Redirect to Compare Page', 'woolementor-pro' )	,
                ],
                'default'	=> 'stay',
                'label_block'	=> true,
            ]
        );

        $this->add_responsive_control(
            'comparison_button_align',
            [
                'label' 		=> __( 'Alignment', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'options' 		=> [
                    'left' 		=> [
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
                'toggle' 		=> true,
                'default' 		=> 'left',
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-product-comparison-panel' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        /**
		 * Product Title Style
		 */
		$this->start_controls_section(
			'section_comparison_button_style',
			[
				'label' => __( 'Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wl-product-comparison-button',
			]
		);

		$this->add_control(
			'comparison_button_color',
			[
				'label' 	=> __( 'Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'global' 	=> [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'default'   => '#fff',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-comparison-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'comparison_button_background',
			[
				'label' => __( 'Background Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' 	=> [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'default'   => '#61CE70',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-comparison-button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'comparison_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-comparison-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default'       => [
                    'top'           => '10',
                    'right'         => '10',
                    'bottom'        => '10',
                    'left'          => '10',
                ],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'comparison_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-comparison-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'comparison_button_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-product-comparison-button',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'comparison_button_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-product-comparison-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'comparison_button_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor-pro' ),
				'selector' => '.wl {{WRAPPER}} .wl-product-comparison-button',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		global $product;

		if ( ! is_woocommerce_activated() ) return;

		$settings 	= $this->get_settings_for_display();
		$product 	= wc_get_product();

		if ( $settings['content_source'] == 'custom' ) {
			$product_id = codesigner_sanitize_number( $settings['product_id'] );
			$product 	= wc_get_product( $product_id );
			if ( empty( $product ) ) {
				_e( 'Invalid Product ID', 'woolementor' );
				return;
			}
		}

		if ( empty( $product ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
			$product_id = wcd_get_product_id();
			$product 	= wc_get_product( $product_id );
		}

		if ( empty( $product ) ) {
			return;
		}

		$product_id = $product->get_id();

        $this->add_render_attribute( 'button_text', 'class', 'wl-product-comparison-button' );

        $compare_key = wcd_compare_cookie_key();
        $products = [];
        if ( isset( $_COOKIE[ $compare_key ] ) ) {
            $_products 	= $_COOKIE[ $compare_key ];
            $products   = $_products ? unserialize( $_products ) : [];
        }

        $btn_text 			= esc_html( $settings['button_text'] );
        $compare_page_url 	= esc_url( get_permalink( $settings['button_link'] ) );
        if ( in_array( $product_id, $products ) ) {
        	$btn_text = "<a href='{$compare_page_url}'>". __( 'View Table', 'woolementor-pro' ) ."</a>";
        }

        echo '<div class="wl-product-comparison-panel">';
    	printf( '<button %s data-url="%s" data-action="%s" data-product="%d">%s</button>',
            $this->get_render_attribute_string( 'button_text' ),
            $compare_page_url,
	        esc_attr( $settings['btn_action_type'] ),
	        $product_id,
	        $btn_text
        );
        echo '</div>';
	}
}