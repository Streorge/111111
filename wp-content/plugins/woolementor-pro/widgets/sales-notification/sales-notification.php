<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Sales_Notification extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [];
	}

	public function get_style_depends() {
		return [];
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
		 * Product Title
		 */
		$this->start_controls_section(
			'sectio_cat',
			[
				'label' 		=> __( 'Content', 'woolementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'notification_from',
			[
				'label' 		=> __( 'Content Source', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'this_site'  	=> __( 'From This Site', 'woolementor-pro' ),
					'from_api' 		=> __( 'From API', 'woolementor-pro' ),
				],
				'default' 		=> 'this_site',
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'api_url',
			[
				'label' 		=> __( 'API URL', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> 'https://your-link.com/api',
				'default' 		=> [
					'url' => '',
				],
				'label_block' 	=> true,
				'description' 	=> __( 'REST API URL to fetch order data from.', 'woolementor-pro' ),
                'condition' => [
            		'notification_from' => 'from_api'
                ],
			]
		);

		$this->add_control(
			'enable_url',
			[
				'label' 	=> __( 'Link To Product', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'ON', 'woolementor-pro' ),
				'label_off' => __( 'OFF', 'woolementor-pro' ),
				'return_value' => 'yes',
				'default' 	=> 'yes',
			]
		);

        $this->add_control(
			'notification_type',
			[
				'label' 		=> __( 'Content Type', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'real_data'  	=> __( 'Real Data', 'woolementor-pro' ),
					'fake_data' 	=> __( 'Fake Data', 'woolementor-pro' ),
					'both_data' 	=> __( 'Both ', 'woolementor-pro' ),
				],
				'default' 		=> 'fake_data',
				'label_block' 	=> true,
				'condition' 	=> [
					'notification_from' => 'this_site'
				],
			]
		);

		$this->add_control(
			'orders_limit',
			[
				'label' 		=> __( 'Number of Orders', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> 5,
				'label_block' 	=> true,
                'conditions' 	=> [
            		'relation' 	=> 'and',
            		'terms' 	=> [
            			[
            				'name' 		=> 'notification_type',
            				'operator' 	=> 'in',
            				'value' 	=> [ 'real_data', 'both_data' ],
            			],
            			[
            				'name' 		=> 'notification_from',
            				'operator' 	=> '==',
            				'value' 	=> 'this_site',
            			],
            		],
                ],
			]
		);

		$this->add_control(
		    'orders_statuses',
		    [
		        'label'         => __( 'Order Statuses', 'woolementor-pro' ),
		        'type'          => Controls_Manager::SELECT2,
		        'multiple'      => true,
		        'separator'     => 'after',
		        'options'       => [
		            'completed'    => __( 'Completed', 'woolementor-pro' ),
		            'processing'   => __( 'Processing', 'woolementor-pro' ),
		        ],
		        'default'       => [ 'completed', 'processing', 'on-hold' ],
                'conditions' 	=> [
                	'relation' 	=> 'and',
            		'terms' 	=> [
            			[
            				'name' 		=> 'notification_type',
            				'operator' 	=> 'in',
            				'value' 	=> [ 'real_data', 'both_data' ],
            			],
            			[
            				'name' 		=> 'notification_from',
            				'operator' 	=> '==',
            				'value' 	=> 'this_site',
            			],
            		],
                ],
		    ]
		);

		$this->add_control(
			'product_ids', [
				'label' => __( 'Specific Products', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT2,
				'multiple' 		=> true,
				'label_block' 	=> true,
				'options' 		=> Helper::get_posts( [ 'post_type' => 'product' ], false ),
				'description' 	=> __( 'Select the products you want to show' , 'woolementor-pro' ),
				'conditions' 	=> [
					'relation' => 'and',
            		'terms' => [
            			[
            				'name' 		=> 'notification_type',
            				'operator' 	=> 'in',
            				'value' 	=> [ 'real_data', 'both_data' ],
            			],
            			[
            				'name' 		=> 'notification_from',
            				'operator' 	=> '==',
            				'value' 	=> 'this_site',
            			],
            		],
				],
			]
		);

        $repeater = new Repeater();

		$repeater->add_control(
			'customer_name', [
				'label' 	=> __( 'Client Name', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXT,
				'default' 	=> __( 'John Doe' , 'woolementor-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'customer_address', [
				'label' 	=> __( 'Client Address', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXT,
				'default' 	=> __( 'Neywork, USA' , 'woolementor-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_name', [
				'label' 	=> __( 'Product Name', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXT,
				'default' 	=> __( 'Item' , 'woolementor-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_rating', [
				'label' 	=> __( 'Product Rating', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::NUMBER,
				'min' 		=> 0,
				'max' 		=> 5,
				'default' 	=> 4,
			]
		);

		$repeater->add_control(
			'product_url', [
				'label' 	=> __( 'Product URL', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXT,
				'default' 	=> __( 'https://example.com' , 'woolementor-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_image',
			[
				'label' 	=> __( 'Choose Image', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::MEDIA,
				'default' 	=> [
					'url' 	=> Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'sold_at', [
				'label' 	=> __( 'Notification Time', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXT,
				'default' 	=> __( '1 hours' , 'woolementor-pro' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'notifications',
			[
				'label' 	=> __( 'Notification List', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::REPEATER,
				'fields' 	=> $repeater->get_controls(),
				'default' 	=> [
					[
						'customer_name' 	=> __( 'John Doe', 'woolementor-pro' ),
						'customer_address' 	=> __( 'Newyork, USA', 'woolementor-pro' ),
						'product_name' 		=> __( 't-shirt', 'woolementor-pro' ),
						'sold_at' 			=> '1 hours'
					],
					[
						'customer_name' 	=> __( 'John Max', 'woolementor-pro' ),
						'customer_address' 	=> __( 'Newyork, USA', 'woolementor-pro' ),
						'product_name' 		=> __( 't-shirt with logo', 'woolementor-pro' ),
						'sold_at' 			=> '30 minutes'
					],
					[
						'customer_name' 	=> __( 'Piter Jakson', 'woolementor-pro' ),
						'customer_address' 	=> __( 'Newyork, USA', 'woolementor-pro' ),
						'product_name' 		=> __( 'album', 'woolementor-pro' ),
						'sold_at' 			=> '40 minutes'
					],
					[
						'customer_name' 	=> __( 'Alen Jakson', 'woolementor-pro' ),
						'customer_address' 	=> __( 'Newyork, USA', 'woolementor-pro' ),
						'product_name' 		=> __( 'caset', 'woolementor-pro' ),
						'sold_at' 			=> '20 minutes'
					],
				],
                'conditions' 	=> [
                	'relation' 	=> 'and',
            		'terms' 	=> [
            			[
            				'name' 		=> 'notification_type',
            				'operator' 	=> 'in',
            				'value' 	=> [ 'fake_data', 'both_data' ],
            			],
            			[
            				'name' 		=> 'notification_from',
            				'operator' 	=> '==',
            				'value' 	=> 'this_site',
            			],
            		],
                ],
				'title_field' => '{{{ customer_name }}}',
			]
		);

		$this->add_control(
			'notification_duration',
			[
				'label' 	=> __( 'Interval (millisecond)', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'separator' => 'before',
				'size_units'=> [ 'ms' ],
				'range' => [
					'ms' => [
						'min' 	=> 0,
						'max' 	=> 60000,
						'step' 	=> 10,
					],
				],
				'default' => [
					'unit' => 'ms',
					'size' => 3000,
				],
			]
		);

		$this->add_control(
			'notification_delay',
			[
				'label' 	=> __( 'Delay (millisecond)', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'ms' ],
				'range' => [
					'ms' => [
						'min' 	=> 0,
						'max' 	=> 60000,
						'step' 	=> 10,
					],
				],
				'default' => [
					'unit' => 'ms',
					'size' => 1000,
				],
			]
		);


        $this->add_responsive_control(
            'alignment',
            [
                'label' 		=> __( 'Alignment', 'woolementor-pro' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'options' 		=> [
                    'left' 		=> [
                        'title' 	=> __( 'Left', 'woolementor-pro' ),
                        'icon' 		=> 'eicon-text-align-left',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'woolementor-pro' ),
                        'icon' 		=> 'eicon-text-align-right',
                    ],
                ],
                'toggle' 		=> true,
                'default' 		=> 'left',
            ]
        );

        $this->end_controls_section();

        // Close Button
        $this->start_controls_section(
			'close_button',
			[
				'label' 		=> __( 'Close Button', 'woolementor-pro' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_colse_btn',
			[
				'label' 	=> __( 'Allow to hide', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'ON', 'woolementor-pro' ),
				'label_off' => __( 'OFF', 'woolementor-pro' ),
				'default' 	=> 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'closing_type',
			[
				'label' 		=> __( 'Hide forever', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'ON', 'woolementor-pro' ),
				'label_off' 	=> __( 'OFF', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'condition' 	=> [
					'enable_colse_btn' => 'yes'
				],
			]
		);

        $this->end_controls_section();

		/**
		 * Notification area
		 */
		$this->start_controls_section(
			'notification_style',
			[
				'label' => __( 'Card', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// start default style
		$this->add_control(
			'sale_notification_default_styles',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sales-notification' => 'position: fixed;z-index: 1000;',
					'.wl {{WRAPPER}} .wl-sales-notification .notification' => 'display: none;overflow: hidden;',
					'.wl {{WRAPPER}} .wl-sales-notification .notifications-wrapper' => 'position: relative;',
					'.wl {{WRAPPER}} .wl-sales-notification .notifications-wrapper .wl-sales-close-notification' => 'cursor: pointer;position: absolute;display: none;',
					'.wl {{WRAPPER}} .wl-sales-notification .notifications-wrapper .notifications .notification .image,
					 .wl {{WRAPPER}} .wl-sales-notification .notifications-wrapper .notifications .notification .item_details' => 'float: left;',
					'.wl {{WRAPPER}} .wl-sales-notification .notification .image img' => 'width: 100%;height: 100%;border-radius: 50%;',
					'.wl {{WRAPPER}} .wl-sales-notification .notification .item_details' => 'margin-left: 10px;',
					'.wl {{WRAPPER}} .wl-sales-notification .notification .item_details p' => 'margin-bottom: 0;',
					'.wl {{WRAPPER}} .wl-sales-notification.right' => 'right: 0;',
					'.wl {{WRAPPER}} .elementor-widget-sales-notification' => 'margin-bottom: 0px !important;',
					'.wl {{WRAPPER}} .wl-sales-notification .notification .item_details p.wl-sn-time' => 'color: #c36;font-weight: 600;',
				],
				'default' => 'traditional',
			]
		);
		// end default css

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 	=> 'nt_background',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-sales-notification .notification',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ], 
					'color' => [ 'default' => '#fff' ], 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 	=> 'border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'selector' => '.wl {{WRAPPER}} .wl-sales-notification .notification',
		        'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' 		=> '0',
							'right' 	=> '0',
							'bottom' 	=> '0',
							'left' 		=> '0',
							'isLinked'  => false,
						],
					],
					'color' => [
						'default' => '#ccc',
					],
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification .notification' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default'       => [
                    'top'           => '4',
                    'right'         => '4',
                    'bottom'        => '4',
                    'left'          => '4',
                ],
				'separator'		=> 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 			=> 'box_shadow',
				'label' 		=> __( 'Box Shadow', 'woolementor-pro' ),
				'selector' 		=> '.wl {{WRAPPER}} .wl-sales-notification .notification',
				'fields_options' => [
					'box_shadow_type' => [ 
                        'default' 	=>'yes' 
                    ],
					'box_shadow' 	=> [
						'default' 	=> [
							'horizontal' 	=> 3,
							'vertical' 		=> 3,
							'blur' 			=> 7,
							'spread' 		=> 0,
							'color' 		=> 'rgba(167.9, 167.9, 167.9, 0.46)'
						]
					]
				]
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification .notification' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default'       => [
                    'top'           => '10',
                    'right'         => '20',
                    'bottom'        => '10',
                    'left'          => '20',
                ],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'position_x',
			[
				'label' => __( 'Position X', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'position_l_y',
			[
				'label' => __( 'Position Y', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'condition' 	=> [
                    'alignment' => 'left'
                ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification.left' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 

		/**
		 * close button area
		 */
		$this->start_controls_section(
			'close_btn_area',
			[
				'label' => __( 'Close Button', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_colse_btn' => 'yes'
				]
			]
		);

		$this->add_control(
			'close_btn_icon_color',
			[
				'label' 	=> __( 'Icon Color', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::COLOR,
				'scheme' 	=> [
					'type' 	=> Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'default' 	=> '#000',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-sales-close-notification i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'close_btn_icon_size',
			[
				'label' => __( 'Icon Size', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' 	=> 0,
						'max' 	=> 500,
						'step' 	=> 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-close-notification i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 	=> 'close_btn_background',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' => '.wl {{WRAPPER}} .wl-sales-close-notification',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 	=> 'close_btn_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'selector' => '.wl {{WRAPPER}} .wl-sales-close-notification',
			]
		);

		$this->add_responsive_control(
			'close_btn_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-close-notification' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->add_responsive_control(
			'close_btn_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-close-notification' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'close_btn_position_x',
			[
				'label' => __( 'Position X', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' 	=> -500,
						'max' 	=> 500,
						'step' 	=> 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -6,
				],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-close-notification' => 'top: {{SIZE}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'close_btn_position_y',
			[
				'label' => __( 'Position Y', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' 	=> -500,
						'max' 	=> 500,
						'step' 	=> 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-close-notification' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 

		/**
		 * Notification area		 
		 */
		$this->start_controls_section(
			'image_style',
			[
				'label' => __( 'Image', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
            'image_width',
            [
                'label' 	=> __( 'Image Width', 'woolementor-pro' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sales-notification .notification .image' => 'width: {{SIZE}}{{UNIT}}',
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
                    'size' => 60,
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
                    '.wl {{WRAPPER}} .wl-sales-notification .notification .image' => 'height: {{SIZE}}{{UNIT}}',
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
                    'size' => 60,
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'img_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-sales-notification .notification .image',
			]
		);

		$this->add_responsive_control(
			'img_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification .notification .image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'img_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .wl-sales-notification .notification .image',
			]
		);

		$this->add_responsive_control(
			'img_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification .notification .image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'img_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification .notification .image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->end_controls_section(); 

		/**
		 * Notification content area		 
		 */
		$this->start_controls_section(
			'content_style',
			[
				'label' => __( 'Content', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> '_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-sales-notification .notification .item_details',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 300 ],
				],
			]
		);

		// $this->add_group_control(
  //           Group_Control_Gradient_Text::get_type(),
  //           [
  //               'name' => 'content_color',
  //               'selector' => '.wl {{WRAPPER}} .wl-sales-notification .notification .item_details, 
  //               			   .wl {{WRAPPER}} .wl-sales-notification .notification .item_details p.wl-sn-time',
		// 		'fields_options' => [
		// 			'color' => [ 'default' => '#002131' ], 
		// 		],
  //           ]
  //       );

        $this->add_control(
        	'content_color',
        	[
        		'label'     => __( 'Message Color', 'woolementor-pro' ),
        		'type'      => Controls_Manager::COLOR,
        		'selectors' => [
        			'.wl {{WRAPPER}} .wl-sales-notification .notification .item_details' => 'color: {{VALUE}}',
        		],
        		'default'  	=> '#000'
        	]
        );

        $this->add_control(
        	'time_content_color',
        	[
        		'label'     => __( 'Time Text Color', 'woolementor-pro' ),
        		'type'      => Controls_Manager::COLOR,
        		'selectors' => [
        			'.wl {{WRAPPER}} .wl-sales-notification .notification .item_details p.wl-sn-time' => 'color: {{VALUE}}',
        		],
        		'default'  	=> '#000'
        	]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'selector' => '.wl {{WRAPPER}} .wl-sales-notification .notification .item_details',
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification .notification .item_details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification .notification .item_details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification .notification .item_details' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->end_controls_section(); 

		/**
		 * Rating area
		 */
		$this->start_controls_section(
			'rating_style',
			[
				'label' => __( 'Rating', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
        	'rating_color',
        	[
        		'label' 	=> __( 'Icon Color', 'woolementor-pro' ),
        		'type' 		=> Controls_Manager::COLOR,
        		'scheme' 	=> [
        			'type' 	=> Color::get_type(),
        			'value' => Color::COLOR_1,
        		],
        		'default' 	=> '#FFA600',
        		'selectors' => [
        			'.wl {{WRAPPER}} .wl-sales-notification .notification .wl-sn-rating' => 'color: {{VALUE}}',
        		],
        	]
        );

        $this->add_responsive_control(
            'rating_size',
            [
                'label' 	=> __( 'Icon Size', 'woolementor-pro' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
					'.wl {{WRAPPER}} .wl-sales-notification .notification .wl-sn-rating .dashicons' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'px'    => [
                        'min'   => 1,
                        'max'   => 100
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
            ]
        );

		$this->add_responsive_control(
			'rating_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification .notification .wl-sn-rating' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'rating_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sales-notification .notification .wl-sn-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);
		$this->end_controls_section(); 
	}

	public function time_elapsed_string($datetime, $full = false) {
	    $now = new \DateTime;
	    $ago = new \DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) : 'few seconds';
	}

	public function wcd_get_orders( $limit, $status ){
		if( !function_exists( 'WC' ) ) return false;

		$query = new \WC_Order_Query( array(
		    'limit' 	=> $limit,
		    'order' 	=> 'DESC',
		    'status' 	=> $status,
		    'return' 	=> 'ids',
		) );

		$orders = $query->get_orders();

		if ( count( $orders ) > 0 ) {
			return $orders;
		}

		return false;
	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();
        extract( $settings );

        if ( isset( $_COOKIE['wl_hide_notification'] ) && wcd_is_live_mode() ) {
        	return;
        }

        if ( $settings['notification_from'] == 'from_api' ) {
        	$api_response 	= wp_remote_get( $api_url['url'] );
        	$api_data 		= wp_remote_retrieve_body( $api_response );
        	$notifications 	= json_decode( $api_data, ARRAY_A );
        }

        else if( $settings['notification_from'] == 'this_site' && ( $settings['notification_type'] == 'real_data' || $settings['notification_type'] == 'both_data' ) ) {

        	$_notifications = [];
        	$product_ids = $product_ids ? explode( ',', $product_ids) : [];
        	$order_ids = $this->wcd_get_orders( $orders_limit, $orders_statuses );

        	if( !empty( $order_ids ) ) {
	        	foreach ( $order_ids as $key => $order_id ) {
	        		$order = wc_get_order( $order_id );
	        		$time_diff 	  	 = $this->time_elapsed_string( $order->get_date_created() );
	        		$billing_name 	 = $order->get_billing_first_name() .' '.$order->get_billing_last_name();
	        		$billing_address = $order->get_billing_city() .', '.$order->get_billing_state().', '.$order->get_billing_country();

	        		$_items = $order->get_items();
	        		$items = [];

	        		if ( !empty( $product_ids ) ) {
	        			foreach ( $_items as $item_id => $item ) {
	        				if ( in_array( $item->get_product_id(), $product_ids) ) {
	        					$items[] = $item;
	        				}
	        			}
	        		}else{
	        			$items = $_items;
	        		}

	        		foreach ( $items as $item_id => $item ) {
	        		   	$product_id 	= $item->get_product_id();
	        		   	$product 		= $item->get_product();
	        		   	$product_image 	= get_the_post_thumbnail_url( $product_id );
	        		   	$item_name 		= $item->get_name();
    		   			$product_url 	= get_the_permalink( $item->get_product_id() );

	        		   	$_notifications[] = [
	        		   		'customer_name' 		=> $billing_name,
	        		   		'customer_address' 		=> $billing_address,
	        		   		'product_name' 	=> $item_name,
	        		   		'product_url' 	=> $product_url,
	        		   		'product_image' => [ 'url' => $product_image ],
	        		   		'sold_at' 			=> $time_diff
	        		   	];
	        		}
	        	}
	        }
	        elseif( wcd_is_edit_mode() && empty( $order_ids ) ) {
				_e( 'No order found!', 'woolementor-pro' );
			}

			if( $settings['notification_type'] == 'real_data' ) $notifications = $_notifications;
			if( $settings['notification_type'] == 'both_data' ) $notifications = array_merge( $notifications, $_notifications );
		}

		if( wcd_is_edit_mode() ){
			echo wcd_notice( __( 'The actual sales notification shows at the bottom left/right of this page!', 'woolementor-pro' ) );
		}
		
		if( empty( $notifications ) ) return;
        ?>

        <div class="wl-sales-notification <?php echo esc_attr( $alignment );?>">

        	<?php do_action( 'wcd_product_sales_notofication_start' ); ?>

        	<div class="notifications-wrapper">
        		<?php if ( $settings['enable_colse_btn'] == 'yes' ){
        			$closing_type = $settings['closing_type'] == 'yes' ? 'permanent' : 'temporary';
        			$section_id ='';
        			echo "<div class='wl-sales-close-notification' data-type='". esc_attr( $closing_type ) ."'>". esc_html( $section_id ) ."<i class='eicon-close'></i></div>";
        		}
        			?>
        		<div class="notifications">
        			<?php 
        			foreach ( $notifications as $key => $notification ) :

        				if ( wcd_is_edit_mode() &&  $key == 1 ) break;

    					if ( $enable_url == 'yes' ) {
    						echo "<a href='" . $notification['product_url'] . "'>";
    					}

    					$rating = isset( $notification['product_rating'] ) && $notification['product_rating'] != '' ? $notification['product_rating'] : 0;

    					$rating_html = '';
    					if ( $rating != 0 ) {
    						$rating_html = wcd_rating_html( $rating );
    					}
        				?>
        					<div class="notification notific-<?php esc_attr_e( $key ); ?>">
	        					<div class="notific-inner">
		        					<div class="image">
		        						<img src='<?php echo esc_url( $notification["product_image"]["url"] ); ?>' />
		        					</div>
		        					<div class="item_details">
		        						<p><strong><?php echo esc_html( $notification['customer_name'] ); ?></strong> <?php _e( 'from', 'woolementor-pro' ); ?> 
		        							<strong><?php echo esc_html( $notification['customer_address'] ); ?></strong></p>
		        						<p><?php _e( 'Purchased ', 'woolementor-pro' ); ?> <strong><?php esc_html_e( $notification['product_name'] ); ?></strong></p>
		        						<p class="wl-sn-rating"><?php echo wp_kses_post( $rating_html ); ?></p>
		        						<p class="wl-sn-time"><?php esc_html_e( $notification['sold_at'] ); ?> <?php _e( 'ago', 'woolementor-pro' ); ?></p>
		        					</div>
		        				</div>
	        				</div>
        				<?php 
    					if ( $enable_url == 'yes' ) {
    						echo "</a>";
    					}
        			endforeach; ?>
        		</div>
        	</div>

        	<?php
			/**
			 * Load Script
			 */
			$this->render_script( $notifications );

			do_action( 'wcd_product_sales_notofication_end' ); ?>

        </div>

        <?php   	
	}

	protected function render_script( $all_notifications ) {
		$settings = $this->get_settings_for_display();

	    if ( wcd_is_edit_mode() ) {
	    	?>
	    	<script type="text/javascript">
	    		jQuery(function($){
	    			$('.wl-sales-close-notification').show()
	    			$(".wl-sales-notification").show();
	    			$(".notific-0").show();
	    		})
	    	</script>
	    	<?php
	    	return;
	    }
		?>
		<script type="text/javascript">
    		jQuery(function($){
    			var duration = <?php echo $settings['notification_duration']['size']; ?>;
    			var delay = <?php echo $settings['notification_delay']['size']; ?>;


    			$(document).on('click','.wl-sales-close-notification',function(e){
    				e.preventDefault();

    				var type = $(this).data('type');
    				if ( type == 'temporary' ) {
    					$(this).parent().hide();
    				}
    				else{
    					$(this).parent().hide();
    					document.cookie = "wl_hide_notification=yes; expires=<?php echo date( "D, d M Y G:i:s T", time() + MONTH_IN_SECONDS ); ?>; path=<?php echo COOKIEPATH ?>"; 
    				}
    			});

    			InitialFlip();
    			function InitialFlip() {
    			    setTimeout(SecondFlip, duration);
    			}
    			function SecondFlip() {
    				$('.wl-sales-close-notification').show()
    				let total = <?php echo count($all_notifications); ?>;
    				let rand = Math.floor(Math.random() * total);
    			    $(".notification").hide();
    			    $(".wl-sales-notification").hide();
    			    setTimeout(function() {
    			        $(".wl-sales-notification").toggle();
    			        $(".notific-"+rand).toggle();
    			        InitialFlip();
    			    }, delay);
    			}
    		});
    	</script>
		<?php
	}
}

