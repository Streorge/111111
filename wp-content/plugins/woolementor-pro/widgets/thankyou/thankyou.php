<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Thankyou extends Widget_Base {

	public $id;
	protected $form_close='';

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
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


		$this->start_controls_section(
			'thankyou_notice_content',
			[
				'label' => __( 'Thank You Message', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'notice_description',
			[
				'label' => __( '', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::TEXTAREA,
				'default' => __( 'Thank you. Your order has been received.', 'woolementor-pro' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_order_info',
			[
				'label' => __( 'Order Info', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'info_title_visibility',
			[
				'label' => __( 'Show Title', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Show', 'woolementor-pro' ),
				'label_off' => __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'order_info_title',
			[
				'label' => __( 'Text', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::TEXT,
                'condition' => [
                    'info_title_visibility' => 'yes'
                ],
				'default' => __( 'Order Info', 'woolementor-pro' ),
			]
		);


		$this->add_control(
			'order_info_title_tag',
			[
				'label' 	=> __( 'HTML Tag', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'h3',
				'options' 	=> [
					'h1'  => __( 'H1', 'woolementor-pro' ),
					'h2'  => __( 'H2', 'woolementor-pro' ),
					'h3'  => __( 'H3', 'woolementor-pro' ),
					'h4'  => __( 'H4', 'woolementor-pro' ),
					'h5'  => __( 'H5', 'woolementor-pro' ),
					'h6'  => __( 'H6', 'woolementor-pro' ),
				],
                'condition' => [
                    'info_title_visibility' => 'yes'
                ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_notice',
			[
				'label' => __( 'Thank you', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		// start default style
		$this->add_control(
			'thankyou_default_styles',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-tnq-order-col1' => 'display: inline-block;',
					'.wl {{WRAPPER}} ul.woolementor-order-overview li' => 'padding: 12px;margin: 0px;',
					'.wl {{WRAPPER}} .woolementor-thankyou table.woocommerce-table.woocommerce-table--order-details.shop_table.order_details' => 'text-align: left;',
					'.wl {{WRAPPER}} .woolementor-order-overview' => 'list-style: none;padding-left: 0;',
				],
				'default' => 'traditional',
			]
		);
		// end default css

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'thankyou_notice_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woolementor-notice',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'thankyou_notice_color',
				'selector' 	=> '{{WRAPPER}} .woolementor-notice',
			]
		);

		$this->add_control(
            'thankyou_notice_alignment',
            [
                'label' 	   => __( 'Alignment', 'woolementor-pro' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
                    'left' 		=> [
                        'title' 	=> __( 'Left', 'woolementor-pro' ),
                        'icon' 		=> 'eicon-text-align-left',
                    ],
                    'center' 	=> [
                        'title' 	=> __( 'Center', 'woolementor-pro' ),
                        'icon' 		=> 'eicon-text-align-center',
                    ],
                    'justify' 	=> [
                        'title' 	=> __( 'Justify', 'woolementor-pro' ),
                        'icon' 		=> 'eicon-text-align-justify',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'woolementor-pro' ),
                        'icon' 		=> 'eicon-text-align-right',
                    ],
                ],
                'default' 	=> 'left',
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .woolementor-notice' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'thankyou_notice_background',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .woolementor-notice',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'thankyou_notice_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .woolementor-notice',
			]
		);

		$this->add_control(
			'thankyou_notice_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'separator' 	=> 'after',
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .woolementor-notice' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thankyou_notice_padding',
			[
				'label' => __( 'Padding', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .woolementor-notice' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_info_title_style',
			[
				'label' => __( 'Order Info Title', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
                'condition' => [
                    'info_title_visibility' => 'yes'
                ],
			]
		);

		$this->add_control(
            'order_info_title_alignment',
            [
                'label' 	   => __( 'Alignment', 'woolementor-pro' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
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
                'default' 	=> 'left',
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .woolementor-thankyou .thankyou_order_info_title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_info_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .thankyou_order_info_title',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'order_info_title_color',
				'selector' 	=> '{{WRAPPER}} .thankyou_order_info_title',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'order_info_input_background_color',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .thankyou_order_info_title',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'order_info_title_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .thankyou_order_info_title',
				'separator' => 'before',
			]
		);

       $this->add_control(
			'order_info_title_border_radius',
			[
				'label' 	=> __( 'Border Redius', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .thankyou_order_info_title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'order_info_title_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .thankyou_order_info_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'order_info_title_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .thankyou_order_info_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_info_style',
			[
				'label' => __( 'Order Info', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'order_info_column',
			[
				'label' => __( 'Column Width', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' 	=> 50,
						'max' 	=> 900,
						'step' 	=> 5,
					],
					'%' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 130,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .woolementor-order-overview .wl-tnq-order-col1' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_info_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .woolementor-order-overview li',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'order_info_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woolementor-order-overview li' => 'color: {{VALUE}}',
				],
				'default' => 'var(--wl-black)'
			]
		);

		$this->add_control(
			'order_info_bg_color1',
			[
				'label'     => __( 'Background Color(Odd row)', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woolementor-order-overview li:nth-child(odd)' => 'background: {{VALUE}}',
				],
				'default' => 'rgba(0, 0, 0, 0.1);'
			]
		);

		$this->add_control(
			'order_info_bg_color2',
			[
				'label'     => __( 'Background Color(Even row)', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woolementor-order-overview li:nth-child(even)' => 'background: {{VALUE}}',
				],
				'default' => 'rgba(0, 0, 0, 0.2);'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_details_title_style',
			[
				'label' => __( 'Order Details Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
            'order_details_title_alignment',
            [
                'label' 	   => __( 'Alignment', 'woolementor-pro' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
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
                'default' 	=> 'left',
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .woolementor-thankyou .woocommerce-order-details .woocommerce-order-details__title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details h2',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 15 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'order_details_title_color',
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details h2',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'order_details_input_background_color',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details h2',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'order_details_title_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details h2',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'order_details_title_border_radius',
			[
				'label' 	=> __( 'Border Redius', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details h2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'order_details_title_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'order_details_title_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .woocommerce-order-details h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_details_table_style',
			[
				'label' => __( 'Order Details Table', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'order_details_table_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
				'selector' 	=> '
					{{WRAPPER}} .woocommerce-order-details table tr th,
					{{WRAPPER}} .woocommerce-order-details table tr td',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' 		=> [
							'top' 		=> '1',
							'right' 	=> '1',
							'bottom' 	=> '1',
							'left' 		=> '1',
							'isLinked' 	=> false,
						],
					],
					'color' => [
						'default' => '#ccc',
					],
				],
			]
		);

		$this->start_controls_tabs(
			'order_details_table_style_tab'
		);

		$this->start_controls_tab(
			'order_details_table_header',
			[
				'label' => __( 'Header', 'woolementor-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_th_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details table thead tr th',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'order_details_th_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table thead th' => 'color: {{VALUE}}'
				],
				'default' 	=> 'var(--wl-black)'
			]
		);

		$this->add_control(
			'order_th_bg_color',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table thead th' => 'background: {{VALUE}}',
				],
				'default' 	=> 'transparent;'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'order_details_table_body',
			[
				'label' => __( 'Body', 'woolementor-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_tbody_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details table tbody tr td',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'order_details_tbody_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tbody td' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-order-details table tbody td a' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'order_tbody_bg_color',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tbody td' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'order_details_table_foot',
			[
				'label' => __( 'Footer', 'woolementor-pro' ),
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_tfoot_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
				'selector' 	=> '
					{{WRAPPER}} .woocommerce-order-details table tfoot tr th,
					{{WRAPPER}} .woocommerce-order-details table tfoot tr td',
			]
		);

		$this->add_control(
			'order_details_tfoot_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tfoot th' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-order-details table tfoot td' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'order_tfoot_bg_color',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tfoot th,
					{{WRAPPER}} .woocommerce-order-details table tfoot td' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_addresses',
			[
				'label' => __( 'Addresses', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'thankyou_addresses_background',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .woocommerce-customer-details',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 	=> 'thankyou_addresses_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .woocommerce-customer-details',
			]
		);

		$this->add_control(
			'thankyou_addresses_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'after',
				'selectors' 	=> [
					'{{WRAPPER}} .woocommerce-customer-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thankyou_addresses_padding',
			[
				'label' => __( 'Padding', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .woocommerce-customer-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'thankyou_addresses_style_tab'
		);

		$this->start_controls_tab(
			'thankyou_addresses_title',
			[
				'label' => __( 'Titles', 'woolementor-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'thankyou_addresses_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details h2',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 15 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'thankyou_addresses_title_color',
				'selector' 	=> '{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details h2',
			]
		);

		$this->add_group_control(

			Group_Control_Background::get_type(),
			[
				'name' 		=> 'thankyou_addresses_input_background_color',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details h2',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'thankyou_addresses_title_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details h2',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'thankyou_addresses_title_border_radius',
			[
				'label' 	=> __( 'Border Redius', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details h2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thankyou_addresses_title_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thankyou_addresses_title_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'thankyou_addresses_content',
			[
				'label' => __( 'Contents', 'woolementor-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'thankyou_addresses_contents_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details address',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'thankyou_addresses_contents_color',
				'selector' 	=> '{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details address',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
		if ( ! is_woocommerce_activated() || ! apply_filters( 'woolementor-is_allowed', wcd_is_edit_mode() || wcd_is_preview_mode() || is_order_received_page() || is_checkout_pay_page() , get_the_ID() ) ) return;
		
		$settings = $this->get_settings_for_display();
		// extract( $settings );

		/**
		 * Load attributes
		 */
		$this->render_editing_attributes();
		?>

		<div class="woolementor-thankyou">
			<?php 
			if( !wcd_is_edit_mode() && !wcd_is_preview_mode() && isset( $_GET['key'] ) ) { 
				$order_id 	= wc_get_order_id_by_order_key( sanitize_text_field( $_GET['key'] ) );
			}
			else { 
				$order_id = wcd_get_random_order_id();

				if ( !$order_id ) {
					echo wcd_notice( __( 'No orders found. Please create a test order to preview this section.', 'woolementor-pro' ) );
					return;
				}
				else{
					echo wcd_notice( __( 'A random order is shown for preview purposes only. Your customers won\'t see this message.', 'woolementor-pro' ) );
				}
			}

			$order 	= wc_get_order( $order_id );

			if ( is_checkout_pay_page() ) :
				?>
				<div class="woocommerce">
					<ul class="order_details">
						<li class="order">
							<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
							<strong><?php echo esc_html( $order->get_order_number() ); ?></strong>
						</li>
						<li class="date">
							<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
							<strong><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong>
						</li>
						<li class="total">
							<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
							<strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong>
						</li>
						<?php if ( $order->get_payment_method_title() ) : ?>
						<li class="method">
							<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
							<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
						</li>
						<?php endif; ?>
					</ul>

					<?php do_action( 'woocommerce_receipt_' . $order->get_payment_method(), $order->get_id() ); ?>
				</div>
				<div class="clear"></div>
				<?php
			else:

				if ( $order ) :

					do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

					<?php if ( $order->has_status( 'failed' ) ) : ?>

						<p class="woolementor-notice woolementor-notice--error woolementor-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

						<p class="woolementor-notice woolementor-notice--error woolementor-thankyou-order-failed-actions">
							<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
							<?php if ( is_user_logged_in() ) : ?>
								<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
							<?php endif; ?>
						</p>

					<?php else :
						
						printf( '<p %s>'. apply_filters( 'woocommerce_thankyou_order_received_text', '%s', $order ) .'</p>',
							$this->get_render_attribute_string( 'notice_description' ),
							esc_html( $settings['notice_description'] )
						);

						if( 'yes' == $settings['info_title_visibility'] ):

							printf( '<%1$s %2$s>%3$s</%1$s>',
								esc_attr( $settings['order_info_title_tag'] ),
								$this->get_render_attribute_string( 'order_info_title' ),
								esc_html( $settings['order_info_title'] )
							);

						endif; 
						?>

						<ul class="woolementor-order-overview woolementor-thankyou-order-details order_details">
							<li class="woolementor-order-overview__order order">
								<span class="wl-tnq-order-col1"><?php esc_html_e( 'Order number:', 'woocommerce' ); ?></span>
								<strong><?php echo $order->get_order_number(); ?></strong>
							</li>
							<li class="woolementor-order-overview__date date">
								<span class="wl-tnq-order-col1"><?php esc_html_e( 'Date:', 'woocommerce' ); ?></span>
								<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
							</li>

							<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
								<li class="woolementor-order-overview__email email">
									<span class="wl-tnq-order-col1"><?php esc_html_e( 'Email:', 'woocommerce' ); ?></span>
									<strong><?php echo $order->get_billing_email(); ?></strong>
								</li>
							<?php endif; ?>

							<li class="woolementor-order-overview__total total">
								<span class="wl-tnq-order-col1"><?php esc_html_e( 'Total:', 'woocommerce' ); ?></span>
								<strong><?php echo $order->get_formatted_order_total(); ?></strong>

							<?php if ( $order->get_payment_method_title() ) : ?>
								<li class="woolementor-order-overview__payment-method method">
									<span class="wl-tnq-order-col1"><?php esc_html_e( 'Payment method:', 'woocommerce' ); ?></span>
									<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
								</li>
							<?php endif; ?>
						</ul>

					<?php endif;

					do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
					do_action( 'woocommerce_thankyou', $order->get_id() );

					else : ?>

					<p class="woolementor-notice woolementor-notice--success woolementor-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woolementor-pro' ), null ); ?></p>

				<?php endif; //order; 

			endif; //is_checkout_pay_page?>

		</div>

		<?php
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'notice_description', 'none' );
		$this->add_render_attribute( 'notice_description', 'class', 'woolementor-notice woolementor-notice--success woolementor-thankyou-order-received' );

		$this->add_inline_editing_attributes( 'order_info_title', 'none' );
		$this->add_render_attribute( 'order_info_title', 'class', 'thankyou_order_info_title' );
	}
}

