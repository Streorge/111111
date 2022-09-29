<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Related_Products_flip extends Widget_Base {

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
		            1 => __( '1 Columns', 'woolementor' ),
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

		/**
         * Query controls
         */
        $this->start_controls_section(
            'query',
            [
                'label' => __( 'Product Query', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_source',
            [
                'label' => __( 'Content Source', 'woolementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'current_product'   => __( 'Current Product', 'woolementor-pro' ),
                    'cart_items'        => __( 'Cart Items', 'woolementor' ),
                    'custom'     		=> __( 'Custom', 'woolementor-pro' ),
                ],
                'default' => 'current_product' ,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'main_product_id',
            [
                'label'     => __( 'Product ID', 'woolementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => get_post_type( get_the_ID() ) == 'product' ? get_the_ID() : '',
                'description'  => __( 'Input the base product ID', 'woolementor-pro' ),
                'condition'     => [
                    'content_source' => 'custom'
                ],
            ]
        );

        $this->add_control(
            'product_limit',
            [
                'label'     => __( 'Products Limit', 'woolementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3,
                'separator' => 'before',
                'description'  => __( 'Number of related products to show', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'exclude_products',
            [
                'label'     => __( 'Exclude Products', 'woolementor-pro' ),
                'type'      => Controls_Manager::TEXT,
                'description'  => __( "Comma separated ID's of products that should be excluded", 'woolementor-pro' ),
            ]
        );

        $this->end_controls_section();

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
					'{{WRAPPER}} .wl-rpf-col .front,
					 {{WRAPPER}} .wl-rpf-col .back,
					 {{WRAPPER}} .wl-rpf-col .wl-rpf-container.hover .front,
					 {{WRAPPER}} .wl-rpf-col .wl-rpf-container.hover .back' => '
					 transition: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-col .front,
					 {{WRAPPER}} .wl-rpf-col .back,
					 {{WRAPPER}} .wl-rpf-col .front:after ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .wl-rpf-col .front:after',
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
				'selector' => '{{WRAPPER}} .wl-rpf-col .back',
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
				'selector' => '{{WRAPPER}} .wl-rpf-product-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .wl-rpf-col .front .inner p.wl-rpf-product-title',
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
					'{{WRAPPER}} .wl-rpf-product-price' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-rpf-product-price ins .amount, .wl-rpf-product-price > .amount' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-rpf-product-price .amount, .wl-rpf-product-price > .amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'price_size_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .wl-rpf-product-price ins .amount, .wl-rpf-product-price > .amount',
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
					'{{WRAPPER}} .wl-rpf-product-price del' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rpf-product-price del  .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-rpf-product-price del' => 'color: {{VALUE}}',
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
				'selector'  => '{{WRAPPER}} .wl-rpf-product-price del span',
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
					'{{WRAPPER}} .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'price_currency_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .woocommerce-Price-currencySymbol',
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
                    '{{WRAPPER}} .wl-sc-corner-ribbon' => 'left: {{SIZE}}{{UNIT}}'
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
                    '{{WRAPPER}} .wl-sc-corner-ribbon' => 'top: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .wl-sc-corner-ribbon' => 'width: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .wl-sc-corner-ribbon' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
                    '{{WRAPPER}} .wl-sc-corner-ribbon' => 'color: {{VALUE}}',
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
				'selector' 	=> '{{WRAPPER}} .wl-sc-corner-ribbon',
			]
		);

		$this->add_control(
			'sale_ribbon_background',
			[
				'label' 		=> __( 'Background', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sc-corner-ribbon' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .wl-sc-corner-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' 		=> '{{WRAPPER}} .wl-sc-corner-ribbon',
			]
		);

		$this->add_responsive_control(
            'sale_ribbon_border_radius',
            [
                'label' 		=> __( 'Border Radius', 'woolementor' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%' ],
                'selectors' 	=> [
                    '{{WRAPPER}} .wl-sc-corner-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector'  => '{{WRAPPER}} .wl-rpf-short-description',
			]
		); 

		$this->add_control(
			'short_description_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rpf-short-description' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .wl-rpf-short-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-product-view i' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-rpf-product-view a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-product-view a' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-product-view a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-product-view a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-product-view a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-product-view a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'view_details_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rpf-product-view a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'view_details_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} .wl-rpf-product-view a',
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
					'{{WRAPPER}} .wl-rpf-product-view a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'view_details_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rpf-product-view a:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'view_details_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} .wl-rpf-product-view a:hover',
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
				'label' 	=> __( 'Icon', 'woolementor-pro' ),
				'type' 		=>Controls_Manager::ICONS,
				'default' 	=> [
					'value' 	=> 'eicon-heart',
					'library' 	=> 'solid',
				],
			]
		);

		$this->add_responsive_control(
			'wishlist_icon_size',
			[
				'label'     => __( 'Icon Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-rpf-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-rpf-product-fav a.ajax_add_to_wish' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-product-fav a' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-product-fav a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-product-fav a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-product-fav a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wishlist_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rpf-product-fav a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'wishlist_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} .wl-rpf-product-fav a',
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
                    '{{WRAPPER}} .wl-rpf-product-fav a:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wl-rpf-product-fav a.ajax_add_to_wish.fav-item' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpf-product-fav a:hover' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .wl-rpf-product-fav a.ajax_add_to_wish.fav-item' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '{{WRAPPER}} .wl-rpf-product-fav a:hover, {{WRAPPER}} .wl-rpf-product-fav a.ajax_add_to_wish.fav-item',
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
				'condition' => [
                    'cart_show_hide' => 'yes'
                ],
			]
		);

		$this->add_control(
			'cart_icon',
			[
				'label' 	=> __( 'Icon', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' 	=> 'eicon-cart-solid',
					'library' 	=> 'solid',
				],
			]
		);

		$this->add_responsive_control(
			'cart_icon_size',
			[
				'label'     => __( 'Icon Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-rpf-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-rpf-cart a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-cart a' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wl-rpf-cart .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rpf-cart a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rpf-cart a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} .wl-rpf-cart a',
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
					'{{WRAPPER}} .wl-rpf-cart a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rpf-cart a:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} .wl-rpf-cart a:hover',
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
					'{{WRAPPER}} .wl-rpf-cart .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_view_cart_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rpf-cart .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_view_cart_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} .wl-rpf-cart .added_to_cart.wc-forward::after',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
		extract( $settings );

		if ( ! is_woocommerce_activated() ) return;

		/**
		 * Load attributes
		 */
		$this->render_editing_attributes();

		if ( 'cart_items' == $content_source ) {
            $related_product_ids = wcd_get_cart_related_products( $product_limit );
        }
        else {
			$exclude_products_array = explode( ',', $exclude_products );
			$related_product_ids    = wc_get_related_products( $main_product_id, $product_limit, $exclude_products_array );
        }

		$hover_mode = $settings['hover_mode'] == 'back' && wcd_is_edit_mode() ? 'hover' : '';
		
		?>
		
		<div class="wl-rpf-cols cx-grid">
			<?php
			if( count( $related_product_ids ) > 0 ) : 
				foreach( $related_product_ids as $product_id ) :
					$product    = wc_get_product( $product_id );
					$thumbnail  = get_the_post_thumbnail_url( $product_id, $image_thumbnail_size );

					$user_id    = get_current_user_id();
                    $fav_product= in_array( $product_id, wcd_get_wishlist( $user_id ) );

                    if ( !empty( $fav_product ) ) {
                        $fav_item = 'fav-item';
                    }
                    else{
                        $fav_item = '';
                    }
					?>
					<div class="wl-rpf-col" ontouchstart="this.classList.toggle('hover');">
						<div class="wl-rpf-container <?php esc_attr_e( $hover_mode ); ?>">
							<div class="front" style="background-image: url(<?php echo esc_html( $thumbnail ); ?>)">
								<div class="inner">
									<p class="wl-rpf-product-title"><?php echo esc_attr( $product->get_name() ); ?></p>
									<span class="wl-rpf-product-price"><?php echo $product->get_price_html(); ?></span>
								</div>

								<?php if ( 'yes' == $sale_ribbon_show_hide && $product->is_on_sale() ): ?>
									<div class="wl-sf-corner-ribbon">
										<?php
										printf( '<span %1$s>%2$s</span>',
										    $this->get_render_attribute_string( 'sale_ribbon_text' ),
										    esc_html( $sale_ribbon_text )
										);
										?>
									</div>
								<?php endif; ?>
							</div>
							
							<div class="back">
								<div class="inner">
								<?php if ( 'yes' == $short_description_show_hide ) : ?>
									<p class="wl-rpf-short-description"><?php echo wp_trim_words( $product->get_short_description(), $product_desc_words_count ); ?></p>
								<?php endif;

								if ( 'yes' == $view_details_show_hide ): ?>
									<span class="wl-rpf-product-view">
										<a href="<?php the_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $view_details_icon['value'] ); ?>" ></i></a>
									</span>
								<?php endif;

								if ( 'yes' == $wishlist_show_hide ): ?>
									<span class="wl-rpf-product-fav">
										<a href="#" class="ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
                                            <i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
                                        </a>
									</span>
								<?php endif;

								if ( 'yes' == $cart_show_hide ):
									if( 'simple' == $product->get_type() ) : ?>
										<span class="wl-rpf-cart">
											<a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
										</span>
									<?php else: ?>
										<span class="wl-rpf-cart">
											<a href="<?php echo get_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
										</span>
									<?php endif;
								endif; ?>

								</div>
							</div>
						</div>
					</div>
					<?php endforeach;
				else: 

					if ( 'cart_items' != $content_source || ( wcd_is_preview_mode() || wcd_is_edit_mode() ) ) {
			             echo '<p>' . __( 'No Related Product Found!', 'woolementor' ) . '</p>';   
                    }

			endif; ?>
		</div>
		
		<?php
		/**
		 * Load Script
		 */
		$this->render_script();
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'sale_ribbon_text', 'basic' );
		$this->add_render_attribute( 'title_gradient_color', 'class', 'wl-gradient-heading' );
	}

	protected function render_script() {
		?>
		<script type="text/javascript">
			jQuery(function($){
				$('.wl-rpf-container').mouseenter(function(e){
					$(this).addClass('hover')
				});
				$('.wl-rpf-container').mouseleave(function(e){
					$(this).removeClass('hover')
				});
			})
		</script>
		<?php
	}
}