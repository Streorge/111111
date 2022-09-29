<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class My_Account_Advanced extends Widget_Base {

	public $id;
	protected $form_close='';

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';
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

		$this->start_controls_section(
			'tab_manager',
			[
				'label' => __( 'Tab Manager', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$_tabs = [];
		if ( function_exists( 'wc_get_account_menu_items' ) ) {
			$_tabs = wc_get_account_menu_items();
		}

		$default_tabs = [];

		foreach ( $_tabs as $slug => $label ) {
			$default_tabs[] = [
				'tab_label' => $label,
				'tab_slug' 	=> $slug,
			];
		}

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_label', [
				'label' => __( 'Tab Title', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Tab #1' , 'woolementor-pro' ),
			]
		);

		$repeater->add_control(
			'tab_slug', [
				'label' => __( 'Tab Slug', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::TEXT,
				'description' 	=> __( 'Use a unique slug. Only alphanumeric and hyphens are allowed', 'woolementor-pro' ),
				'default' => 'custom-tab',
			]
		);

		$repeater->add_control(
			'content_type', [
				'label' => __( 'Content Type', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::SELECT,
				'options' => [
					'plain_text' 	=> __( 'Plain Text', 'woolementor-pro' ),
					'template' 		=> __( 'Template', 'woolementor-pro' ),
				],
				'default' => 'plain_text',
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name' => 'tab_slug',
		                    'operator' => '!in',
		                    'value' => array_keys( $_tabs )
						]
					]
				]
			]
		);

		$repeater->add_control(
			'tab_content', [
				'label' => __( 'Tab Content', 'woolementor-pro' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.' , 'woolementor-pro' ),
				'conditions' => [
					'terms' => [
						[
							'name' => 'tab_slug',
		                    'operator' => '!in',
		                    'value' => array_keys( $_tabs )
						],
						[
							'name' => 'content_type',
		                    'operator' => '==',
		                    'value' => 'plain_text'
						]
					]
				]
			]
		);

		$repeater->add_control(
			'tab_template',
			[
				'label' 		=> __( 'Select a Template', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> wcd_get_template_list( 'section' ),
                'description'	=> __( 'This is a list of section type template. Select a template to show as tab content', 'woolementor' ),
				'label_block' 	=> true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'tab_slug',
		                    'operator' => '!in',
		                    'value' => array_keys( $_tabs )
						],
						[
							'name' => 'content_type',
		                    'operator' => '==',
		                    'value' => 'template'
						]
					]
				]
			]
		);

		$this->add_control(
			'tabs_list',
			[
				'label' => __( 'My Account Tabs', 'woolementor-pro' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $default_tabs,
				'title_field' => '{{{ tab_label }}}',
			]
		);

		$this->end_controls_section();

		// My account profile card contents
		$this->start_controls_section(
			'profile_content',
			[
				'label' => __( 'Profile Content', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_img',
			[
				'label' 		=> __( 'Show Image', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'show_name',
			[
				'label' 		=> __( 'Show Name', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
				'separator'		=> 'before',
			]
		);

		$this->add_control(
			'user_data',
			[
				'label' => __( 'Display User\'s ', 'woolementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'display_name',
				'options' => [
					'display_name'  => __( 'Display Name', 'woolementor' ),
					'user_nicename' => __( 'Nice Name', 'woolementor' ),
					'user_login' 	=> __( 'Username', 'woolementor' ),
					'user_email' 	=> __( 'Email', 'woolementor' ),
				],
				'condition' => [
					'show_name' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		// Card styling
		$this->start_controls_section(
			'card_style',
			[
				'label' => __( 'Profile Card', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_name' => 'yes',
					'show_img' => 'yes',
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'woolementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'flex;',
				'options' => [
					'flex;'  		=> __( 'Flex', 'woolementor' ),
					'flex;flex-direction: row-reverse'  => __( 'Reverse Flex', 'woolementor' ),
					'' => __( 'Normal', 'woolementor' )
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'display:{{VALUE}}'
				]
			]
		);

		$this->add_control(
			'content_position',
			[
				'label' => __( 'Position', 'woolementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Top', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-middle',
					],
					'end' => [
						'title' => __( 'Bottom', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
				'condition' => [
					'layout!' => '',
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'align-items:{{VALUE}}'
				]
			]
		);

		$this->add_control(
			'gap',
			[
				'label' => __( 'Content Gap', 'woolementor' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout!' => '',
				],
			]
		);

		$this->add_control(
			'Card_width',
			[
				'label' => __( 'Width', 'woolementor' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'card_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wcd-customer-box',
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_border',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .wcd-customer-box',
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'before',
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// $this->end_controls_section();


		// //image styling
		// $this->start_controls_section(
		// 	'img_style',
		// 	[
		// 		'label' => __( 'Profile Image', 'woolementor' ),
		// 		'tab' 	=> Controls_Manager::TAB_STYLE,
		// 		'condition' => [
		// 			'show_img' => 'yes',
		// 		],
		// 	]
		// );

		$this->add_control(
			'image_design_heading',
			[
				'label' => __( 'Profile Image', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'img_default_style',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img img' => 'height: 100%; width:100%;',
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'overflow:hidden;',
				],
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'img_width',
			[
				'label' => __( 'Width', 'woolementor' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 70,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'img_height',
			[
				'label' => __( 'Height', 'woolementor' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 70,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'img_margin',
			[
				'label' => __( 'Margin', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'img_padding',
			[
				'label' => __( 'Padding', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'img_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img',
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'img_border',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img',
			]
		);

		$this->add_control(
			'img_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' 	=> [
					'unit' 	=> '%',
					'top' 	=> 50,
					'right' => 50,
					'bottom'=> 50,
					'left' 	=> 50,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Tab items design
		$this->start_controls_section(
			'tab_items_full_section',
			[
				'label' => __( 'Tab Section', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'woolementor-pro' ),
				'type' 	=> Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce::before,
					 .wl {{WRAPPER}} .wl-my-account-advanced .woocommerce::after' => 'display:none;',  
					'.wl {{WRAPPER}} .wl-my-account-advanced ul' => 'list-style: none;margin:0;padding:0',
					'.wl {{WRAPPER}} .wl-myaca-right .woocommerce' => 'display:flex;flex-direction:row-reverse;',
					'.wl {{WRAPPER}} .wl-myaca-left .woocommerce' => 'display:flex;',  
					'.wl {{WRAPPER}} .wl-myaca-left .woocommerce .woocommerce-MyAccount-navigation,
					 .wl {{WRAPPER}} .wl-myaca-right .woocommerce .woocommerce-MyAccount-navigation' => 'width: 20%;', 
					'.wl {{WRAPPER}} .wl-myaca-right .woocommerce .woocommerce-MyAccount-content,
					 .wl {{WRAPPER}} .wl-myaca-left .woocommerce .woocommerce-MyAccount-content' => 'width: 80%;',
					'.wl {{WRAPPER}} .wl-myaca-top .woocommerce .woocommerce-MyAccount-navigation' => 'width: 100%;',  
					'.wl {{WRAPPER}} .wl-myaca-top .woocommerce .woocommerce-MyAccount-content' => 'width: 100%;',  
					'.wl {{WRAPPER}} .wl-myaca-top .woocommerce .woocommerce-MyAccount-navigation ul' => 'display: flex;flex-wrap: wrap;',  
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li a' => 'display:block;',  
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation' => 'background: #F6F7F6',  
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li:hover,
					 .wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li.is-active' => 'background: #40A0FF',  
				]
			]
		);

		$this->add_control(
			'tab_position',
			[
				'label' => __( 'Tab Position', 'woolementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'woolementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'woolementor-pro' ),
						'icon' => 'eicon-v-align-top',
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
			'gap_between_tab_and_content',
			[
				'label' => __( 'Gap Between', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tab_position!' => 'top',
				]
			]
		);

		$this->add_control(
			'item_container_width',
			[
				'label' => __( 'Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_container_background',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => 'after',
				'selector' => '.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_container_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
				'selector' => '.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation',
			]
		);

		$this->add_control(
			'item_container_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'area_margin',
			[
				'label' => __( 'Margin', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'unit' => 'px',
					'top'  => 15,
					'left'  => 0,
					'bottom'  => 0,
					'right'  => 0,
				]
			]
		);

		$this->add_control(
			'area_padding',
			[
				'label' => __( 'Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Tab items design
		$this->start_controls_section(
			'tab_items_section',
			[
				'label' => __( 'Tab Items', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Typography::get_type(),
			[
				'name' 		=> 'item_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'separator' => 'before',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
		            'font_family' 	=> [ 'default' => 'Nonito' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
				'selector' 	=> '.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li a',
			]
		);

		$this->add_control(
			'item_padding',
			[
				'label' => __( 'Item Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'unit' => 'px',
					'top'  => 10,
					'left'  => 20,
					'bottom'  => 10,
					'right'  => 20,
				]
			]
		);

		$this->add_control(
			'item_margin',
			[
				'label' => __( 'Item Margin', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'item_colors_controls_section' );

		$this->start_controls_tab( 'item_colors_controls', [ 'label' => __( 'Normal', 'woolementor-pro' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_background',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li',
			]
		);

		$this->add_control(
			'myaca_item_text_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'myaca_item_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'selector' => '.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li',
			]
		);

		$this->add_control(
			'myaca_item_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab( 'item_colors_controls_hover', [ 'label' => __( 'Hover & Active', 'woolementor-pro' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_background_hover',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li:hover,
								.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li.is-active',
			]
		);

		$this->add_control(
			'item_text_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li:hover a' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li.is-active a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'selector' => '.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li:hover',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-navigation ul li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Tab content design
		$this->start_controls_section(
			'tab_content_section',
			[
				'label' => __( 'Tab Content', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tab_content_width',
			[
				'label' => __( 'Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-content' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Typography::get_type(),
			[
				'name' 		=> 'item_content_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'separator' => 'before',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
		            'font_family' 	=> [ 'default' => 'Nonito' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
				'selector' 	=> '.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-content',
			]
		);

		$this->add_control(
			'_item_content_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-content' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-content a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tab_content_background',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => 'after',
				'selector' => '.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-content',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tab_content_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
				'selector' => '.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-content',
			]
		);

		$this->add_control(
			'tab_content_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_content_margin',
			[
				'label' => __( 'Margin', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'unit' => 'px',
					'top'  => 15,
					'left'  => 0,
					'bottom'  => 0,
					'right'  => 0,
				]
			]
		);

		$this->add_control(
			'tab_content_padding',
			[
				'label' => __( 'Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-advanced .woocommerce .woocommerce-MyAccount-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'unit' => 'px',
					'top'  => 0,
					'left'  => 10,
					'bottom'  => 0,
					'right'  => 0,
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render() {		
		$settings = $this->get_settings_for_display();
		extract( $settings );

		$tab_list = $settings['tabs_list'];

		if( empty( $tab_list ) ) return;

		$tab_items = [];
		$default_tabs = wc_get_account_menu_items();

		foreach ( $tab_list as $tab ) {
			$tab_items[ sanitize_title( $tab['tab_slug'] ) ] = $tab['tab_label'];
		}

		add_filter( 'woocommerce_account_menu_items', function ( $items ) use ( $tab_items ){
			if( empty( $tab_items ) ) return $items;
			$items = [];
			foreach ( $tab_items as $slug => $label ) {
				$items[ $slug ] = $label;
			}

		    return $items;
		}, 999 );

		add_filter( 'query_vars', function ( $items ) use ( $tab_items ){
			if( empty( $tab_items ) ) return $items;
			$items = [];
			foreach ( $tab_items as $slug => $label ) {
				if ( !isset( $items[ $slug ] ) ) {
					$vars[] = $slug;
				}
			}

		    return $items;
		}, 999 );

		update_option( '_wcd_my_account_tabs', $tab_items );
		
		foreach ( $tab_list as $tab ) {
			$slug = sanitize_title( $tab['tab_slug'] );
			if ( !in_array( $slug, $default_tabs ) ) {
				add_action( "woocommerce_account_{$slug}_endpoint", function () use ( $tab ) {
					if ( $tab['content_type'] == 'plain_text' ) {
						echo wp_filter_post_kses( $tab['tab_content'] );
					}
					else if ( $tab['content_type'] == 'template' ){
						$template_id = sanitize_number( $tab['tab_template'] );
						$elementor_instance = \Elementor\Plugin::instance();
						echo $elementor_instance->frontend->get_builder_content_for_display( $template_id );
					}
				});
			}
		}
		?>

		<div class="wl-my-account-advanced wl-myaca-<?php echo $settings['tab_position']; ?>">
			<?php 
			$user_id 	= get_current_user_id();
			if ( $user_id ) {
				$image_html = $name_html = '';

				if ( $settings['show_img'] == 'yes' ){
					$avatar_url = get_avatar_url( $user_id );
					$image_html = "<div class='wcd-ab-img'><img src='". esc_url( $avatar_url ) ."'></div>";
				}

				if ( $settings['show_name'] == 'yes' ){
					$user 		= get_user_by( 'ID', $user_id )->data;
					$data_type 	= $settings['user_data'];
					$data 		= $user->$data_type;
					$name_html 	= "<div class='wcd-ab-name'>". esc_html( $data ) ."</div>";
				}

				echo "<div class='wcd-customer-box'>". wp_kses_post( $image_html.$name_html )."</div>";
			}
			echo do_shortcode( '[woocommerce_my_account]' ); ?>
		</div>

		<?php
	}
}

