<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Core\Schemes\Color;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Pricing_Table_Smart extends Widget_Base {

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
         * General controls
         */
        $this->start_controls_section(
            '_section_general',
            [
                'label'         => __( 'General', 'woolementor' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'is_featured',
            [
                'label'         => __( 'Is Featured?', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'woolementor' ),
                'label_off'     => __( 'No', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->add_control(
            'is_featured_text',
            [
                'label'         => __( 'Badge Text', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Featured', 'woolementor' ),
                'placeholder'   => __( 'Type your title here', 'woolementor' ),
                'condition' => [
                    'is_featured' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

		/**
        * Pricing Content controll
        */ 

		$this->start_controls_section(
            '_section_pricing',
            [
                'label' 		=> __( 'Price', 'woolementor-pro' ),
                'tab' 			=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pricing_table_currency',
            [
                'label'         => __( 'Currency', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '$',
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'pricing_table_currency_alignment',
            [
                'label' => __( 'Currency Alignment', 'woolementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'woolementor-pro' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'woolementor-pro' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'separator'=> 'after'
            ]
        );

        $this->add_control(
            'pricing_table_price',
            [
                'label' 		=> __( 'Amount', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> '11.99',
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'pricing_table_period',
            [
                'label' 		=> __( 'Period', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> __( 'PER MONTH', 'woolementor-pro' ),
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );      
        
        $this->add_control(
            'show_sale_price',
            [
                'label' => __( 'Show sale Price', 'woolementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'woolementor-pro' ),
                'label_off' => __( 'Hide', 'woolementor-pro' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'pricing_table_sale_price',
            [
                'label'         => __( 'sale Amount', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '9.99',
                'condition' => [
                    'show_sale_price' => 'yes'
                ],
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Title & description content controll
         */
        $this->start_controls_section(
            '_section_header',
            [
                'label'         => __( 'Title & Description', 'woolementor-pro' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pricing_table_title',
            [
                'label'         => __( 'Title', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => __( 'Smart Plan', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'show_plan_desc',
            [
                'label' => __( 'Show Description', 'woolementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'woolementor-pro' ),
                'label_off' => __( 'Hide', 'woolementor-pro' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'pricing_table_desc',
            [
                'label'         => __( 'Description', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod', 'woolementor-pro' ),
                'condition' => [
                    'show_plan_desc' => 'yes'
                ],
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();

        /**
        * Featturs content controll
        */

        $this->start_controls_section(
            '_section_features',
            [
                'label'			 => __( 'Features', 'woolementor-pro' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'pricing_table_features_text',
            [
                'label' 		=> __( 'Text', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> __( 'Exciting Feature', 'woolementor-pro' ),
                'label_block'   => 'true',
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );

        $repeater->add_control(
            'pricing_table_features_icon',
            [
                'label' 		=> __( 'Icon', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' 		=> [
                    'value' 	=> 'fas fa-check',
                    'library' 	=> 'fa-solid',
                ],
                'recommended' 	=> [
                    'fa-regular' => [
                        'check-square',
                        'window-close',
                    ],
                    'fa-solid' 	=> [
                        'check',
                        'times'
                    ]
                ]
            ]
        );

        $repeater->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'woolementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'default' => '#000',
            ]
        );

        $repeater->add_control(
            'icon_hover_color',
            [
                'label' => __( 'Icon Hover Color', 'woolementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'default' => '#fff',
            ]
        );

        $this->add_control(
            'pricing_table_features',
            [
                'type' 			=> Controls_Manager::REPEATER,
                'fields' 		=> $repeater->get_controls(),
                'show_label' 	=> false,
                'default' 		=> [
                    [
                        'pricing_table_features_text' => __( 'Standard Feature', 'woolementor-pro' ),
                        'pricing_table_features_icon' => 'fas fa-check',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Another Great Feature', 'woolementor-pro' ),
                        'pricing_table_features_icon' => 'fas fa-check',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Obsolete Feature', 'woolementor-pro' ),
                        'pricing_table_features_icon' => 'fas fa-times',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Extended Free Trial', 'woolementor-pro' ),
                        'pricing_table_features_icon' => 'fas fa-check',
                    ],
                ],
                'title_field' 	=> '{{{pricing_table_features_text}}}',
            ]
        );

        $this->end_controls_section();

        /**
        * Button content controll
        */

        $this->start_controls_section(
            '_section_footer',
            [
                'label' 		=> __( 'Footer Button', 'woolementor-pro' ),
                'tab' 			=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_purchase_btn',
            [
                'label' => __( 'Show Button', 'woolementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'woolementor-pro' ),
                'label_off' => __( 'Hide', 'woolementor-pro' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'pricing_table_btn_text',
            [
                'label' 		=> __( 'Button Text', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> __( 'Purchase', 'woolementor-pro' ),
                'placeholder' 	=> __( 'Type button text here', 'woolementor-pro' ),
                'label_block' 	=> true,
                'dynamic' 		=> [
                    'active' 	=> true
                ],
                'condition' => [
                    'show_purchase_btn' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'pricing_table_btn_link',
            [
                'label' 		=> __( 'Link', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::URL,
                'label_block' 	=> true,
                'placeholder' 	=> 'https://codexpert.io/codesigner/',
                'dynamic' 		=> [
                    'active' => true,
                ], 
                'condition' => [
                    'show_purchase_btn' => 'yes'
                ],               
            ]
        );

        $this->end_controls_section();

        /**
        *Full card styling
        */

        $this->start_controls_section(
            '_section_style_card',
            [
                'label' => __( 'Card', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'pricing_table_card' );

        $this->start_controls_tab(
            'pricing_table_card_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_box_bg',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_card_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_box_bg_hover',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_box_border',
                'label' => __( 'Border', 'woolementor-pro' ),
                'separator' => 'before',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pricing_table_box_shadow',
                'label' => __( 'Box Shadow', 'woolementor-pro' ),
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart',
            ]
        );


        $this->add_responsive_control(
            'pricing_table_box_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
        * Pricing area styling
        */

        $this->start_controls_section(
            '_section_style_pricing_area',
            [
                'label' => __( 'Pricing Area', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pricing_area_box_alignment',
            [
                'label' => __( 'Box Alignment', 'woolementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'woolementor-pro' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'woolementor-pro' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'pricing_area_text_align',
            [
                'label' => __( 'Test Align', 'woolementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'separator'    => 'before',
                'toggle' => true,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_area_width',
            [
                'label' => __( 'Width', 'woolementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_pricing_area_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_pricing_area_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'separator'    => 'before',
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_pricing_area_margin',
            [
                'label'         => __( 'Margin', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'separator'    => 'after',
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_pricing_area_tab' );

        $this->start_controls_tab(
            'pricing_table_pricing_area_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_pricing_area_bg',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_pricing_area_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_pricing_area_bg_hover',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-pricing-area',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Regular Price styling
        */

        $this->start_controls_section(
            '_section_style_price',
            [
                'label' => __( 'Price', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-regular-price ',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_price_tab' );

        $this->start_controls_tab(
            'pricing_table_price_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'price_gradient_color',
                'separator' => 'before',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-regular-price ',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_price_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'price_gradient_color_hover',
                'separator' => 'before',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-regular-price ',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Sale Price styling
        */

        $this->start_controls_section(
            '_section_style_sale_price',
            [
                'label' => __( 'Sale Price', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_sale_price' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'sale_price_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-sale-price ',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_sale_price_tab' );

        $this->start_controls_tab(
            'pricing_table_sale_price_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'sale_price_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-sale-price ',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sale_pricing_table_price_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'sale_price_gradient_color_hover',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-sale-price ',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Is featured styling
        */

        $this->start_controls_section(
            '_section_style_featured',
            [
                'label' => __( 'Featured', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'is_featured' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'featured_offset_y',
            [
                'label'         => __( 'Offset Top', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pt-featured' => 'top: {{SIZE}}{{UNIT}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'featured_offset_x_r',
            [
                'label'         => __( 'Offset Right', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'pricing_area_box_alignment' => 'left'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pt-featured.right' => 'right: {{SIZE}}{{UNIT}}'
                ],
            ]
        );
        $this->add_responsive_control(
            'featured_offset_x_l',
            [
                'label'         => __( 'Offset Left', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'pricing_area_box_alignment' => 'right'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pt-featured.left' => 'left: {{SIZE}}{{UNIT}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'featured_rotation',
            [
                'label'         => __( 'Rotation', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 360,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pt-featured' => 'transform: rotate({{SIZE}}deg)'
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_featured' );

        $this->start_controls_tab(
            'pricing_table_featured_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'featured_text_color',
            [
                'label' => __( 'Text Color', 'plugin-domain' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pt-featured' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_featured_bg',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.wl {{WRAPPER}} .wl-pt-featured',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_featured_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'featured_text_color_hover',
            [
                'label' => __( 'Text Color', 'plugin-domain' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pt-featured:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_featured_bg_hover',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.wl {{WRAPPER}} .wl-pt-featured:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_featured_border',
                'label' => __( 'Border', 'woolementor-pro' ),
                'separator' => 'before',
                'selector' => '.wl {{WRAPPER}} .wl-pt-featured',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_featured_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pt-featured' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pricing_table_featured_shadow',
                'label' => __( 'Box Shadow', 'woolementor-pro' ),
                'selector' => '.wl {{WRAPPER}} .wl-pt-featured',
            ]
        );


        $this->add_responsive_control(
            'pricing_table_featured_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pt-featured' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
        *Period Price styling
        */

        $this->start_controls_section(
            '_section_style_period',
            [
                'label' => __( 'Period', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'period_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-period',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_period_tab' );

        $this->start_controls_tab(
            'pricing_table_period_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'period_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-period',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_period_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'period_gradient_color_hover',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-pricing-period',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Title styling
        */

        $this->start_controls_section(
            '_section_style_title',
            [
                'label' => __( 'Title', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-title',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );


        $this->add_control(
            'title_align',
            [
                'label' => __( 'Alignment', 'woolementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_title_tab' );

        $this->start_controls_tab(
            'pricing_table_title_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'title_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-title',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_title_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'title_gradient_color_hover',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-title',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Description styling
        */

        $this->start_controls_section(
            '_section_style_description',
            [
                'label' => __( 'Description', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_plan_desc' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'description_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-description',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_control(
            'description_align',
            [
                'label' => __( 'Alignment', 'woolementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-description' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_description_tab' );

        $this->start_controls_tab(
            'pricing_table_description_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'description_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-description',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_description_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'description_gradient_color_hover',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-description',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Feature list styling
        */

        $this->start_controls_section(
            '_section_style_features',
            [
                'label' => __( 'Features', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pricing_table_features_default_style',
            [
                'label' => __( 'View', 'plugin-domain' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional','selectors' => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-pricing-icon-svg' => 'width:20px',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'features_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-desc',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'woolementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-pricing-icon-svg' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'features_align',
            [
                'label' => __( 'Alignment', 'woolementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'woolementor-pro' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-feature-list' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'space_btn_items',
            [
                'label' => __( 'Space Between Features', 'woolementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-featute' => 'margin: {{SIZE}}{{UNIT}} 0{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_features_tab' );

        $this->start_controls_tab(
            'pricing_table_features_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'features_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-desc',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_features_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'features_gradient_color_hover',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover .wl-ptsf-desc',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Button styling
        */

        $this->start_controls_section(
            '_section_style_btn',
            [
                'label' => __( 'Button', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase-btn',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_btn_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_btn_tab' );

        $this->start_controls_tab(
            'pricing_table_btn_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'btn_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_btn_bg',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'separator' => 'before',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase',
            ]
        );

         $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_btn_border',
                'label' => __( 'Border', 'woolementor-pro' ),
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_btn_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'btn_gradient_color_hover',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_btn_bg_hover',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'separator' => 'before',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-purchase',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_btn_border_hover',
                'label' => __( 'Border', 'woolementor-pro' ),                
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-purchase',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'pricing_table_btn_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'separator' => 'before',
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_btn_margin',
            [
                'label'         => __( 'Margin', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase' => 'Margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
        extract( $settings );

        $del_start = '';
        $del_close = '';
        $sale_price_on = '';
        if ( $show_sale_price == 'yes' ) {
            $del_start = '<del>';
            $del_close = '</del>';
            $sale_price_on = 'wl-pts-sale-on';
        }

        $alignment  = $pricing_area_box_alignment == 'left' ? 'pts-left' : 'pts-right';
        $pt_featured = $is_featured == 'yes' ? 'wl-pt-featured-on' : '';
        $feature_alignment = $pricing_area_box_alignment == 'left' ? 'right' : 'left';

        $this->render_editing_attributes();
        ?>

        <div class="wl-pricing-table-smart <?php esc_attr_e( $alignment ).' '. esc_attr_e( $pt_featured ); ?>">
            <?php if( 'yes' == $is_featured ): ?>
                <span class="wl-pt-featured <?php echo esc_attr( $feature_alignment ); ?>"><?php echo esc_html( $is_featured_text ); ?></span>
            <?php endif; ?>
            <div class="wl-pts-pricing-area-content">
                <div class="wl-pts-pricing-area">
                    <div class="wl-pts-price-area">
                        <?php if( 'left' == $pricing_table_currency_alignment ): ?>
                                <div class="wl-pts-regular-price <?php echo esc_attr( $sale_price_on ); ?>">
                                    <?php echo $del_start; ?><span class="wl-pts-currency"><?php echo esc_html( $pricing_table_currency ); ?></span><?php 
                                        printf( '<span %s>%s</span>',
                                            $this->get_render_attribute_string( 'pricing_table_price' ),
                                            esc_html( $pricing_table_price )
                                        );
                                        echo $del_close; 
                                    ?>
                                </div>
                                <?php if( 'yes' == $show_sale_price ): ?>
                                    <div class="wl-pts-sale-price">
                                        <span class="wl-pts-currency"><?php echo esc_html( $pricing_table_currency ); ?></span><?php 
                                            printf( '<span %s>%s</span>',
                                                $this->get_render_attribute_string( 'pricing_table_sale_price' ),
                                                esc_html( $pricing_table_sale_price )
                                            );
                                        ?>
                                    </div>
                                <?php endif;

                            elseif( 'right' == $pricing_table_currency_alignment ): ?>

                            <div class="wl-pts-regular-price <?php esc_attr_e( $sale_price_on ); ?>">
                                <?php 
                                    echo $del_start;
                                    printf( '<span %s>%s</span>',
                                        $this->get_render_attribute_string( 'pricing_table_price' ),
                                        esc_html( $pricing_table_price )
                                    );
                                ?><span class="wl-pts-currency"><?php echo esc_html( $pricing_table_currency ); ?></span><?php echo $del_close; ?>
                            </div>
                            <?php if( 'yes' == $show_sale_price ): ?>
                                <div class="wl-pts-sale-price">
                                    <?php 
                                        printf( '<span %s>%s</span>',
                                            $this->get_render_attribute_string( 'pricing_table_sale_price' ),
                                            esc_html( $pricing_table_sale_price )
                                        );
                                    ?><span class="wl-pts-currency"><?php echo esc_html( $pricing_table_currency ); ?></span>
                                </div>
                            <?php endif;
                        endif; ?>
                    </div>

                    <?php 
                        printf( '<div %s>%s</div>',
                            $this->get_render_attribute_string( 'pricing_table_period' ),
                            esc_html( $pricing_table_period )
                        );
                    ?>
                    
                </div>
            </div>
            <div class="wl-pts-feature-area">
                
                <?php 
                printf( '<h3 %s>%s</h3>',
                    $this->get_render_attribute_string( 'pricing_table_title' ),
                    esc_html( $pricing_table_title )
                );

                if( 'yes' == $show_plan_desc ): 

                    printf( '<p %s>%s</p>',
                        $this->get_render_attribute_string( 'pricing_table_desc' ),
                        esc_html( $pricing_table_desc )
                    );

                endif; 
                ?>
                <ul class="wl-pts-feature-list">                   
                    <?php 
                    $section_id = $this->get_id();
                    $styling = '';
                    if( count( $pricing_table_features ) > 0 ): 
                            foreach ($pricing_table_features as $key => $feature):
                                $styling .= ".wl-ptsf-icon-{$section_id}{$feature['_id']}{color: {$feature['icon_color']}} .wl-pricing-table-smart:hover .wl-ptsf-icon-{$section_id}{$feature['_id']}{color: {$feature['icon_hover_color']}}";
                        ?>
                        <li class="wl-pts-featute">
                            <span class="wl-ptsf-icon wl-ptsf-icon-<?php echo $section_id.$feature['_id'] ?>"><?php 
                                if ( $feature['pricing_table_features_icon']['library'] == 'svg' ) {
                                    $svg = esc_url( $feature['pricing_table_features_icon']['value']['url'] );
                                    echo "<img class='wl-ptsf-pricing-icon-svg' src='{$svg}' />";
                                }
                                else{
                                    $icon = esc_attr( $feature['pricing_table_features_icon']['value'] );
                                    echo "<i class='{$icon}'></i>";
                                }
                             ?></span>
                            <span class="wl-ptsf-desc"><?php echo esc_html( $feature['pricing_table_features_text'] ) ?></span>
                        </li>
                    <?php endforeach; endif; ?>
                </ul>
                <?php if( 'yes' == $show_purchase_btn ): ?>
                    <div class="wl-pts-purchase">

                        <?php 
                            printf( '<a %s>%s</a>',
                                $this->get_render_attribute_string( 'pricing_table_btn_text' ),
                                esc_html( $pricing_table_btn_text )
                            );
                        ?>
                        
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <style type="text/css">
            <?php echo $styling; ?>
        </style>

		<?php
	}

    protected function render_editing_attributes() {
        $settings = $this->get_settings_for_display();
        extract( $settings );
        
        $btn_url    = esc_url( $pricing_table_btn_link['url'] );
        $target     = $pricing_table_btn_link['is_external'] ? '_blank' : '';
        $nofollow   = $pricing_table_btn_link['nofollow'] ? 'nofollow' : '';

        $this->add_inline_editing_attributes( 'pricing_table_price', 'none' );
        $this->add_render_attribute( 'pricing_table_price', 'class', 'wl-pts-price' );

        $this->add_inline_editing_attributes( 'pricing_table_sale_price', 'none' );
        $this->add_render_attribute( 'pricing_table_sale_price', 'class', 'wl-pts-price' );

        $this->add_inline_editing_attributes( 'pricing_table_period', 'none' );
        $this->add_render_attribute( 'pricing_table_period', 'class', 'wl-pts-pricing-period' );

        $this->add_inline_editing_attributes( 'pricing_table_title', 'none' );
        $this->add_render_attribute( 'pricing_table_title', 'class', 'wl-pts-title' );

        $this->add_inline_editing_attributes( 'pricing_table_desc', 'none' );
        $this->add_render_attribute( 'pricing_table_desc', 'class', 'wl-pts-description' );

        $this->add_inline_editing_attributes( 'pricing_table_btn_text', 'none' );
        $this->add_render_attribute( 'pricing_table_btn_text', 'class', 'wl-pts-purchase-btn' );

        $this->add_render_attribute( 'pricing_table_btn_text', 'href', $btn_url );
        $this->add_render_attribute( 'pricing_table_btn_text', 'target', $target );
        $this->add_render_attribute( 'pricing_table_btn_text', 'rel', $nofollow );
    }
}