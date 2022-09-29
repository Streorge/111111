<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Helper as WCDH;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Shop_Trendy extends Widget_Base {

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
		            5 => __( '5 Columns', 'woolementor' ),
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
				'label_on'      => __( 'Enable', 'woolementor' ),
				'label_off'     => __( 'Disable', 'woolementor' ),
				'return_value'  => 'yes',
				'default'       => '',
				'description'   => __( '"Hover Mode" is only for design purpose. This has no efect on live/preview mode.', 'woolementor-pro' ),
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

		$this->add_control(
			'card_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-str-grid li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'card_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'separator'     => 'before',
				'selector'      => '.wl {{WRAPPER}} .wl-str-grid li',
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
					'.wl {{WRAPPER}} .wl-str-grid figcaption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-grid' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-grid figure' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-grid figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '.wl {{WRAPPER}} .wl-str-grid figcaption',
			]
		);

		$this->add_control(
			'card_footer_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-str-grid figcaption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'content_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'separator'     => 'before',
				'selector'      => '.wl {{WRAPPER}} .wl-str-grid li figure',
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
		        'size_units'    => ['px', '%'],
		        'condition'     => [
		            'stock_offset_toggle' => 'yes'
		        ],
		        'range'         => [
		            'px'        => [
		                'min'   => -1000,
		                'max'   => 1000,
		            ],
		            '%'        => [
		                'min'   => 0,
		                'max'   => 100,
		            ],
		        ],
		        'selectors'     => [
		            '.wl {{WRAPPER}} .wl-str-stock' => 'right: {{SIZE}}{{UNIT}}'
		        ],
		        'render_type'   => 'ui',
		    ]
		);

		$this->add_responsive_control(
		    'stock_media_offset_y',
		    [
		        'label'         => __( 'Offset Top', 'woolementor' ),
		        'type'          => Controls_Manager::SLIDER,
		        'size_units'    => ['px', '%'],
		        'condition'     => [
		            'stock_offset_toggle' => 'yes'
		        ],
		        'range'         => [
		            'px'        => [
		                'min'   => -1000,
		                'max'   => 1000,
		            ],
		            'px'        => [
		                'min'   => 0,
		                'max'   => 100,
		            ],
		        ],
		        'selectors'     => [
		            '.wl {{WRAPPER}} .wl-str-stock' => 'top: {{SIZE}}{{UNIT}}',
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
		            '.wl {{WRAPPER}} .wl-str-stock' => 'width: {{SIZE}}{{UNIT}}',
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
		            '.wl {{WRAPPER}} .wl-str-stock' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
		            '.wl {{WRAPPER}} .wl-str-stock' => 'color: {{VALUE}}',
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
		        'selector'  => '.wl {{WRAPPER}} .wl-str-stock',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 16 ] ],
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
		            '.wl {{WRAPPER}} .wl-str-stock' => 'background: {{VALUE}}',
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
		            '.wl {{WRAPPER}} .wl-str-stock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'separator' => 'after'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name'          => 'stock_ribbon_border',
		        'label'         => __( 'Border', 'woolementor' ),
		        'selector'      => '.wl {{WRAPPER}} .wl-str-stock',
		    ]
		);

		$this->add_responsive_control(
		    'stock_ribbon_border_radius',
		    [
		        'label'         => __( 'Border Radius', 'woolementor' ),
		        'type'          => Controls_Manager::DIMENSIONS,
		        'size_units'    => [ 'px', '%' ],
		        'selectors'     => [
		            '.wl {{WRAPPER}} .wl-str-stock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
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
					'.wl {{WRAPPER}} .wl-str-ribbon' => 'color: {{VALUE}}',
				],
				'default' => '#fff'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'sale_ribbon_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '.wl {{WRAPPER}} .wl-str-ribbon',
				'separator' => 'after',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sale_ribbon_bg_color',
				'label' => __( 'Front Side', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '.wl {{WRAPPER}} .wl-str-ribbon',
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
					'.wl {{WRAPPER}} .wl-str-ribbon' => 'width: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-ribbon' => 'height: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'max' => 360,
						'step' => 1,
					],						
				],
				'separator' => 'after',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-str-ribbon' => 'transform: rotate({{SIZE}}deg);',
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
					'.wl {{WRAPPER}} .wl-str-ribbon' => 'top: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-ribbon' => 'right: {{SIZE}}{{UNIT}};',
				],
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
				'selector' => '.wl {{WRAPPER}} .wl-str-product-title a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '.wl {{WRAPPER}} .wl-str-product-title a',
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
					'.wl {{WRAPPER}} .wl-str-product-price '=> 'color: {{VALUE}}', 
					'.wl {{WRAPPER}} .wl-str-product-price .woocommerce-Price-amount.amount'=> 'color: {{VALUE}}', 
					'.wl {{WRAPPER}} .wl-str-product-price ins .woocommerce-Price-amount.amount'=> 'color: {{VALUE}}', 
					'.wl {{WRAPPER}} .wl-str-product-price ins > .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'price_size_typography',
				'label'     => __( 'Typography', 'woolementor-pro' ),
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '.wl {{WRAPPER}} .wl-str-product-price ins,.wl {{WRAPPER}} .wl-str-product-price > .amount',
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
				'label_on'      => __( 'Show', 'woolementor-pro' ),
				'label_off'     => __( 'Hide', 'woolementor-pro' ),
				'return_value'  => 'block',
				'default'       => 'none',
				'separator'     => 'before',
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-str-product-price del' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-str-product-price del ' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-str-product-price del .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
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
				'selector'  => '.wl {{WRAPPER}} .wl-str-product-price del',
				'condition' => [
					'sale_price_show_hide' => 'block'
				],
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
				'scheme'    => Typography::TYPOGRAPHY_1,
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
					'.wl {{WRAPPER}} .wl-str-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-str-product-fav a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-str-product-fav a' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-product-fav a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-product-fav a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-product-fav a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-product-fav a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wishlist_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-str-product-fav a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'wishlist_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-str-product-fav a',
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
					'.wl {{WRAPPER}} .wl-str-product-fav a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wishlist_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-str-product-fav a:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'wishlist_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-str-product-fav a:hover',
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
					'.wl {{WRAPPER}} .wl-str-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-str-cart a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-str-cart a' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-cart a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-cart a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-str-cart a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-str-cart a',
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
					'.wl {{WRAPPER}} .wl-str-cart a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-str-cart a:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-str-cart a:hover',
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
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_view_cart',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_view_cart',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .added_to_cart.wc-forward::after',
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
					'.wl {{WRAPPER}} .wl-str-pagination' => 'text-align: {{VALUE}};',
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
		            '.wl {{WRAPPER}} .wl-str-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
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
                'label'     => __( 'Left Icon', 'woolementor-pro' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'eicon-chevron-left',
                    'library'   => 'solid',
                ],
				'separator' => 'before'
            ]
        );

		$this->add_control(
            'pagination_right_icon',
            [
                'label'     => __( 'Right Icon', 'woolementor-pro' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'eicon-chevron-right',
                    'library'   => 'solid',
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
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pagination_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-str-pagination .page-numbers',
			]
		);

		$this->add_responsive_control(
			'pagination_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers.current' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_current_item_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers.current' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pagination_current_item_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-str-pagination .page-numbers.current',
			]
		);

		$this->add_responsive_control(
			'pagination_current_item_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination_hover_item_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pagination_hover_item_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-str-pagination .page-numbers:hover',
			]
		);

		$this->add_responsive_control(
			'pagination_hover_item_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-str-pagination .page-numbers:hover' => 'transition-duration: {{SIZE}}s',
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

		$hover_mode = $settings['hover_mode'] == 'yes' && wcd_is_edit_mode() ? 'wl-str-hover' : '';

        $data = [
            'sale_ribbon_text'              => $sale_ribbon_text,
            'stock_ribbon_text'             => $stock_ribbon_text,
            'woolementor_condition_list'    => $woolementor_condition_list,
            'custom_query'                  => $custom_query,
            'columns'                       => $columns,
            'hover_mode'                	=> $hover_mode,
            'show_sale_ribbon'              => $show_sale_ribbon,
            'layout'              			=> $layout,
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
            'stock_show_hide'               => $stock_show_hide,
            'cart_show_hide'                => $cart_show_hide,
            'wishlist_show_hide'            => $wishlist_show_hide,
            'pagination_show_hide'          => $pagination_show_hide,
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