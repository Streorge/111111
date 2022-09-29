<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Related_Products_Accordion extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_PRO_DEBUG' ) && WOOLEMENTOR_PRO_DEBUG ? '' : '.min';

	    wp_enqueue_script( 'jquery-ui-accordion' );

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
         * Query controls
         */
        $this->start_controls_section(
            '_query_settings',
            [
                'label' => __( 'Query', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_source',
            [
                'label'         => __( 'Content Source', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'current_product'   => __( 'Current Product', 'woolementor-pro' ),
                    'cart_items'        => __( 'Cart Items', 'woolementor' ),
                    'custom'            => __( 'Custom', 'woolementor-pro' ),
                ],
                'default'       => 'current_product' ,
                'label_block'   => true,
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
                'label'     	=> __( 'Products Limit', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::NUMBER,
                'default'   	=> 5,
                'separator' 	=> 'before',
                'description'  	=> __( 'Number of related products to show', 'woolementor-pro' ),
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
		 * Wishlist controls
		 */
		$this->start_controls_section(
			'section_content_product_image',
			[
				'label' => __( 'Product Image', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image_on_click',
			[
				'label'     => __( 'On Click', 'woolementor-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'          => __( 'None', 'woolementor-pro' ),
					'zoom'          => __( 'Zoom', 'woolementor-pro' ),
					'product_page'  => __( 'Product Page', 'woolementor-pro' ),
				],
				'default'   => 'none',
			]
		);

		$this->end_controls_section();
		
		/**
		 * Show details button
		 */
		$this->start_controls_section(
			'section_content_details',
			[
				'label' => __( 'Details Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'details_btn_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->end_controls_section();
		
		/**
		 * Cart controls
		 */
		$this->start_controls_section(
			'section_content_cart',
			[
				'label' => __( 'Cart', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'cart_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->end_controls_section();
		
		/**
		 * Wishlist controls
		 */
		$this->start_controls_section(
			'section_content_wishlist',
			[
				'label' => __( 'Wishlist', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'wishlist_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->end_controls_section();

		/**
         * Product Category
         */
        $this->start_controls_section(
            'section_product_category',
            [
                'label' 		=> __( 'Product Category', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'product_category_show_hide',
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
			'product_category_count',
			[
				'label' => __( 'Category Count', 'woolementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 2,
			]
		);

        $this->end_controls_section();

		/**
         * Product Category
         */
        $this->start_controls_section(
            'section_product_tag',
            [
                'label' 		=> __( 'Product Tag', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'product_tag_show_hide',
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
			'product_tag_count',
			[
				'label' => __( 'Tag Count', 'woolementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 2,
			]
		);

        $this->end_controls_section();

		/**
         * star_rating
         */
        $this->start_controls_section(
            'section_content_star_rating',
            [
                'label' 		=> __( 'Star Rating', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'star_rating_show_hide',
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
		 * Row
		 */
		$this->start_controls_section(
			'section_style_row',
			[
				'label' => __( 'Row', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_style_accordion_switcher',
			[
				'label' 		=> __( 'Open First Item by Default', 'plugin-domain' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'On', 'woolementor-pro' ),
				'label_off' 	=> __( 'Off', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_responsive_control(
			'section_style_row_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-single-accordion' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_style_row_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-single-accordion' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Product Style controls
		 */
		$this->start_controls_section(
			'style_section_heading',
			[
				'label' 	=> __( 'Heading', 'woolementor-pro' ),
				'tab'   	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_text_align',
			[
				'label' 	=> __( 'Alignment', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::CHOOSE,
				'options' 	=> [
					'left' 		=> [
						'title' => __( 'Left', 'woolementor-pro' ),
						'icon' 	=> 'eicon-text-align-left',
					],
					'center' 	=> [
						'title' => __( 'Center', 'woolementor-pro' ),
						'icon' 	=> 'eicon-text-align-center',
					],
					'right' 	=> [
						'title' => __( 'Right', 'woolementor-pro' ),
						'icon' 	=> 'eicon-text-align-right',
					],
				],
				'default' 	=> 'left',
				'toggle' 	=> false,
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-accordion-title' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'heading_text_height',
			[
				'label' 	=> __( 'Height', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-accordion-title' => 'height: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wl-rpa-accordion-title h2' => 'line-height: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wl-rpa-accordion-title span::before' => 'line-height: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wl-rpa-accordion-title span' => 'height: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 100
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 10
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'heading_box_background',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-accordion-title',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'heading_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-accordion-title',
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'heading_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'heading_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-accordion-title',
			]
		);

		$this->add_responsive_control(
			'heading_box_shadow_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_box_shadow_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-accordion-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'heading_box_tab',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'heading_box_normal',
			[
				'label' 	=> __( 'Collapsed Expanded', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'heading_box_collapse_color',
			[
				'label' 	=> __( 'Background Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-open .wl-rpa-accordion-title' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_box_icon_color',
			[
				'label' 	=> __( 'Icon Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-single-accordion.wl-rpa-open .wl-rpa-accordion-title span::before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_box_btn_color',
			[
				'label' 	=> __( 'Button Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-single-accordion.wl-rpa-open .wl-rpa-accordion-title span' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'heading_box_hover',
			[
				'label' 	=> __( 'Collapsed Regular', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'heading_box_collapse_regular_bg',
			[
				'label' 	=> __( 'Background Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-accordion-title' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_box_regular_icon_color',
			[
				'label' 	=> __( 'Icon Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-accordion-title span::before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_box_regular_btn_color',
			[
				'label' 	=> __( 'Button Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-accordion-title span' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Product Style controls
		 */
		$this->start_controls_section(
			'style_section_box',
			[
				'label' => __( 'Content Wrapper', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'widget_box_background',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-accordion-content',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'widget_box_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-accordion-content',
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'widget_box_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'widget_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-accordion-content',
			]
		);

		$this->add_responsive_control(
			'widget_box_shadow_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'widget_box_shadow_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-accordion-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
                'name' => 'title_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-rpa-accordion-title h2',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-accordion-title h2',
			]
		);

		$this->end_controls_section();

		/**
		 * Product Short Dexcription
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
				'label_on'      => __( 'Show', 'woolementor-pro' ),
				'label_off'     => __( 'Hide', 'woolementor-pro' ),
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
				'selector'  => '.wl {{WRAPPER}} .wl-rpa-accordion-content p',
			]
		); 

		$this->add_control(
			'short_description_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-accordion-content p' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'product_desc_words_count',
			[
				'label' 		=> __( 'Words Count', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> 20,
			]
		);

		$this->end_controls_section();

		/**
		 * Product Category
		 */
		$this->start_controls_section(
			'section_style_category',
			[
				'label' => __( 'Product Category', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'product_category_show_hide' => 'yes',
				],
			]
		);

		$this->start_controls_tabs(
			'category_label_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'category_label',
			[
				'label' 	=> __( 'Label', 'woolementor-pro' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'category_label_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-rpa-accordion-cat span',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'category_label_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-accordion-cat span',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'category_text',
			[
				'label' 	=> __( 'Text', 'woolementor-pro' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'category_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-rpa-accordion-cat a',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'category_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-accordion-cat a',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Product Tag
		 */
		$this->start_controls_section(
			'section_style_tag',
			[
				'label' => __( 'Product Tag', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'product_category_show_hide' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tag_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} span.wl-rpa-tag',
			]
		);

		$this->start_controls_tabs(
			'tag_label_separator',
			[
				'separator' => 'before',
			]
		);

		$this->start_controls_tab(
			'tag_1',
			[
				'label' 	=> __( 'Tag One', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'tag_1_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-tag:nth-child(3n+1) a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tag_1_bg',
			[
				'label'     => __( 'Background ', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-tag:nth-child(3n+1)' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tag_2',
			[
				'label' 	=> __( 'Tag Two', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'tag_2_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-tag:nth-child(3n+2) a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tag_2_bg',
			[
				'label'     => __( 'Background ', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-tag:nth-child(3n+2)' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tag_3',
			[
				'label' 	=> __( 'Tag Three', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'tag_3_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-tag:nth-child(3n) a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tag_3_bg',
			[
				'label'     => __( 'Background ', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-tag:nth-child(3n)' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
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
					'.wl {{WRAPPER}} .wl-rpa-product-info .wl-rpa-price .amount , .wl-rpa-product-info .wl-rpa-price ins.amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'price_size_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-product-info .wl-rpa-price .amount , .wl-rpa-product-info .wl-rpa-price ins.amount',
			]
		);    

		$this->add_control(
			'sale_price_show_hide',
			[
				'label'			=> __( 'Show Sale Price', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'block',
				'default' 		=> 'none',
				'separator' 	=> 'before',
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-product-info .wl-rpa-price del' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-product-info .wl-rpa-price del .amount' => 'color: {{VALUE}}',
				],
				'condition' => [
					'sale_price_show_hide' => 'block'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'sale_price_size_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-product-info .wl-rpa-price del .amount',
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
					'.wl {{WRAPPER}} .wl-rpa-price .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'price_currency_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-price .woocommerce-Price-currencySymbol',
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
				'name' 		=> 'image_thumbnail',
				'exclude' 	=> [ 'custom' ],
				'include' 	=> [],
				'default' 	=> 'large',
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' 	=> __( 'Image Width', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-acordion-left img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 500
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 30
					],
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' 	=> __( 'Image Height', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-acordion-left img' => 'height: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 50,
						'max' 	=> 500
					],
					'em' 	=> [
						'min' 	=> 5,
						'max' 	=> 50
					]
				],
			]
		);

		$this->add_responsive_control(
			'image_box_height',
			[
				'label' 	=> __( 'Image Box Height', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-acordion-left' => 'height: {{SIZE}}{{UNIT}}',
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
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'image_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-acordion-left img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-rpa-acordion-left img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'image_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-acordion-left img',
			]
		);

		$this->start_controls_tabs(
			'image_effects',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'image_effects_normal',
			[
				'label' 	=> __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' 	=> __( 'Opacity', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 1,
						'min' 	=> 0.10,
						'step' 	=> 0.01,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-acordion-left img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters',
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-acordion-left img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'image_hover',
			[
				'label' 	=> __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' 	=> __( 'Opacity', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 1,
						'min' 	=> 0.10,
						'step' 	=> 0.01,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-acordion-left img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters_hover',
				'selector' 	=> '.wl {{WRAPPER}} .wl-rpa-acordion-left img:hover',
			]
		);

		$this->add_control(
			'image_hover_transition',
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
					'.wl {{WRAPPER}} .wl-rpa-acordion-left img:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		
		/**
         * star_rating
         */
        $this->start_controls_section(
            'section_style_star_rating',
            [
                'label' 		=> __( 'Star Rating', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'star_rating_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
			'star_rating_blockicon',
			[
				'label' 	=> __( 'Block Icon', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' 	=> 'fas fa-star',
					'library' 	=> 'solid',
				],
			]
		);

		$this->add_control(
			'star_rating_empty_icon',
			[
				'label' 	=> __( 'Empty Icon', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' 	=> 'far fa-star',
					'library' 	=> 'solid',
				],
			]
		);

        $this->add_responsive_control(
            'star_rating_icon_size',
            [
                'label'     	=> __( 'Icon Size', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-rpa-rating' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'star_rating_color',
            [
                'label'     	=> __( 'Color', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-rpa-rating' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

		/**
		 * Details Button styling
		 */
		$this->start_controls_section(
			'section_style_details_btn',
			[
				'label' => __( 'Details Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'details_btn_show_hide' => 'yes'
                ],
			]
		);

		$this->add_control(
			'details_btn_icon',
			[
				'label' 	=> __( 'Icon', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' => 'eicon-preview-thin',
					'library' => 'solid',
				],
			]
		);

		$this->add_responsive_control(
			'details_btn_icon_size',
			[
				'label'     => __( 'Icon Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-product-page a' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'details_btn_area_size',
			[
				'label'     => __( 'Area Size', 'woolementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-product-page a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'details_btn_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-rpa-product-page a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'details_btn_normal_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'details_btn_normal',
			[
				'label'     => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'details_btn_icon_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-product-page a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'details_btn_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-product-page a' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'details_btn_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-rpa-product-page a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'details_btn_hover',
			[
				'label'     => __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'details_btn_icon_color_hover',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-product-page a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'details_btn_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-product-page a:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'details_btn_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-rpa-product-page a:hover',
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
					'value' => 'eicon-cart-solid',
					'library' => 'solid',
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
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-cart a' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-cart a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-rpa-product-cart .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-cart a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-cart a' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-cart a',
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
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-cart a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-cart a:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-cart a:hover',
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
					'.wl {{WRAPPER}} .wl-rpa-product-cart .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg_view_cart',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-product-cart .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border_view_cart',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-rpa-product-cart .added_to_cart.wc-forward::after',
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
				'condition' 	=> [
					'wishlist_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'wishlist_icon',
			[
				'label' 	=> __( 'Icon', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' => 'eicon-heart',
					'library' => 'solid',
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
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-fav a' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-fav a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wishlist_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-fav a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'wishlist_border_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'wishlist_border_radius_normal',
			[
				'label'     => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'wishlist_icon_color_normal',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-fav a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wishlist_icon_bg_normal',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-fav a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'wishlist_border_normal',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-rpa-info-icons .wl-rpa-product-fav a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'wishlist_border_radius_hover',
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
					'.wl {{WRAPPER}} .wl-rpa-info-icons a.ajax_add_to_wish.fav-item' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-rpa-product-fav a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wishlist_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-rpa-info-icons a.ajax_add_to_wish.fav-item' => 'background-color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-rpa-product-fav a:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'wishlist_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-rpa-info-icons a.ajax_add_to_wish.fav-item, {{WRAPPER}} .wl-rpa-product-fav a:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {

		if ( ! is_woocommerce_activated()  ) return;

		$settings = $this->get_settings_for_display();
		$section_id = $this->get_id();
		
		extract( $settings );

		if ( 'cart_items' == $content_source ) {
            $related_product_ids = wcd_get_cart_related_products( $product_limit );
        }
        else {
			$exclude_products_array = explode( ',', $exclude_products );
			$related_product_ids    = wc_get_related_products( $main_product_id, $product_limit, $exclude_products_array );
        }
		?>

		<div class="cx-container">
			<div class="cx-row">
	         	<div class="cx-col-md-12 cx-col-sm-12">
	            	<div id="wl-rp-accordion-<?php echo $section_id; ?>" class="wl-rpa-accordion-area">

						<?php
						$count = 1;
						if( count( $related_product_ids ) > 0 ) : 
							foreach( $related_product_ids as $product_id ) :
								$product    	= wc_get_product( $product_id );
								$thumbnail  	= get_the_post_thumbnail_url( $product_id, $image_thumbnail_size );
								$user_id    	= get_current_user_id();
								$fav_product	= in_array( $product_id, wcd_get_wishlist( $user_id ) );

								if ( !empty( $fav_product ) ) {
									$fav_item = 'fav-item';
								}
								else{
									$fav_item = '';
								}

								if ( $count == 1 && 'yes' == $section_style_accordion_switcher ) {
									$wcd_open = 'wl-rpa-open';
								}
								else{
									$wcd_open = '';
								}
								?>
							 
								<!-- Single Product -->
								<div id="wl-rpa-single-accordion-<?php echo esc_attr( $product_id ); ?>" class="wl-rpa-single-accordion <?php echo esc_attr( $wcd_open ); ?>">
									<div class="wl-rpa-accordion-title wl-rpa-item">
										<h2><?php echo esc_html( $product->get_name() ); ?></h2><span></span>
									</div>
									<div class="wl-rpa-accordion-content wl-rpa-item-data">
										<div class="wl-rpa-accordion-content-inner">
											<div class="wl-rpa-acordion-left">
												<?php if ( 'none' == $image_on_click ): ?>
													<img src="<?php echo esc_html( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>  
												<?php elseif ( 'zoom' == $image_on_click ) : ?>
													<a id="wl-rpa-product-image-zoom" href="<?php echo esc_html( $thumbnail ); ?>"><img src="<?php echo esc_html( $thumbnail ); ?>" alt=""/></a>
												<?php elseif ( 'product_page' == $image_on_click ) : ?>
													<a href="<?php the_permalink( $product_id ); ?>">
														<img src="<?php echo esc_html( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>                              
													</a>
												<?php endif; ?>
											</div>
											<div class="wl-rpa-acordion-right">
												<div class="wl-rpa-accordion-category">
													<?php if ( 'yes' == $product_category_show_hide ): ?>
														<span class="wl-rpa-accordion-cat">
															<span><?php echo _e( 'CATEGORY :', 'woolementor-pro' ); ?></span> 
															<?php
															$terms_list = wc_get_product_category_list( $product_id );
															$term_list 	= explode( ',' , $terms_list );
															$terms 		= array_slice( $term_list, 0, $product_category_count );
															
															echo implode( ', ', $terms );
															?>
														</span> 
													<?php endif;

													if ( 'yes' == $star_rating_show_hide ): ?>
														<span class="wl-rpa-rating">
															<?php 
				                                                for ( $i = 0; $i < 5; $i++ ) { 

				                                                    if ( $i < $product->get_average_rating() ) {
				                                                        echo '<i class="'. esc_attr( $star_rating_blockicon['value'] ) .'"></i>';
				                                                    }
				                                                    else{
				                                                        echo '<i class="'. esc_attr( $star_rating_empty_icon['value'] ) .'"></i>';
				                                                    }
				                                                }
				                                                ?>
															<span>(<?php echo $product->get_average_rating(); ?>)</span>
														</span>
													<?php endif;

													if ( 'yes' == $product_tag_show_hide ):

														$tags_list 	= wc_get_product_tag_list( $product_id );
														$tag_list 	= explode( ',' , $tags_list );
														$tags 		= array_slice( $tag_list, 0, $product_tag_count );

														foreach ( $tags as $key => $tag ) {
															if( $tag ) {
																echo '<span class="wl-rpa-tag">'. esc_html( $tag  ).'</span>';
															}
														}

													endif ?>
													
												</div>

												<?php if ( 'yes' == $short_description_show_hide ): ?>
													<div class="wl-rpa-accordion-details">
														<p><?php echo wp_trim_words( $product->get_short_description(), $product_desc_words_count ); ?></p>
													</div>
												<?php endif; ?>

												<div class="wl-rpa-product-details">

													<div class="wl-rpa-product-info">
														<strong class="wl-rpa-price"><?php echo $product->get_price_html(); ?></strong>
													</div>
													<div class="wl-rpa-info-icons">
														<?php if ( $details_btn_show_hide == 'yes' ): ?>
														<div class="wl-rpa-product-page">
															<a href="<?php the_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $details_btn_icon['value'] ); ?>"></i></a>
														</div>
														<?php endif; ?>
															
														<?php if ( 'yes' == $wishlist_show_hide ): 
															
															?>
															<div class="wl-rpa-product-fav">
																<a href="#" class="ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
																	<i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
																</a>
															</div>
														<?php endif;

														if ( 'yes' == $cart_show_hide ):

															if ( 'simple' == $product->get_type() ): ?>
																<div class="wl-rpa-product-cart">
																	<div class="wl-cart-area">
																		<a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
																	</div>
																</div>
																<?php else: ?>
																	<div class="wl-rpa-product-cart">
																		<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart"  ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
																	</div>
															<?php endif;
														endif; ?>

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							<?php $count++; endforeach;
							else: 

								if ( 'cart_items' != $content_source || ( wcd_is_preview_mode() || wcd_is_edit_mode() ) ) {
						             echo '<p>' . __( 'No Related Product Found!', 'woolementor' ) . '</p>';   
			                    }

						endif; ?>
						
					</div>
				</div>
			</div>
		</div>

    	<?php
    	/**
		 * Load Script
		 */
		$this->render_script();
	}

	protected function render_script() {
		$section_id = $this->get_id();
		?>
		<script>
			jQuery(function($) {
				var Accordion = function(el, multiple) {
					this.el = el || {};
					this.multiple = multiple || false;

					var links = this.el.find('.wl-rpa-item');
					links.on('click', {
						el: this.el,
						multiple: this.multiple
					}, this.dropdown)
				}

				Accordion.prototype.dropdown = function(e) {
					var $el = e.data.el;
					$this = $(this),
					$next = $this.next();

					$next.slideToggle();
					$this.parent().toggleClass('wl-rpa-open');

					if (!e.data.multiple) {
						$el.find('.wl-rpa-item-data').not($next).slideUp().parent().removeClass('wl-rpa-open');
					};
				}
				var accordion = new Accordion($('#wl-rp-accordion-<?php echo $section_id; ?> .wl-rpa-single-accordion'), false);
			});
		</script>
		<?php
	}
}