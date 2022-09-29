<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Helper as WCDH;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Shop_Flip extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		$this->id = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_PRO_DEBUG' ) && WOOLEMENTOR_PRO_DEBUG ? '' : '.min';

		wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}", 'fancybox' ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", 'fancybox' ];
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

		do_action( 'codesigner_before_shop_content_controls', $this );

		/**
		 * Settings controls
		 */
		$this->start_controls_section(
			'_section_settings',
			[
				'label' => __( 'Layout', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
		    'columns',
		    [
		        'label'     => __( 'Columns', 'woolementor' ),
		        'type'      => Controls_Manager::SELECT,
		        'options'   => [
		            1 => __( '1 Column', 'woolementor' ),
		            2 => __( '2 Columns', 'woolementor' ),
		            3 => __( '3 Columns', 'woolementor' ),
		            4 => __( '4 Columns', 'woolementor' ),
		        ],
		        'desktop_default'   => 3,
		        'tablet_default'    => 2,
		        'mobile_default'    => 1,
		        'style_transfer'    => true,
		        'selectors' => [
		            '.wl {{WRAPPER}} .cx-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(100px,1fr));',
		        ],
		    ]
		);

		$this->end_controls_section();

        do_action( 'codesigner_shop_query_controls', $this );

        /**
		 * Sale Ribbon controls
		 */
		$this->start_controls_section(
            'section_content_sale_ribbon',
            [
                'label' => __( 'Sale Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'sale_ribbon_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'sale_ribbon_text',
			[
				'label' 		=> __( 'On Sale Test', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Sale', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
			]
		);

		$this->end_controls_section();

        /**
         * Sale Ribbon controls
         */
        $this->start_controls_section(
            'section_content_stock',
            [
                'label' => __( 'Stock Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'stock_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'stock_ribbon_text',
            [
                'label'         => __( 'Text', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Out Of Stock', 'woolementor' ),
                'placeholder'   => __( 'Type your text here', 'woolementor' ),
                'condition' => [
                    'stock_show_hide' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();
		
		/**
		 * Cart controls
		 */
		$this->start_controls_section(
			'section_content_cart',
			[
				'label' => __( 'Cart Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'cart_show_hide',
			[
				'label'         => __( 'Show/Hide', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'woolementor-pro' ),
				'label_off'     => __( 'Hide', 'woolementor-pro' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->end_controls_section();
		
		/**
		 * Wishlist controls
		 */
		$this->start_controls_section(
			'section_content_wishlist',
			[
				'label' => __( 'Wishlist Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'wishlist_show_hide',
			[
				'label'         => __( 'Show/Hide', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'woolementor-pro' ),
				'label_off'     => __( 'Hide', 'woolementor-pro' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * view_details controls
		 */
		$this->start_controls_section(
			'section_content_view_details',
			[
				'label' => __( 'View Details Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'view_details_show_hide',
			[
				'label'         => __( 'Show/Hide', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'woolementor-pro' ),
				'label_off'     => __( 'Hide', 'woolementor-pro' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * Pagination controls
		 */
		$this->start_controls_section(
			'section_content_pagination',
			[
				'label' => __( 'Pagination', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
		        'condition'     => [
		            'product_source' => 'shop'
		        ],
			]
		);

		$this->add_control(
			'pagination_show_hide',
			[
				'label'         => __( 'Show/Hide', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'woolementor-pro' ),
				'label_off'     => __( 'Hide', 'woolementor-pro' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->end_controls_section();

		do_action( 'codesigner_after_shop_content_controls', $this );
		do_action( 'codesigner_before_shop_style_controls', $this );

		/**
		 * Product Style controls
		 */
		$this->start_controls_section(
			'style_section_box',
			[
				'label' => __( 'Edit Tab View', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_mode',
			[
				'label' => __( 'Show Front/Back', 'woolementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'front' => [
						'title' => __( 'Front', 'woolementor-pro' ),
						'icon' => 'fas fa-redo',
					],
					'back' => [
						'title' => __( 'Back', 'woolementor-pro' ),
						'icon' => 'fas fa-undo',
					],
				],
				'default' => 'front',
				'toggle' => true,
			]
		);

		$this->end_controls_section();

		/**
		 * Card Style
		 */
		$this->start_controls_section(
			'style_section_card',
			[
				'label' => __( 'Card', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		'product_card_transition',
			[
				'label' => __( 'Animation Speed', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range' => [
					's' => [
						'min' => 0.1,
						'max' => 5,
						'step' => 0.05,
					],
				],
				'default' => [
					'unit' => 's',
					'size' => 1,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-col .front,
					 {{WRAPPER}} .wl-sf-col .back,
					 {{WRAPPER}} .wl-sf-col .wl-sf-container.hover .front,
					 {{WRAPPER}} .wl-sf-col .wl-sf-container.hover .back' => '
					 transition: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
		    'gap',
		    [
		        'label'     => __( 'Gap Row', 'woolementor' ),
		        'type'      => Controls_Manager::SLIDER,
		        'size_units'=> [ 'px', '%', 'em' ],
		        'selectors' => [
		            '.wl {{WRAPPER}} .cx-grid' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
		        ],
		        'range'     => [
		            'px'    => [
		                'min'   => 1,
		                'max'   => 500
		            ],
		            'em'    => [
		                'min'   => 1,
		                'max'   => 30
		            ],
		        ],
		        'default' => [
		            'unit' => 'px',
		            'size' => 15,
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'gap_column',
		    [
		        'label'     => __( 'Gap Column', 'woolementor' ),
		        'type'      => Controls_Manager::SLIDER,
		        'size_units'=> [ 'px', '%', 'em' ],
		        'selectors' => [
		            '.wl {{WRAPPER}} .cx-grid' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
		        ],
		        'range'     => [
		            'px'    => [
		                'min'   => 1,
		                'max'   => 500
		            ],
		            'em'    => [
		                'min'   => 1,
		                'max'   => 30
		            ],
		        ],
		        'default' => [
		            'unit' => 'px',
		            'size' => 15,
		        ],
		    ]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-col .front,
					 {{WRAPPER}} .wl-sf-col .back,
					 {{WRAPPER}} .wl-sf-col .front:after ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Product front side background color
		 */
		$this->start_controls_section(
			'style_section_front_side_background',
			[
				'label' => __( 'Front Side Background', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'front_background',
				'label' => __( 'Front Side', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '.wl {{WRAPPER}} .wl-sf-col .front:after',
			]
		);

		$this->end_controls_section();

		/**
		 * Product back side background color
		 */
		$this->start_controls_section(
			'style_section_background',
			[
				'label' => __( 'Back Side Background', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'back_background',
				'label' => __( 'Back Side', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '.wl {{WRAPPER}} .wl-sf-col .back',
			]
		);

		$this->end_controls_section();

		/**
		 * Product Title
		 */
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Product Title', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'title_color',
				'selector' => '.wl {{WRAPPER}} .wl-sf-product-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '.wl {{WRAPPER}} .wl-sf-product-title',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 16 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Product Price
		 */
		$this->start_controls_section(
			'section_style_price',
			[
				'label' => __( 'Product Price', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-price' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-sf-product-price ins .amount, .wl-sf-product-price > .amount' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-sf-product-price .amount, .wl-sf-product-price > .amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'price_size_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '.wl {{WRAPPER}} .wl-sf-product-price ins .amount, {{WRAPPER}} .wl-sf-product-price > .amount',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'sale_price_show_hide',
			[
				'label'         => __( 'Show Sale Price', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'your-plugin' ),
				'label_off'     => __( 'Hide', 'your-plugin' ),
				'return_value'  => 'block',
				'default'       => 'none',
				'separator'     => 'before',
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-product-price del' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-price del  .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-sf-product-price del' => 'color: {{VALUE}}',
				],
				'condition' => [
					'sale_price_show_hide' => 'block'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'sale_price_size_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '.wl {{WRAPPER}} .wl-sf-product-price del span',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
				'condition' => [
					'sale_price_show_hide' => 'block'
				],
			]
		);



		$this->end_controls_section();

		/**
		 * Product Currency Symbol
		 */
		$this->start_controls_section(
			'section_style_currency',
			[
				'label' => __( 'Currency Symbol', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_currency',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'price_currency_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '.wl {{WRAPPER}} .woocommerce-Price-currencySymbol',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Product Image controls
		 */
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Product Image', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_thumbnail',
				'exclude'   => [ 'custom' ],
				'include'   => [],
				'default'   => 'large',
			]
		);

		$this->end_controls_section();

		/**
        * Sale Ribbon Styleing 
        */

		$this->start_controls_section(
            'section_style_sale_ribbon',
            [
                'label' => __( 'Sale Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
            'sale_ribbon_offset_toggle',
            [
                'label' 		=> __( 'Offset', 'woolementor' ),
                'type' 			=> Controls_Manager::POPOVER_TOGGLE,
                'label_off' 	=> __( 'None', 'woolementor' ),
                'label_on' 		=> __( 'Custom', 'woolementor' ),
                'return_value' 	=> 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'media_offset_x',
            [
                'label' 		=> __( 'Offset Left', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -1000,
                        'max' 	=> 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sf-corner-ribbon' => 'left: {{SIZE}}{{UNIT}}'
                ],
                'render_type' 	=> 'ui',
            ]
        );

        $this->add_responsive_control(
            'media_offset_y',
            [
                'label' 		=> __( 'Offset Top', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -1000,
                        'max' 	=> 1000,
                    ],
                ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sf-corner-ribbon' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();

        $this->add_responsive_control(
            'sale_ribbon_width',
            [
                'label'     => __( 'Width', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sf-corner-ribbon' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 50,
                        'max'   => 500
                    ]
                ],
            ]
        );

        $this->add_responsive_control(
            'sale_ribbon_transform',
            [
                'label'     => __( 'Transform', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sf-corner-ribbon' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 360
                    ]
                ],
            ]
        );

        $this->add_control(
            'sale_ribbon_font_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sf-corner-ribbon' => 'color: {{VALUE}}',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'content_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-sf-corner-ribbon',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 12 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'sale_ribbon_background',
			[
				'label' 		=> __( 'Background', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sf-corner-ribbon' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'sale_ribbon_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sf-corner-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default'       => [
                    'top'           => '0',
                    'right'         => '12',
                    'bottom'        => '0',
                    'left'          => '12',
                ],
                'separator' => 'after'
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 			=> 'sale_ribbon_border',
				'label' 		=> __( 'Border', 'woolementor' ),
				'selector' 		=> '.wl {{WRAPPER}} .wl-sf-corner-ribbon',
			]
		);

		$this->add_responsive_control(
            'sale_ribbon_border_radius',
            [
                'label' 		=> __( 'Border Radius', 'woolementor' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sf-corner-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

		/**
		* Stock Ribbon Styleing 
		*/

		$this->start_controls_section(
		    'section_style_stock_ribbon',
		    [
		        'label' => __( 'Stock Ribbon', 'woolementor' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		        'condition' => [
		            'stock_show_hide' => 'yes'
		        ],
		    ]
		);

		$this->add_control(
		    'stock_offset_toggle',
		    [
		        'label'         => __( 'Offset', 'woolementor' ),
		        'type'          => Controls_Manager::POPOVER_TOGGLE,
		        'label_off'     => __( 'None', 'woolementor' ),
		        'label_on'      => __( 'Custom', 'woolementor' ),
		        'return_value'  => 'yes',
		    ]
		);

		$this->start_popover();

		$this->add_responsive_control(
		    'stock_media_offset_x',
		    [
		        'label'         => __( 'Offset Left', 'woolementor' ),
		        'type'          => Controls_Manager::SLIDER,
		        'size_units'    => ['px'],
		        'condition'     => [
		            'stock_offset_toggle' => 'yes'
		        ],
		        'range'         => [
		            'px'        => [
		                'min'   => -1000,
		                'max'   => 1000,
		            ],
		        ],
		        'selectors'     => [
		            '.wl {{WRAPPER}} .wl-sf-stock' => 'right: {{SIZE}}{{UNIT}}'
		        ],
		        'render_type'   => 'ui',
		    ]
		);

		$this->add_responsive_control(
		    'stock_media_offset_y',
		    [
		        'label'         => __( 'Offset Top', 'woolementor' ),
		        'type'          => Controls_Manager::SLIDER,
		        'size_units'    => ['px'],
		        'condition'     => [
		            'stock_offset_toggle' => 'yes'
		        ],
		        'range'         => [
		            'px'        => [
		                'min'   => -1000,
		                'max'   => 1000,
		            ],
		        ],
		        'selectors'     => [
		            '.wl {{WRAPPER}} .wl-sf-stock' => 'top: {{SIZE}}{{UNIT}}',
		        ],
		    ]
		);
		$this->end_popover();

		$this->add_responsive_control(
		    'stock_ribbon_width',
		    [
		        'label'     => __( 'Width', 'woolementor' ),
		        'type'      => Controls_Manager::SLIDER,
		        'size_units'=> [ 'px', '%', 'em' ],
		        'selectors' => [
		            '.wl {{WRAPPER}} .wl-sf-stock' => 'width: {{SIZE}}{{UNIT}}',
		        ],
		        'range'     => [
		            'px'    => [
		                'min'   => 50,
		                'max'   => 500
		            ]
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'stock_ribbon_transform',
		    [
		        'label'     => __( 'Transform', 'woolementor' ),
		        'type'      => Controls_Manager::SLIDER,
		        'selectors' => [
		            '.wl {{WRAPPER}} .wl-sf-stock' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
		        ],
		        'range'     => [
		            'px'    => [
		                'min'   => 0,
		                'max'   => 360
		            ]
		        ],
		    ]
		);

		$this->add_control(
		    'stock_ribbon_font_color',
		    [
		        'label'     => __( 'Color', 'woolementor' ),
		        'type'      => Controls_Manager::COLOR,
		        'selectors' => [
		            '.wl {{WRAPPER}} .wl-sf-stock' => 'color: {{VALUE}}',
		        ],
		        'separator' => 'before'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name'      => 'stock_content_typography',
		        'label'     => __( 'Typography', 'woolementor' ),
		        'scheme'    => Typography::TYPOGRAPHY_3,
		        'selector'  => '.wl {{WRAPPER}} .wl-sf-stock',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 12 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
		    ]
		);

		$this->add_control(
		    'stock_ribbon_background',
		    [
		        'label'         => __( 'Background', 'woolementor' ),
		        'type'          => Controls_Manager::COLOR,
		        'selectors'     => [
		            '.wl {{WRAPPER}} .wl-sf-stock' => 'background: {{VALUE}}',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'stock_ribbon_padding',
		    [
		        'label'         => __( 'Padding', 'woolementor' ),
		        'type'          => Controls_Manager::DIMENSIONS,
		        'size_units'    => [ 'px', '%', 'em' ],
		        'selectors'     => [
		            '.wl {{WRAPPER}} .wl-sf-stock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'separator' => 'after'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name'          => 'stock_ribbon_border',
		        'label'         => __( 'Border', 'woolementor' ),
		        'selector'      => '.wl {{WRAPPER}} .wl-sf-stock',
		    ]
		);

		$this->add_responsive_control(
		    'stock_ribbon_border_radius',
		    [
		        'label'         => __( 'Border Radius', 'woolementor' ),
		        'type'          => Controls_Manager::DIMENSIONS,
		        'size_units'    => [ 'px', '%' ],
		        'selectors'     => [
		            '.wl {{WRAPPER}} .wl-sf-stock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_section();

		/*
		*Product Short Description
		*/

		$this->start_controls_section(
			'section_short_description',
			[
				'label' => __( 'Short Description', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'short_description_show_hide',
			[
				'label'         => __( 'Show Content', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'your-plugin' ),
				'label_off'     => __( 'Hide', 'your-plugin' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'short_description_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '.wl {{WRAPPER}} .wl-sf-short-description',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		); 

		$this->add_control(
			'short_description_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-short-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'short_description_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-short-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_desc_words_count',
			[
				'label'         => __( 'Words Count', 'woolementor-pro' ),
				'type'          => Controls_Manager::NUMBER,
				'default'       => 20,
			]
		);

		$this->end_controls_section();

		/**
		 * Details Button controll
		 */
		$this->start_controls_section(
			'section_style_view_details',
			[
				'label' => __( 'View Details Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'     => [
					'view_details_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'view_details_icon',
			[
				'label' 	=> __( 'Icon', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' 	=> 'fa fa-eye',
					'library' 	=> 'solid',
				],
			]
		);

		$this->add_responsive_control(
			'view_details_icon_size',
			[
				'label'     => __( 'Icon Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-view i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'view_details_area_size',
			[
				'label'     => __( 'Area Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-view a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'view_details_area_line_height',
			[
				'label'     => __( 'Line Height', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-view a' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view_details_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-product-view a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view_details_padding',
			[
				'label'         => __( 'Padding', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-product-view a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view_details_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-product-view a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'view_details_icon_normal_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'view_details_icon_normal',
			[
				'label'     => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'view_details_icon_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-view a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'view_details_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-view a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'view_details_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-sf-product-view a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'view_details_icon_hover',
			[
				'label'     => __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'view_details_icon_color_hover',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-view a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'view_details_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-view a:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'view_details_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-sf-product-view a:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Wishlist Button
		 */
		$this->start_controls_section(
			'section_style_wishlist',
			[
				'label' => __( 'Wishlist Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'     => [
					'wishlist_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
            'wishlist_icon',
            [
                'label'         => __( 'Icon', 'woolementor' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'eicon-heart',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'heart',
                    ],
                    'fa-solid'  => [
                        'heart',
                        'heart-broken',
                        'heartbeat',
                    ]
                ]
            ]
        );

		$this->add_responsive_control(
			'wishlist_icon_size',
			[
				'label'     => __( 'Icon Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'wishlist_area_size',
			[
				'label'     => __( 'Area Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-fav a.ajax_add_to_wish' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wishlist_area_line_height',
			[
				'label'     => __( 'Line Height', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-product-fav a' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'wishlist_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-product-fav a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'wishlist_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-product-fav a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
            'wishlist__separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'wishlist_normal',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sf-product-fav a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sf-product-fav a' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sf-product-fav a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'wishlist_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sf-product-fav a:hover' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sf-product-fav a.ajax_add_to_wish.fav-item' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sf-product-fav a:hover' => 'background: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sf-product-fav a.ajax_add_to_wish.fav-item' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sf-product-fav a:hover, {{WRAPPER}} .wl-sf-product-fav a.ajax_add_to_wish.fav-item',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Cart Button
		 */
		$this->start_controls_section(
			'section_style_cart',
			[
				'label' => __( 'Cart Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'     => [
				    'cart_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
            'cart_icon',
            [
                'label'         => __( 'Icon', 'woolementor' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'eicon-cart-solid',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'luggage-cart',
                        'opencart',
                    ],
                    'fa-solid'  => [
                        'shopping-cart',
                        'cart-arrow-down',
                        'cart-plus',
                        'luggage-cart',
                    ]
                ]
            ]
        );

		$this->add_responsive_control(
			'cart_icon_size',
			[
				'label'     => __( 'Icon Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'cart_area_size',
			[
				'label'     => __( 'Area Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-cart a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cart_area_line_height',
			[
				'label'     => __( 'Line Height', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-cart a' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cart_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-sf-cart .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'cart_padding',
			[
				'label'         => __( 'Padding', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'cart_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'cart_normal_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'cart_normal',
			[
				'label'     => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'cart_icon_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-cart a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-cart a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-sf-cart a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cart_hover',
			[
				'label'     => __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'cart_icon_color_hover',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-cart a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-cart a:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-sf-cart a:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cart_view_cart',
			[
				'label'     => __( 'View Cart', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'cart_view_cart_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-cart .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_view_cart_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-cart .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_view_cart_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-sf-cart .added_to_cart.wc-forward::after',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		
		/**
		 * Pagination controll
		 */
		$this->start_controls_section(
			'section_style_pagination',
			[
				'label' => __( 'Pagination', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
		        'condition'     => [
		            'pagination_show_hide' => 'yes',
		            'product_source' => 'shop'
		        ],
			]
		);

		$this->add_control(
			'pagination_alignment',
			[
				'label'     => __( 'Alignment', 'woolementor-pro' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'      => [
						'title'     => __( 'Left', 'woolementor-pro' ),
						'icon'      => 'eicon-text-align-left',
					],
					'center'    => [
						'title'     => __( 'Center', 'woolementor-pro' ),
						'icon'      => 'eicon-text-align-center',
					],
					'right'     => [
						'title'     => __( 'Right', 'woolementor-pro' ),
						'icon'      => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'toggle'    => true,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-pagination' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
		    'pagination_gap',
		    [
		        'label'     => __( 'Gap with shop', 'woolementor' ),
		        'type'      => Controls_Manager::SLIDER,
		        'size_units'=> [ 'px', 'em' ],
		        'selectors' => [
		            '.wl {{WRAPPER}} .wl-sf-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
		        ],
		        'default' =>[
		            'unit' => 'px',
		            'size' => 20
		        ]
		    ]
		);

		$this->add_control(
			'pagination_left_icon',
			[
				'label' 	=> __( 'Left Icon', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' 	=> 'eicon-chevron-left',
					'library' 	=> 'solid',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'pagination_right_icon',
			[
				'label' 	=> __( 'Right Icon', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' 	=> ' eicon-chevron-right',
					'library' 	=> 'solid',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_icon_size',
			[
				'label'     => __( 'Font Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_item_padding',
			[
				'label'         => __( 'Padding', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		

		$this->start_controls_tabs(
			'pagination_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'pagination_normal_item',
			[
				'label'     => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pagination_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-sf-pagination .page-numbers',
			]
		);

		$this->add_responsive_control(
			'pagination_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_current_item',
			[
				'label'     => __( 'Active', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'pagination_current_item_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers.current' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_current_item_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers.current' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pagination_current_item_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-sf-pagination .page-numbers.current',
			]
		);

		$this->add_responsive_control(
			'pagination_current_item_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'pagination_hover',
			[
				'label'     => __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'pagination_hover_item_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_hover_item_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pagination_hover_item_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-sf-pagination .page-numbers:hover',
			]
		);

		$this->add_responsive_control(
			'pagination_hover_item_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pagination_hover_transition',
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
					'.wl {{WRAPPER}} .wl-sf-pagination .page-numbers:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		do_action( 'codesigner_after_shop_style_controls', $this );
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
        $widget_id  = $this->id;
		extract( $settings );

		$hover_mode = $settings['hover_mode'] == 'back' && wcd_is_edit_mode() ? 'hover' : '';

        $data = [
            'sale_ribbon_text'              => $sale_ribbon_text,
            'stock_ribbon_text'             => $stock_ribbon_text,
            'woolementor_condition_list'    => $woolementor_condition_list,
            'custom_query'                  => $custom_query,
            'columns'                       => $columns,
            'hover_mode'                	=> $hover_mode,
            'short_description_show_hide'   => $short_description_show_hide,
            'view_details_show_hide'   		=> $view_details_show_hide,
            'product_desc_words_count'   	=> $product_desc_words_count,
            'view_details_icon'   			=> $view_details_icon,
            'product_source'                => $product_source,
            'content_source'                => $content_source,
            'main_product_id'               => $main_product_id,
            'product_limit'                 => $product_limit,
            'ns_exclude_products'           => $ns_exclude_products,
            'number'                        => $number,
            'order'                         => $order,
            'orderby'                       => $orderby,
            'author'                        => $author,
            'categories'                    => $categories,
            'exclude_categories'            => $exclude_categories,
            'include_products'              => $include_products,
            'exclude_products'              => $exclude_products,
            'sale_products_show_hide'       => $sale_products_show_hide,
            'out_of_stock'                  => $out_of_stock,
            'offset'                        => $offset,
            'sale_ribbon_show_hide'         => $sale_ribbon_show_hide,
            'stock_show_hide'               => $stock_show_hide,
            'cart_show_hide'                => $cart_show_hide,
            'wishlist_show_hide'            => $wishlist_show_hide,
            'pagination_show_hide'          => $pagination_show_hide,
            'image_thumbnail_size'          => $image_thumbnail_size,
            'quick_view_show_hide'          => $quick_view_show_hide,
            'wishlist_icon'                 => $wishlist_icon,
            'cart_icon'                     => $cart_icon,
            'pagination_left_icon'          => $pagination_left_icon,
            'pagination_right_icon'         => $pagination_right_icon,
        ];

        if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
            $wishlist_show_hide = 'no';
        }

        do_action( 'codesigner_before_main_content' );
        
        echo '<div class="wl-shop wl-'. esc_attr( $widget_id ) .'" data-settings="'. esc_attr( serialize( $data ) ) .'">';
        echo Helper::get_template( 'template', "widgets/{$this->id}", [ 'widget_id' => $widget_id, 'settings' => $settings ] );
        echo '</div>';


        update_post_meta( get_the_ID(), 'codesigner_quick_checkout', 0 );
        if ( wcd_is_pro_activated() && 'yes' == $quick_checkout_show_hide ) {
            $config = [
                'active_mode' => $quick_checkout_modal_active_mode
            ];
            do_action( 'codesigner_quick_checkout', $config );

            update_post_meta( get_the_ID(), 'codesigner_quick_checkout', 1 );
        }

        do_action( 'codesigner_after_main_content' );
	}
}