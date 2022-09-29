<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Core\Schemes\Color;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Related_Products_Trendy extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		$this->id = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_PRO_DEBUG' ) && WOOLEMENTOR_PRO_DEBUG ? '' : '.min';

		wp_register_script( "woolementor-{$this->id}-modernizr", plugins_url( "assets/js/modernizr.custom{$min}.js", __FILE__ ), ['jquery'], '1.1', false );
		wp_register_script( "woolementor-{$this->id}-toucheffects", plugins_url( "assets/js/toucheffects{$min}.js", __FILE__ ), ['jquery'], '1.1', true );

		wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}", 'fancybox', "woolementor-{$this->id}-modernizr", "woolementor-{$this->id}-toucheffects" ];
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
                'label' 		=> __( 'Content Source', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::SELECT,
                'options' 		=> [
                    'current_product'   => __( 'Current Product', 'woolementor-pro' ),
                    'cart_items'        => __( 'Cart Items', 'woolementor' ),
                    'custom'     		=> __( 'Custom', 'woolementor-pro' ),
                ],
                'default' 		=> 'current_product' ,
                'label_block' 	=> true,
            ]
        );

        $this->add_control(
            'main_product_id',
            [
                'label'     => __( 'Product ID', 'woolementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => get_post_type( get_the_ID() ) == 'product' ? get_the_ID() : '',
                'description'  	=> __( 'Input the base product ID', 'woolementor-pro' ),
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
				'label' => __( 'Sale Ribbon', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_sale_ribbon',
			[
				'label'         => __( 'Show/Hide', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'woolementor-pro' ),
				'label_off'     => __( 'Hide', 'woolementor-pro' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->add_control(
		    'sale_ribbon_text',
		    [
		        'label'         => __( 'Text', 'woolementor-pro' ),
		        'type'          => Controls_Manager::TEXT,
		        'label_block'   => 'block',
		        'condition' => [
		            'show_sale_ribbon' => 'yes'
		        ],
		        'default'   => __( 'Sale', 'woolementor-pro' ),
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
		 * Product Style controls
		 */
		$this->start_controls_section(
			'style_section_box',
			[
				'label' => __( 'Animation', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'layout',
			[
				'label'     => __( 'Animation Type', 'woolementor-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					3 => __( 'Swip', 'woolementor-pro' ),
					4 => __( 'Flip', 'woolementor-pro' ),
					6 => __( 'Zoom', 'woolementor-pro' ),
				],
				'separator'     => 'after',
				'default'   	=> 3,
			]
		);

		$this->add_control(
			'hover_mode',
			[
				'label'         => __( 'Hover mode', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'woolementor-pro' ),
				'label_off'     => __( 'Hide', 'woolementor-pro' ),
				'return_value'  => 'yes',
				'default'       => '',
			]
		);

		$this->end_controls_section();

		/**
		 * card Style
		 */
		$this->start_controls_section(
			'style_section_card',
			[
				'label' => __( 'Card', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'card_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'separator'     => 'before',
				'selector'      => '{{WRAPPER}} .wl-rptr-grid li',
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'condition' 	=> [
					'layout' 	=> '6'
				],
				'selectors'     => [
					'{{WRAPPER}} .wl-rptr-grid figcaption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Image section Style
		 */
		$this->start_controls_section(
			'style_section_image_card',
			[
				'label' => __( 'Image Section', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image-margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-rptr-grid' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_border_radius_1',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'condition' 	=> [
					'layout' 	=> '3'
				],
				'selectors'     => [
					'{{WRAPPER}} .wl-rptr-grid figure' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_image_border_radius_2',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'condition' 	=> [
					'layout' 	=> '6'
				],
				'selectors'     => [
					'{{WRAPPER}} .wl-rptr-grid figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * content Section Style
		 */
		$this->start_controls_section(
			'style_section_content_footer',
			[
				'label' => __( 'Content Section', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'card_footer_bg_color',
				'label' => __( 'Front Side', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .wl-rptr-grid figcaption',
			]
		);

		$this->add_control(
			'card_footer_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-rptr-grid figcaption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'content_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'separator'     => 'before',
				'selector'      => '{{WRAPPER}} .wl-rptr-grid li figure',
			]
		);

		$this->end_controls_section();

		/**
		 * Product Title
		 */
		$this->start_controls_section(
			'section_style_card_title',
			[
				'label' => __( 'Product Title', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'title_color',
				'selector' => '{{WRAPPER}} .wl-rptr-product-title a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .wl-rptr-product-title a',
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
					'{{WRAPPER}} .wl-rptr-product-price ins, .wl-rptr-product-price > .amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'price_size_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .wl-rptr-product-price ins, .wl-rptr-product-price > .amount',
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
					'{{WRAPPER}} .wl-rptr-product-price del' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-product-price del' => 'color: {{VALUE}}',
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
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .wl-rptr-product-price del',
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
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .woocommerce-Price-currencySymbol',
			]
		);

		$this->end_controls_section();

		/**
		 * Sale Ribbon section Style
		 */
		$this->start_controls_section(
			'style_section_sale_ribbon',
			[
				'label' => __( 'Sale Ribbon', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,				
		        'condition' => [
		            'show_sale_ribbon' => 'yes'
		        ],

			]
		);

		$this->add_control(
			'sale_ribbon_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-ribbon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'sale_ribbon_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .wl-rptr-ribbon',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sale_ribbon_bg_color',
				'label' => __( 'Front Side', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .wl-rptr-ribbon',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'Sale_ribbon_width',
			[
				'label' => __( 'Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-ribbon' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'Sale_ribbon_height',
			[
				'label' => __( 'Height', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],				
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-ribbon' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sale_ribbon_padding',
			[
				'label'         => __( 'Padding', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'separator' 	=> 'after',
				'selectors'     => [
					'{{WRAPPER}} .wl-rptr-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'Sale_ribbon_rotation',
			[
				'label' => __( 'Rotation', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 180,
						'step' => 1,
					],						
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-ribbon' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

		$this->add_control(
			'Sale_ribbon_x_position',
			[
				'label' => __( 'Position X', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -180,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-ribbon' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'Sale_ribbon_y_position',
			[
				'label' => __( 'Position Y', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -180,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-ribbon' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

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
                'label'     => __( 'Icon', 'woolementor-pro' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'eicon-heart',
                    'library'   => 'solid',
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
					'{{WRAPPER}} .wl-rptr-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .wl-rptr-product-fav a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wl-rptr-product-fav a' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rptr-product-fav a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'wishlist_padding',
			[
				'label'         => __( 'Padding', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-rptr-product-fav a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rptr-product-fav a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
            'wishlist_separator',
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
					'{{WRAPPER}} .wl-rptr-product-fav a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wishlist_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-product-fav a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'wishlist_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} .wl-rptr-product-fav a',
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
					'{{WRAPPER}} .wl-rptr-product-fav a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wishlist_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-product-fav a:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'wishlist_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} .wl-rptr-product-fav a:hover',
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
                'label'     => __( 'Icon', 'woolementor-pro' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'eicon-cart-solid',
                    'library'   => 'solid',
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
					'{{WRAPPER}} .wl-rptr-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .wl-rptr-cart a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wl-rptr-cart a' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rptr-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rptr-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rptr-cart a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-rptr-cart a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-cart a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} .wl-rptr-cart a',
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
					'{{WRAPPER}} .wl-rptr-cart a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-rptr-cart a:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} .wl-rptr-cart a:hover',
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
            'cart_icon_color_view_cart',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_view_cart',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_view_cart',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '{{WRAPPER}} .added_to_cart.wc-forward::after',
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
		
		$hover_mode = $settings['hover_mode'] == 'yes' && wcd_is_edit_mode() ? 'wl-rptr-hover' : ''; 

		if ( 'cart_items' == $content_source ) {
            $related_product_ids = wcd_get_cart_related_products( $product_limit );
        }
        else {
			$exclude_products_array = explode( ',', $exclude_products );
			$related_product_ids    = wc_get_related_products( $main_product_id, $product_limit, $exclude_products_array );
        }
        ?>
		
		<div class="wl-rptr-container">
			<ul class="wl-rptr-grid cx-grid wl-rptr-style-<?php esc_attr_e( $layout ); ?>">
			<?php
			if( count( $related_product_ids ) > 0 ) : 
				foreach( $related_product_ids as $product_id ) :
					$product    = wc_get_product( $product_id );
					$thumbnail  = get_the_post_thumbnail_url( $product_id );

					$user_id    = get_current_user_id();
                    $fav_product= in_array( $product_id, wcd_get_wishlist( $user_id ) );

                    if ( !empty( $fav_product ) ) {
                        $fav_item = 'fav-item';
                    }
                    else{
                        $fav_item = '';
                    }
					?>

					<li class="wl-rptr-col-<?php esc_attr_e( $columns ); ?>">

						<?php if( 'yes' == $show_sale_ribbon && $product->is_on_sale() ): ?>
							<div class="wl-rptr-ribbon"><?php echo esc_html( $sale_ribbon_text ); ?></div>
						<?php endif; ?>

						<figure class="<?php esc_attr_e( $hover_mode ); ?>">
							<img src="<?php echo esc_url( $thumbnail ); ?>" alt="img04">
							<figcaption class="wl-rptr-product-info">
								<p class="wl-rptr-product-title">
									<a href="<?php the_permalink( $product_id ); ?>"><?php echo esc_attr( $product->get_name() ); ?></a>
								</p>
								<p class="wl-rptr-product-price"><?php echo $product->get_price_html(); ?></p>
								<p class="wl-rptr-product-btns">
									<?php if ( 'yes' == $wishlist_show_hide ): ?>
										<span class="wl-rptr-product-fav">
											<a href="#" class="ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
                                                <i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
                                            </a>
										</span>
									<?php endif;

									if ( 'yes' == $cart_show_hide ):
										if( 'simple' == $product->get_type() ) : ?>
									  		<span class="wl-rptr-cart">
									  			<a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
									  		</span>
									  	<?php else: ?>
									  		<span class="wl-rptr-cart">
									  			<a href="<?php echo get_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
									  		</span>
									  	<?php endif;
									endif; ?>
								  	  
								</p>
							</figcaption>
						</figure>
					</li>
					
					<?php endforeach;
					else: 

						if ( 'cart_items' != $content_source || ( wcd_is_preview_mode() || wcd_is_edit_mode() ) ) {
			             	echo '<p>' . __( 'No Related Product Found!', 'woolementor' ) . '</p>';   
	                    }

			endif; ?>

			</ul>
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
				$('.wl-rptr-container').mouseenter(function(e){
					$(this).addClass('hover')
				});
				$('.wl-rptr-container').mouseleave(function(e){});
			})
		</script>
		<?php
	}
}