<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Pricing_Table_Fancy extends Widget_Base {

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
                'label'         => __( 'General', 'woolementor-pro' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'general_is_featured',
            [
                'label'         => __( 'Is Featured?', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->add_control(
            'general_is_featured_badge_text',
            [
                'label'         => __( 'Badge Text', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Featured', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'condition' => [
                    'general_is_featured' => 'yes'
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
         * Name content controll
         */
        $this->start_controls_section(
            '_section_header',
            [
                'label'         => __( 'Name', 'woolementor-pro' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pricing_table_title',
            [
                'label'         => __( 'Title', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => __( 'Fancy Plan', 'woolementor-pro' ),
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
                    'value' 	=> 'eicon-check-circle-o',
                    'library' 	=> 'fa-solid',
                ],
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
                'default' => '#0080FF',
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
                        'pricing_table_features_icon' => 'eicon-check-circle-o',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Another Great Feature', 'woolementor-pro' ),
                        'pricing_table_features_icon' => 'eicon-check-circle-o',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Obsolete Feature', 'woolementor-pro' ),
                        'pricing_table_features_icon' => 'eicon-close-circle',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Extended Free Trial', 'woolementor-pro' ),
                        'pricing_table_features_icon' => 'eicon-check-circle-o',
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
                'label' 		=> __( 'Button', 'woolementor-pro' ),
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
                'label'         => __( 'Button Text', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Purchase', 'woolementor-pro' ),
                'placeholder'   => __( 'Type button text here', 'woolementor-pro' ),
                'label_block'   => true,
                'dynamic'       => [
                    'active'    => true
                ],
                'condition' => [
                    'show_purchase_btn' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'pricing_table_btn_link',
            [
                'label'         => __( 'Link', 'woolementor-pro' ),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'placeholder'   => 'https://codexpert.io/codesigner/',
                'dynamic'       => [
                    'active' => true,
                ],
                'condition' => [
                    'show_purchase_btn' => 'yes'
                ],             
            ]
        );

        $this->end_controls_section();

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
                'name'      => 'pricing_table_box_bg',
                'label'     => __( 'Background', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-fancy',
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
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover',
            ]
        );

        $this->add_control(
            'pricing_table_box_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover' => 'transition-duration: {{SIZE}}s',
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-pricing-area' => 'transition-duration: {{SIZE}}s',
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptff-desc' => 'transition-duration: {{SIZE}}s',
                ],
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
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'pricing_table_box_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-fancy',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'separator'     => 'before',
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_margin',
            [
                'label'         => __( 'Margin', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

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

        $this->add_responsive_control(
            'pricing_table_price_box_width',
            [
                'label'     => __( 'Width', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptf-pricing-area' => 'width: {{SIZE}}{{UNIT}};',
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

        $this->add_responsive_control(
            'pricing_table_price_box_height',
            [
                'label'     => __( 'Height', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptf-pricing-area' => 'height: {{SIZE}}{{UNIT}} !important;',
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

        $this->add_control(
            'sale_ribbon_offset_toggle',
            [
                'label'         => __( 'Offset', 'woolementor-pro' ),
                'type'          => Controls_Manager::POPOVER_TOGGLE,
                'label_off'     => __( 'None', 'woolementor-pro' ),
                'label_on'      => __( 'Custom', 'woolementor-pro' ),
                'return_value'  => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'price_box_offset_x',
            [
                'label'         => __( 'Offset Left', 'woolementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptf-pricing-area' => 'margin-left: {{SIZE}}{{UNIT}}'
                ],
                'render_type'   => 'ui',
            ]
        );

        $this->add_responsive_control(
            'price_box_offset_y',
            [
                'label'         => __( 'Offset Top', 'woolementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptf-pricing-area' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-ptf-fancy-price, {{WRAPPER}} .wl-ptf-fancy-price.wl-ptf-sale-on del',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                ],
            ]
        );

        $this->add_control(
            '_heading_currency',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Currency', 'woolementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_currency_left_spacing',
            [
                'label' => __( 'Side Spacing', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptf-currency' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
                'condition' => [
                    'pricing_table_currency_alignment' => 'left'
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_currency_right_spacing',
            [
                'label' => __( 'Side Spacing', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptf-currency' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
                'condition' => [
                    'pricing_table_currency_alignment' => 'right'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_price_box_border',
                'label' => __( 'Border', 'woolementor-pro' ),
                'separator' => 'before',
                'selector' => '.wl {{WRAPPER}} .wl-ptf-pricing-area',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_price_box_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptf-pricing-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'pricing_table_price_box_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-ptf-pricing-area',
            ]
        );

        $this->start_controls_tabs(
            'pricing_table_price_tab',
            [
                'separator' => 'before',
            ]
        );

        $this->start_controls_tab(
            'pricing_table_price_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_price_box_bg',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.wl {{WRAPPER}} .wl-ptf-pricing-area',
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'price_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-ptf-fancy-price, {{WRAPPER}} .wl-ptf-price-area .wl-ptf-sale-on del',
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
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_price_box_bg_hover',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-pricing-area',
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'price_gradient_color_hover',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-fancy-price, {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-price-area .wl-ptf-sale-on del',
            ]
        );

        $this->add_control(
            'pricing_table_price_box_bg_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-pricing-area' => 'transition-duration: {{SIZE}}s',
                ],
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
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-sale-price',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
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
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-sale-price',
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
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-sale-price',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
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
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-ptf-pricing-period',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
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
                'selector' => '.wl {{WRAPPER}} .wl-ptf-pricing-period',
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
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-pricing-period',
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
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-title',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                ],
            ]
        );


        $this->add_control(
            'title_align',
            [
                'label'     => __( 'Alignment', 'woolementor-pro' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'      => [
                        'title' => __( 'Left', 'woolementor-pro' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title' => __( 'Center', 'woolementor-pro' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'woolementor-pro' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'toggle'    => true,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-title' => 'text-align: {{VALUE}};',
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
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-title',
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
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-title',
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
            'features_default_style',
            [
                'label' => __( 'View', 'plugin-domain' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-feature-list' => 'margin:0;padding:0;list-style:none;',
                ],                
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'features_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptff-desc',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                ],
            ]
        );

        $this->add_control(
            'features_align',
            [
                'label'     => __( 'Alignment', 'woolementor-pro' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'      => [
                        'title' => __( 'Left', 'woolementor-pro' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title' => __( 'Center', 'woolementor-pro' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'woolementor-pro' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'toggle'    => true,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-feature-list' => 'text-align: {{VALUE}};',
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-pricing-icon-svg' => 'width: 20px;',
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
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-feature-list i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-pricing-icon-svg' => 'width: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-featute' => 'margin: {{SIZE}}{{UNIT}} 0{{UNIT}};',
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
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy .wl-ptff-desc',
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
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptff-desc',
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
                'condition' => [
                    'show_purchase_btn' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-ptf-purchase-btn',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
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
                    '.wl {{WRAPPER}} .wl-ptf-purchase-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_btn_border',
                'label' => __( 'Border', 'woolementor-pro' ),
                'selector' => '.wl {{WRAPPER}} .wl-ptf-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'btn_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-ptf-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_btn_bg',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.wl {{WRAPPER}} .wl-ptf-purchase-btn',
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
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_btn_border_hover',
                'label' => __( 'Border', 'woolementor-pro' ),                
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'btn_gradient_color_hover',
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_btn_bg_hover',
                'label' => __( 'Background', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '.wl {{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-purchase-btn',
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
                    '.wl {{WRAPPER}} .wl-ptf-purchase-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-ptf-purchase-btn' => 'Margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_badge',
            [
                'label' => __( 'Badge', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'general_is_featured' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'badge_offset_toggle',
            [
                'label'         => __( 'Offset', 'woolementor-pro' ),
                'type'          => Controls_Manager::POPOVER_TOGGLE,
                'label_off'     => __( 'None', 'woolementor-pro' ),
                'label_on'      => __( 'Custom', 'woolementor-pro' ),
                'return_value'  => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'media_offset_x',
            [
                'label'         => __( 'Offset Left', 'woolementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'badge_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 350,
                    ],
                ],
                'render_type'   => 'ui',
            ]
        );

        $this->add_responsive_control(
            'media_offset_y',
            [
                'label'         => __( 'Offset Top', 'woolementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'badge_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 350,
                    ],
                ],
                'selectors'     => [
                    // Media translate styles
                    '(desktop){{WRAPPER}} .wl-ptf-featured-badge-text' => '-ms-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}) rotate({{sale_ribbon_transform.SIZE}}deg);',
                    '(tablet){{WRAPPER}} .wl-ptf-featured-badge-text' => '-ms-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .wl-ptf-featured-badge-text' => '-ms-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();

        $this->add_responsive_control(
            'badge_width',
            [
                'label'     => __( 'Width', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptf-featured-badge-text' => 'width: {{SIZE}}{{UNIT}}',
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
            'badge_height',
            [
                'label'     => __( 'Height', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptf-featured-badge-text' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 100
                    ]
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_transform',
            [
                'label'     => __( 'Transform', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptf-featured-badge-text' => '-webkit-transform: rotate({{SIZE}}deg); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}) rotate({{SIZE}}deg);',
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
            'badge_font_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptf-featured-badge-text' => 'color: {{VALUE}}',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'badge_content_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-ptf-featured-badge-text',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                ],
            ]
        );

        $this->add_control(
            'badge_background',
            [
                'label'         => __( 'Background', 'woolementor-pro' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptf-featured-badge-text' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptf-featured-badge-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'badge_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-ptf-featured-badge-text',
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'badge_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptf-featured-badge-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
        $id       = $this->get_id();
        
        extract( $settings );

        $del_start = '';
        $del_close = '';
        $sale_price_on = '';

        if ( $show_sale_price == 'yes' ) {
            $del_start = '<del>';
            $del_close = '</del>';
            $sale_price_on = 'wl-ptf-sale-on';
        }
        
        $ptf_featured = $general_is_featured == 'yes' ? 'ptf-featured' : '';

        $this->render_editing_attributes();        
        ?>

        <div class="wl-pricing-table-fancy <?php echo esc_attr( $ptf_featured  ); ?>">

            <div class="wl-ptf-pricing-area" id="wl-ptf-pricing-area-<?php echo esc_attr( $id ); ?>">
                <?php if ( 'yes' == $general_is_featured ): ?>
                    <span class="wl-ptf-featured-badge-text"><?php echo esc_html( $general_is_featured_badge_text ); ?></span>
                <?php endif; ?>
                <div class="wl-ptf-pricing-content">
                    <div class="wl-ptf-price-area">
                        <?php if( 'left' == $pricing_table_currency_alignment ): ?>
                            <div class="wl-ptf-fancy-price <?php esc_attr_e( $sale_price_on ); ?>">
                                <?php 
                                    echo $del_start; ?><span class="wl-ptf-currency"><?php echo esc_html( $pricing_table_currency ); ?></span><?php 
                                    printf( '<span %s>%s</span>',
                                        $this->get_render_attribute_string( 'pricing_table_price' ),
                                        esc_html( $pricing_table_price )
                                    );
                                    echo $del_close; 
                                ?>
                            </div>
                            <?php if( 'yes' == $show_sale_price ): ?>
                                <div class="wl-ptf-sale-price">
                                    <span class="wl-ptf-currency"><?php echo esc_html( $pricing_table_currency ); ?></span><?php 
                                        printf( '<span %s>%s</span>',
                                            $this->get_render_attribute_string( 'pricing_table_sale_price' ),
                                            esc_html( $pricing_table_sale_price )
                                        );
                                    ?>
                                </div>
                            <?php endif;
                        elseif( 'right' == $pricing_table_currency_alignment ): ?>
                            <div class="wl-ptf-fancy-price <?php echo esc_attr_e( $sale_price_on ) ?>">

                                <?php 
                                echo $del_start; 
                                printf( '<span %s>%s</span>',
                                    $this->get_render_attribute_string( 'pricing_table_price' ),
                                    esc_html( $pricing_table_price )
                                );
                                ?><span class="wl-ptf-currency"><?php echo esc_html( $pricing_table_currency ); ?></span><?php echo $del_close; ?>
                            </div>
                            <?php if( 'yes' == $show_sale_price ): ?>
                                <div class="wl-ptf-sale-price">
                                    <?php 
                                    printf( '<span %s>%s</span>',
                                        $this->get_render_attribute_string( 'pricing_table_sale_price' ),
                                        esc_html( $pricing_table_sale_price )
                                    );
                                    ?><span class="wl-ptf-currency"><?php echo esc_html( $pricing_table_currency ); ?></span>
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
            <div class="wl-ptf-feature-area">

                <?php 
                    printf( '<h3 %s>%s</h3>',
                        $this->get_render_attribute_string( 'pricing_table_title' ),
                        esc_html( $pricing_table_title )
                    );
                ?>

                <ul class="wl-ptf-feature-list">

                    <?php 
                    $section_id = $this->get_id();
                    $styling = '';
                    if( count( $pricing_table_features ) > 0 ): 
                        foreach ($pricing_table_features as $key => $feature): 

                            $styling .= ".wl-ptff-icon-{$section_id}{$feature['_id']} {color: {$feature['icon_color']}} .wl-pricing-table-fancy:hover .wl-ptff-icon-{$section_id}{$feature['_id']}{color: {$feature['icon_hover_color']}}";
                            ?>

                        <li class="wl-ptf-featute">
                            <span class="wl-ptff-icon wl-ptff-icon-<?php esc_attr_e( $section_id.$feature['_id'] ); ?>">
                                <?php 
                                    if ( $feature['pricing_table_features_icon']['library'] == 'svg' ) {
                                        $svg = esc_url( $feature['pricing_table_features_icon']['value']['url'] );
                                        echo "<img class='wl-ptf-pricing-icon-svg' src='{$svg}' />";
                                    }
                                    else{
                                        $icon = esc_attr( $feature['pricing_table_features_icon']['value'] );
                                        echo "<i class='{$icon}'></i>";
                                    }
                                 ?>
                            </span>
                            <span class="wl-ptff-desc"><?php echo esc_html( $feature['pricing_table_features_text'] ) ?></span>
                        </li>

                    <?php endforeach; endif; ?>
                </ul>
                <?php if( 'yes' == $show_purchase_btn ): ?>
                <div class="wl-ptf-purchase">

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
        /**
         * Load Script
         */
        $this->render_script();
	}

    protected function render_script() {
        $id = $this->get_id();
        ?>
        <script type="text/javascript">
            jQuery(function($){

                // var width = $('#wl-ptf-pricing-area-<?php echo esc_attr( $id ); ?>').width()
                // $('#wl-ptf-pricing-area-<?php echo esc_attr( $id ); ?>').css({'height':width+'px'})

                $(window).resize(function() {
                    var width = $('#wl-ptf-pricing-area-<?php echo esc_attr( $id ); ?>').width();
                    $('#wl-ptf-pricing-area-<?php echo esc_attr( $id ); ?>').css({'height':width+'px'});
                    console.log( width );
                    console.log( $('#wl-ptf-pricing-area-<?php echo esc_attr( $id ); ?>') );

                }).resize();
            })
        </script>
        <?php
    }

    protected function render_editing_attributes() {
        $settings = $this->get_settings_for_display();
        extract( $settings );

        $btn_url    = esc_url( $pricing_table_btn_link['url'] );
        $target     = $pricing_table_btn_link['is_external'] ? '_blank' : '';
        $nofollow   = $pricing_table_btn_link['nofollow'] ? 'nofollow' : '';

        $this->add_inline_editing_attributes( 'pricing_table_price', 'none' );
        $this->add_render_attribute( 'pricing_table_price', 'class', 'wl-ptf-price' );

        $this->add_inline_editing_attributes( 'pricing_table_sale_price', 'none' );
        $this->add_render_attribute( 'pricing_table_sale_price', 'class', 'wl-ptf-price' );

        $this->add_inline_editing_attributes( 'pricing_table_period', 'none' );
        $this->add_render_attribute( 'pricing_table_period', 'class', 'wl-ptf-pricing-period' );

        $this->add_inline_editing_attributes( 'pricing_table_title', 'none' );
        $this->add_render_attribute( 'pricing_table_title', 'class', 'wl-ptf-title' );

        $this->add_inline_editing_attributes( 'pricing_table_btn_text', 'none' );
        $this->add_render_attribute( 'pricing_table_btn_text', 'class', 'wl-ptf-purchase-btn' );

        $this->add_render_attribute( 'pricing_table_btn_text', 'href', $btn_url );
        $this->add_render_attribute( 'pricing_table_btn_text', 'target', $target );
        $this->add_render_attribute( 'pricing_table_btn_text', 'rel', $nofollow );
    }
}