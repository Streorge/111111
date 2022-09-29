<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Order_Pay extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [ 'wc-checkout' ];
	}

	public function get_style_depends() {
		return [ 'woocommerce-general', 'woocommerce-layout' ];
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
			'order_notes_title',
			[
				'label' => __( 'Review Section Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'order_review_title_show',
            [
                'label'         => __( 'Show/Hide Title', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
		//order_button_text
		$this->add_control(
		    'order_review_title_text',
		    [
		        'label' 		=> __( 'Text', 'woolementor-pro' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Order Review', 'woolementor-pro' ),
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
		    ]
		);

		$this->add_control(
			'order_review_title_tag',
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
                    'order_review_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'order_review_title_alignment',
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
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-order-pay-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'payment_methods_content',
			[
				'label' => __( 'Order Button', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'order_button_text',
		    [
		        'label' 		=> __( 'Button Text', 'woolementor-pro' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Pay or orders', 'woolementor-pro' ),
		    ]
		);

		$this->end_controls_section();

		//section title style
		$this->start_controls_section(
			'order_review_title_style',
			[
				'label' => __( 'Review Table Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
			]
		);

		// start default style
		$this->add_control(
			'order_pay_default_styles',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-order-pay thead tr' => 'border: 1px solid #ccc',
					'.wl {{WRAPPER}} .wl-order-pay table.shop_table' => 'width: 100%;margin-bottom: 20px;',
				],
				'default' => 'traditional',
			]
		);
		// end default css

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_review_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 22 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
				'selector' 	=> '{{WRAPPER}} .wl-order-pay-title',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'order_review_title_color',
				'selector' => '{{WRAPPER}} .wl-order-pay-title',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'order_pay_input_background_color',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .wl-order-pay-title',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'order_pay_title_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .wl-order-pay-title',
				'separator' => 'before',
			]
		);


       $this->add_control(
			'order_pay_title_border_radius',
			[
				'label' 	=> __( 'Border Redius', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'order_pay_title_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'order_pay_title_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-order-pay-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Table border controll
		 */
		$this->start_controls_section(
			'order_table_border_style',
			[
				'label' => __( 'Table Sell Border', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name'      => 'table_border_type',
		        'label'     => __( 'Border', 'woolementor-pro' ),
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
		        'selector'  => '
		        	{{WRAPPER}} .wl-order-pay table tr td,
		        	{{WRAPPER}} .wl-order-pay table tr th',
		    ]
		);

		$this->end_controls_section();

		/**
		 * Table Header controll
		 */
		$this->start_controls_section(
			'order_table_header_style',
			[
				'label' => __( 'Table Header', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_thead_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay thead tr th',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 15 ] ],
					'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

        $this->add_control(
			'order_thead_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay thead tr th' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'order_thead_bg_color',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay thead tr th' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
            'order_thead_alignment',
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
                    '{{WRAPPER}} .wl-order-pay thead tr th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
        	'order_thead_padding',
        	[
        		'label' => __( 'Padding', 'woolementor-pro' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-order-pay thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->end_controls_section();

		/**
		 * Table body controll
		 */
		$this->start_controls_section(
			'order_tbody_style',
			[
				'label' => __( 'Table Body', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_tbody_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay tbody tr td',
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
			'order_tbody_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay tbody tr td' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_tbody_bg_color',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay tbody tr td' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
            'order_tbody_alignment',
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
                    '{{WRAPPER}} .wl-order-pay tbody tr td' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
        	'order_tbody_padding',
        	[
        		'label' => __( 'Padding', 'woolementor-pro' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-order-pay table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			'{{WRAPPER}} .wl-order-pay table tbody tr td span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			'{{WRAPPER}} .wl-order-pay table tbody tr td ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->end_controls_section();

		/**
		 * Table footer controll
		 */
		$this->start_controls_section(
			'order_tfoot_style',
			[
				'label' => __( 'Table Footer', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_tfoot_typographyrs',
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
					{{WRAPPER}} .wl-order-pay tfoot tr td,
					{{WRAPPER}} .wl-order-pay tfoot tr th',
			]
		);

        $this->add_control(
			'order_tfoot_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay tfoot tr td,
					 {{WRAPPER}} .wl-order-pay tfoot tr th' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_tfoot_bg_color',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay tfoot tr td,
					 {{WRAPPER}} .wl-order-pay tfoot tr th' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
            'order_tfoot_alignment',
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
                    '{{WRAPPER}} .wl-order-pay tfoot tr td,
					 {{WRAPPER}} .wl-order-pay tfoot tr th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
        	'order_tfoot_padding',
        	[
        		'label' => __( 'Padding', 'woolementor-pro' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-order-pay tfoot tr td,
					 {{WRAPPER}} .wl-order-pay tfoot tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'payment_title_style',
			[
				'label' => __( 'Payment method Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'payment_title_show' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'payment_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
				'selector' 	=> '{{WRAPPER}} .wl-order-pay .wl-op-payments',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'payment_title_color',
				'selector' => '{{WRAPPER}} .wl-order-pay .wl-op-payments',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'order_pay_payment_input_background_color',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .wl-order-pay .wl-op-payments',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'order_pay_payment_title_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .wl-order-pay .wl-op-payments',
				'separator' => 'before',
			]
		);
		
        $this->add_control(
			'order_pay_payment_title_border_radius',
			[
				'label' 	=> __( 'Border Redius', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay .wl-op-payments' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'order_pay_payment_title_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay .wl-op-payments' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'payment_title_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-order-pay .wl-op-payments' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Input Label Color
		 */
		$this->start_controls_section(
			'_pm_footer_style',
			[
				'label' => __( 'Payment Methods', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'pm_bg_color',
			[
				'label'     => __( 'Section Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->start_controls_tabs('payement methods');

		$this->start_controls_tab(
		    'pm_titles',
		    [
		        'label' => __( 'Titles', 'woolementor-pro' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'pm_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
				'selector' 	=> '{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method label',
			]
		);

        $this->add_control(
			'pm_text_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    'pm_contents',
		    [
		        'label' => __( 'Contents', 'woolementor-pro' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'pm_content_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
				'selector' 	=> '{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box',
			]
		);

        $this->add_control(
			'pm_content_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pm_content_bg_color',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box::before' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		//section footer style
		$this->start_controls_section(
			'payment_footer_style',
			[
				'label' => __( 'Footer', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'payment_footer_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
				'selector' 	=> '{{WRAPPER}} .wl-order-pay .form-row',
			]
		);

		$this->add_control(
			'pm_footer_content_color',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay .form-row' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pm_footer_content_text_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper .woocommerce-terms-and-conditions-link a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper .woocommerce-privacy-policy-text a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pm_footer_content_href_color',
			[
				'label'     => __( 'Hyperlink Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper .woocommerce-terms-and-conditions-link a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper .woocommerce-privacy-policy-text a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'payment_btn_style',
			[
				'label' => __( 'Order Button', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'payment_btn_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
				'selector' 	=> '{{WRAPPER}} .wl-order-pay .form-row .button',
			]
		);

		$this->add_control(
			'pm_btn_padding',
			[
				'label'         => __( 'Padding', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} #payment .form-row .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pm_btn_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} #payment .form-row .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'pm_btn_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'pm_btn_normal',
			[
				'label'     => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'pm_btn_text_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row .button' => 'color: {{VALUE}}',
				],
				'default' 	=> '#fff'
			]
		);

		$this->add_control(
			'pm_btn_color',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row .button' => 'background-color: {{VALUE}}',
				],
				'default' => 'var(--wl-black)'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pm_btn_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} #payment .form-row .button',
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
						'default' => 'var(--wl-black)',
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pm_btn_hover',
			[
				'label'     => __( 'Hover', 'woolementor-pro' ),
			]
		);
		
		$this->add_control(
			'pm_btn_text_color_hover',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row .button:hover' => 'color: {{VALUE}}',
				],
				'default' => '#fff'
			]
		);

		$this->add_control(
			'pm_btn_color_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row .button:hover' => 'background-color: {{VALUE}}',
				],
				'default' => 'var(--wl-black)'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pm_btn_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} #payment .form-row .button:hover',
			]
		);

        $this->add_control(
            'pm_btn_border_hover_transition',
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
                    '{{WRAPPER}} #payment .form-row .button:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {

		global $wp;

		if ( wcd_is_order_pay_page() ) {
			$order_id = absint( $wp->query_vars['order-pay'] );
		}
		elseif( wcd_is_edit_mode() || wcd_is_preview_mode() ) { 			
			$order_id = wcd_get_random_order_id();

			if ( !$order_id ) {
				echo wcd_notice( __( 'No orders found. Please create a test order to preview this section.', 'woolementor-pro' ) );
				return;
			}
			else{
				echo wcd_notice( __( 'A random order is shown for preview purposes only. Your customers won\'t see this message.', 'woolementor-pro' ) );
			}
		}
		else{
			return;
		}
		
		$settings = $this->get_settings_for_display();

		/**
		 * Load attributes
		 */
		$this->render_editing_attributes();

		$order     			= wc_get_order( $order_id );
		$available_gateways = WC()->payment_gateways->get_available_payment_gateways();


		if( 'yes' == $settings['order_review_title_show'] ): 

			printf( '<%1$s %2$s>%3$s</%1$s>',
				esc_attr( $settings['order_review_title_tag'] ),
				$this->get_render_attribute_string( 'order_review_title_text' ),
				esc_html( $settings['order_review_title_text'] )
			);

		endif;

		echo '<div class="wl-order-pay">';
		echo '<div class="woocommerce">';

		if( wcd_is_edit_mode() ) { 
			wc_get_template( 'checkout/form-pay.php', [ 'order' => $order, 'available_gateways' => $available_gateways, 'order_button_text' => $settings['order_button_text'] ] );
		}

		if ( !empty( $wp->query_vars['order-pay'] ) && isset( $_GET['key'] ) && !isset( $_GET['pay_for_order'] ) ) {
			wc_get_template( 'checkout/order-receipt.php', [ 'order' => $order ] );
		}
		elseif ( !empty( $wp->query_vars['order-pay'] ) || isset( $_GET['pay_for_order'], $_GET['key'] ) ) {
			wc_get_template( 'checkout/form-pay.php', [ 'order' => $order, 'available_gateways' => $available_gateways, 'order_button_text' => $settings['order_button_text'] ] );
		}

		echo '</div>';
		echo '</div>';

		/**
		 * Load Script
		 */
		$this->render_script();
	}

	protected function render_script() {
		?>
		<script type="text/javascript">
			jQuery(function($){
				$( '#billing_state, #billing_city, #billing_postcode' ).on( 'change', function() {
					$( document.body ).trigger( 'update_checkout' );
				} )
			})
		</script>
		<?php
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'order_review_title_text', 'none' );
		$this->add_render_attribute( 'order_review_title_text', 'class', 'wl-order-pay-title' );
	}
}

