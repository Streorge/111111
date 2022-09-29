<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Menu_Cart extends Widget_Base {

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

		$this->start_controls_section(
			'section_menu_icon_content',
			[
				'label' => __( 'Menu Icon', 'woolementor-pro' ),
			]
		);

        $this->add_control(
            'icon',
            [
                'label'         => __( 'Icon', 'woolementor-pro' ),
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'eicon-cart-solid',
                    'library'   => 'solid',
                ],
            ]
        ); 

		$this->add_control(
			'indicator_switch',
			[
				'label' 		=> __( 'Indicator', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'no',
			]
		);

		$this->add_control(
			'subtotal_switch',
			[
				'label' 		=> __( 'Subtotal', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'no',
			]
		);

		$this->add_control(
			'alignment',
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
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-wrapper' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_button_action',
			[
				'label' => __( 'Action', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'wlmc_button_action',
			[
				'label' 	=> __( 'Action Type', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'options' 	=> [
					'click'  => __( 'Click', 'woolementor-pro' ),
					'hover'  => __( 'Hover', 'woolementor-pro' ),
					'slide'  => __( 'Slide', 'woolementor-pro' ),
				],
				'default' 	=> 'click',
			]
		);

		$this->add_control(
			'min_cart_animation_speed',
			[
				'label' 	=> __( 'Animation Speed', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::NUMBER,
				'default' 	=> 0.5,
				'condition' => [
					'wlmc_button_action' => 'slide'
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-overlay' => 'transition:{{VALUE}}s;',
					'.wl {{WRAPPER}} .wlmc-modal-overlay.show' => 'transition:{{VALUE}}s;',
					'.wl {{WRAPPER}} .wlmc-modal-wrapper' => 'transition:{{VALUE}}s;',
					'.wl {{WRAPPER}} .wlmc-modal-wrapper.click' => 'transition:{{VALUE}}s;',
				],
			]
		);

		$this->add_control(
			'min_cart_title',
			[
				'label' 	=> __( 'Title', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXT,
				'default' 	=> __( 'Cart', 'woolementor-pro' ),
				'condition' => [
					'wlmc_button_action' => 'slide'
				],
			]
		);

		$this->add_control(
			'sliding_from',
			[
				'label' => __( 'Slide From', 'woolementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'woolementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					// 'top' => [
					// 	'title' => __( 'Top', 'woolementor-pro' ),
					// 	'icon' => 'eicon-v-align-top',
					// ],
					'right' => [
						'title' => __( 'Right', 'woolementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' 	=> 'right',
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-wrapper' => '{{VALUE}}: -100%;',
					'.wl {{WRAPPER}} .wlmc-modal-wrapper.click' => '{{VALUE}}: 0;',
				],
				'condition' => [
					'wlmc_button_action' => 'slide'
				]
			]
		);


		$this->add_control(
			'show_cart',
			[
				'label'         => __( 'Active Mode', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Yes', 'woolementor' ),
				'label_off'     => __( 'No', 'woolementor' ),
				'return_value'  => 'yes',
				'separator'  	=> 'after',
				'default'       => '',
				'description'   => __( '"Active Mode" is only for design purpose. This has no efect on live/preview mode.', 'woolementor-pro' ),
				'condition' => [
					'wlmc_button_action' => 'slide'
				]
			]
		);

		$this->end_controls_section();

		// menu icon
		$this->start_controls_section(
			'section_toggle_style',
			[
				'label' => __( 'Menu Icon', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'toggle_button_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-total',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->start_controls_tabs( 'toggle_button_colors' );

		$this->start_controls_tab( 'toggle_button_normal_colors', [ 'label' => __( 'Normal', 'elementor-pro' ) ] );

		$this->add_control(
			'toggle_button_text_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-total' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_icon_color',
			[
				'label' => __( 'Icon Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-button-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_background_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-toggle-button-panel' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'indicator_color',
			[
				'label' => __( 'Indicator Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-count-number' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'indicator_background',
			[
				'label' => __( 'Indicator Background', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-count-number' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'toggle_button_border_color',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wlmc-toggle-button-panel',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'toggle_button_hover_colors', [ 'label' => __( 'Hover', 'elementor-pro' ) ] );

		$this->add_control(
			'toggle_button_text_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-total:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_icon_color_hover',
			[
				'label' => __( 'Icon Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-button-icon:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_background_color_hover',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-toggle-button-panel:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'indicator_color_hover',
			[
				'label' => __( 'Indicator Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-count-number:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'indicator_background_hover',
			[
				'label' => __( 'Indicator Background', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-count-number:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'toggle_button_border_color_hover',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wlmc-toggle-button-panel:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'toggle_button_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wlmc-toggle-button-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'toggle_button_card_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wlmc-toggle-button-panel',
				'separator' => 'before',
            ]
        );

		$this->add_responsive_control(
			'toggle_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-toggle-button-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'toggle_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-toggle-button-panel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_icon_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Icon', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'toggle_icon_size',
			[
				'label' => __( 'Size', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-button-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'toggle_icon_spacing',
			[
				'label' => __( 'Spacing', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size-units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-total' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
            'toggle_indicator_offset',
            [
                'label' 		=> __( 'Indicator Offset', 'woolementor' ),
                'type' 			=> Controls_Manager::POPOVER_TOGGLE,
                'label_off' 	=> __( 'None', 'woolementor' ),
                'label_on' 		=> __( 'Custom', 'woolementor' ),
                'return_value' 	=> 'yes',
				'separator' 	=> 'before',
                'condition' 	=> [
                    'indicator_switch' => ''
                ],
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'toggle_indicator_offset_x',
            [
                'label' 		=> __( 'Offset Left', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'toggle_indicator_offset' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -100,
                        'max' 	=> 100,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wlmc-count-number' => 'left: {{SIZE}}{{UNIT}}'
                ],
                'render_type' 	=> 'ui',
            ]
        );

        $this->add_responsive_control(
            'toggle_indicator_offset_y',
            [
                'label' 		=> __( 'Offset Top', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'toggle_indicator_offset' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -100,
                        'max' 	=> 100,
                    ],
                ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wlmc-count-number' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();

		$this->end_controls_section();

		// card styling
		$this->start_controls_section(
			'wl_menucart_overlay_style',
			[
				'label' => __( 'Overlay', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'wlmc_button_action' => 'slide'
				]
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name'      => 'wl_menucart_overlay_background',
		        'label'     => __( 'Background', 'woolementor-pro' ),
		        'types'     => [ 'classic', 'gradient' ],
		        'selector'  => '.wl {{WRAPPER}} .wlmc-modal-overlay',
		    ]
		);

		$this->end_controls_section();

		// card styling
		$this->start_controls_section(
			'wl_menucart_card_style_area',
			[
				'label' => __( 'Card', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'wl_menucart_card_width',
			[
				'label' => __( 'Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 800,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-wrapper' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'section_product_card_background',
                'label'     => __( 'Background', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl {{WRAPPER}} .wlmc-modal-wrapper',
            ]
        );

		$this->add_responsive_control(
			'wl_menucart_card_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-modal-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_menucart_card_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-modal-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 			=> 'wl_menucart_card_border',
				'selector' 		=> '.wl {{WRAPPER}} .wlmc-modal-wrapper',
				'separator'		=> 'before'
			]
		);

		$this->add_control(
			'wl_menucart_card_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wlmc-modal-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'wl_menucart_card_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wlmc-modal-wrapper',
            ]
        );

		$this->end_controls_section();


		// card title styling
		$this->start_controls_section(
			'wl_menucart_title_styleing',
			[
				'label' => __( 'Card Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'wlmc_button_action' => 'slide'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wl_menucart_title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-header-title',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 16 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'wl_menucart_title_alignment',
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
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-header-title' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wl_menucart_title_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-header-title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name'      => 'wl_menucart_title_background',
		        'label'     => __( 'Background', 'woolementor-pro' ),
		        'types'     => [ 'classic', 'gradient' ],
		        'selector'  => '.wl {{WRAPPER}} .wlmc-modal-header-title',
		    ]
		);

		$this->add_responsive_control(
			'wl_menucart_title_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-modal-header-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_menucart_title_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-modal-header-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//cart Close button		
		$this->start_controls_section(
			'cart_close_btn_content',
			[
				'label' => __( 'Close Button', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'wlmc_button_action' => 'slide'
				]
			]
		);

		$this->add_control(
		    'close_btn_icon',
		    [
		        'label'         => __( 'Icon', 'woolementor-pro' ),
		        'type'          => Controls_Manager::ICONS,
		        'default'       => [
		            'value'     => 'eicon-close',
		            'library'   => 'solid',
		        ],
		    ]
		);

		$this->add_control(
			'close_btn_default_style',
			[
				'label' => __( 'View', 'woolementor-pro' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-close' => 'left: 0;top:0;',
				]
			]
		);

		$this->add_control(
			'close_btn_icon_position',
			[
				'label' => __( 'Position X', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-close' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'close_btn_icon_position_y',
			[
				'label' => __( 'Position Y', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-close' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wl_menucart_close_btn_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-close',
			]
		);

		$this->add_control(
			'wl_menucart_close_btn_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-modal-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->add_control(
			'wl_menucart_close_btn_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-close' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name'      => 'wl_menucart_close_btn_background',
		        'label'     => __( 'Background', 'woolementor-pro' ),
		        'types'     => [ 'classic', 'gradient' ],
		        'selector'  => '.wl {{WRAPPER}} .wlmc-modal-close',
		    ]
		);

		$this->add_responsive_control(
			'wl_menucart_close_btn_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-modal-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_menucart_close_btn_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-modal-close' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Cart heading
		$this->start_controls_section(
			'section_product_content_header',
			[
				'label' => __( 'Heading', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wl_menucart_header_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-count-text-panel',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'wl_menucart_header_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-count-text-panel' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'wl_menucart__header_alignment',
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
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-count-text-panel' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_tabs_style',
			[
				'label' => __( 'Products', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_product_title_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Product Title', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_title_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item a' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-name.product-name a' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item a, .wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-name.product-name a',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'heading_product_price_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Product Price', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_price_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item .quantity' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-price.product-price .quantity' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-price.product-price .quantity .amount' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_price_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item .quantity, .wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-price.product-price .quantity, .wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-price.product-price .quantity .amount',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'heading_product_divider_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Divider', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label' => __( 'Style', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'woolementor-pro' ),
					'solid' => __( 'Solid', 'woolementor-pro' ),
					'double' => __( 'Double', 'woolementor-pro' ),
					'dotted' => __( 'Dotted', 'woolementor-pro' ),
					'dashed' => __( 'Dashed', 'woolementor-pro' ),
					'groove' => __( 'Groove', 'woolementor-pro' ),
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item' => 'border-bottom-style: {{VALUE}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__products .elementor-menu-cart__product.woocommerce-cart-form__cart-item' => 'border-bottom-style: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item' => 'border-color: {{VALUE}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__products .elementor-menu-cart__product.woocommerce-cart-form__cart-item' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label' => __( 'Weight', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__products .elementor-menu-cart__product.woocommerce-cart-form__cart-item' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'divider_gap',
			[
				'label' => __( 'Spacing', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item' => 'padding-bottom: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item' => 'padding-top: {{SIZE}}{{UNIT}}',

					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__products .elementor-menu-cart__product.woocommerce-cart-form__cart-item' => 'padding-bottom: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__products .elementor-menu-cart__product.woocommerce-cart-form__cart-item' => 'padding-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_product_remove_button_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Remove Button', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_product_remove_button_size',
			[
				'label' => __( 'Size', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button' => 'font-size: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-remove.product-remove a.remove_from_cart_button' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_product_remove_button_area',
			[
				'label' => __( 'Area', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-remove.product-remove a.remove_from_cart_button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_product_remove_button_line_height',
			[
				'label' => __( 'Line Height', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button' => 'line-height: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-remove.product-remove a.remove_from_cart_button' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_product_remove_button_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button::before' => 'color: {{VALUE}}',

					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-remove.product-remove' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-remove.product-remove::before' => 'background: {{VALUE}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-remove.product-remove::after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_product_remove_button_background_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button' => 'background-color: {{VALUE}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-remove.product-remove a.remove_from_cart_button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'heading_product_remove_button_border',
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button, .wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__product-remove.product-remove',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_subtotal',
			[
				'label' => __( 'Subtotal', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_style_subtotal_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__total, .wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__subtotal',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'section_style_subtotal_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__total, .wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__subtotal' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'section_style_subtotal_color_alignment',
			[
				'label' => __( 'Alignment', 'woolementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Left', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'space-between' => [
						'title' => __( 'Space Between', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'space-around' => [
						'title' => __( 'Space Around', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__total, .wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__subtotal' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_buttons',
			[
				'label' => __( 'Buttons', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'buttons_layout',
			[
				'label' => __( 'Layout', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'inline' 	=> __( 'Inline', 'woolementor-pro' ),
					'stacked' 	=> __( 'Grid', 'woolementor-pro' ),
				],
				'default' => 'inline',
				'prefix_class' => 'wlmc-menu-cart--buttons-',
			]
		);

		$this->add_control(
			'space_between_buttons',
			[
				'label' => __( 'Space Between', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons' => 'grid-column-gap: {{SIZE}}{{UNIT}}; grid-row-gap: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons' => 'grid-column-gap: {{SIZE}}{{UNIT}}; grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_buttons_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button, .wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button' => 'border-radius: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_view_cart_button_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'View Cart', 'woolementor-pro' ),
				'separator' => 'before'
			]
		);
		$this->start_controls_tabs( 'view_cart_button_tabs_style' );
		$this->start_controls_tab( 'view_cart_button_tab_style', [ 'label' => __( 'Normal', 'elementor-pro' ) ] );

		$this->add_control(
			'view_cart_button_text_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.wc-forward:first-child' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button:first-child' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view_cart_button_background_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.wc-forward:first-child' => 'background-color: {{VALUE}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button:first-child' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'view_cart_border',
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.wc-forward:first-child, .wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button:first-child',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab( 'view_cart_button_tab_hover_style', [ 'label' => __( 'Hover', 'elementor-pro' ) ] );

		$this->add_control(
			'view_cart_button_text_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.wc-forward:first-child:hover' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button:first-child:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view_cart_button_background_color_hover',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.wc-forward:first-child:hover' => 'background-color: {{VALUE}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button:first-child:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'view_cart_border_hover',
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.wc-forward:first-child:hover',
			]
		);

		$this->end_controls_tabs();

		$this->add_control(
			'heading_checkout_button_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Checkout', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'checkout_button_tabs_style' );
		$this->start_controls_tab( 'checkout_button_tab_style', [ 'label' => __( 'Normal', 'elementor-pro' ) ] );

		$this->add_control(
			'checkout_button_text_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.checkout.wc-forward' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button.elementor-button--checkout' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'checkout_button_background_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.checkout.wc-forward' => 'background-color: {{VALUE}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button.elementor-button--checkout' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'checkout_border',
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.checkout.wc-forward',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab( 'checkout_button_tab_hover_style', [ 'label' => __( 'Hover', 'elementor-pro' ) ] );

		$this->add_control(
			'checkout_button_text_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.checkout.wc-forward:hover' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button.elementor-button--checkout:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'checkout_button_background_color_hover',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.checkout.wc-forward:hover' => 'background-color: {{VALUE}};',
					'.wl {{WRAPPER}} .wlmc-modal-body .elementor-menu-cart__footer-buttons .elementor-button.elementor-button--checkout:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'checkout_border_hover',
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body .woocommerce-mini-cart__buttons .button.checkout.wc-forward:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		
        if ( ! is_woocommerce_activated() ) return;

		if( wcd_is_edit_mode() ) {
			wc()->frontend_includes();
			
			if( is_null( WC()->cart ) ) {
				include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
				include_once WC_ABSPATH . 'includes/class-wc-cart.php';
				wc_load_cart();

				$product_id = wcd_get_product_id();

				WC()->cart->add_to_cart( $product_id );
			}
		}
		$wrapper = $overlay = '';
		if ( $settings['show_cart'] == 'yes' && wcd_is_edit_mode() ) {
			$wrapper = 'click';
			$overlay = 'show';
		}

		echo "
		<div class='wl-menu-cart-button-action-" . esc_attr( $settings['wlmc_button_action'] ) . "'>
			<div class='wlmc-wrapper'>
				<div class='wlmc-cart-inner wlmc-on-hover'>";
					 $this->render_toggle_button();
					echo "
					<div class='wlmc-modal-overlay " . esc_attr( $overlay ) . " '></div>
					<div class='wlmc-modal-wrapper " . esc_attr( $wrapper ) . " '>";
						$this->render_header( $settings );
						echo "
						<div class='wlmc-modal-body'>
							<div class='widget_shopping_cart_content'>";
								woocommerce_mini_cart();
								echo "
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>";

		$this->render_script();
	}

	protected function render_header( $settings ) {

		$product_count 	= WC()->cart->get_cart_contents_count();
		?>
		<div class="wlmc-modal-header">
			<?php if( $settings['wlmc_button_action'] == 'slide' ): ?>
				<div class="wlmc-modal-close">
					<i aria-hidden="true" class="<?php echo esc_attr( $settings['close_btn_icon']['value'] ); ?>"></i>
				</div>
				<div class="wlmc-modal-header-title"><?php echo esc_html( $settings['min_cart_title'] ); ?></div>
			<?php endif; ?>
			<div class="wlmc-modal-count-text-panel">
				<span class="wlmc-modal-count-number" style="opacity: 1;"><?php echo $product_count; ?></span>
				<span class="wlmc-modal-count-text"><?php esc_html_e( 'items', 'woolementor-pro' ) ?></span>
			</div>
		</div>
		<?php
	}

	protected function render_toggle_button() {
		$settings 		= $this->get_settings_for_display();

		$product_count 	= WC()->cart->get_cart_contents_count();
		$sub_total 		= WC()->cart->get_cart_subtotal();

		?>
		<div class="wlmc-toggle-button-wrapper">
            <div class="wlmc-toggle-button-panel">
				<span class="wlmc-button-icon">
					<i aria-hidden="true" class="<?php echo esc_attr( $settings['icon']['value'] ); ?>"></i>						
				</span>
				<?php
				if ( $settings['indicator_switch'] != 'yes' ) {
					printf( '<sup class="wlmc-count-number" style="opacity: 1;">%s</sup>', esc_html( $product_count ) );
				}

				if ( $settings['subtotal_switch'] != 'yes' ) {
					printf( '<span class="wlmc-total" style="opacity: 1;">%s</span>', wp_kses_post( $sub_total ) );
				}
				?>
            </div>
		</div>
		<?php
	}

	protected function render_script() {
		?>
		<script>
			jQuery(function($) {


				$(document).on('click', '.elementor-menu-cart__product-remove.product-remove a', function (e) {
				    e.preventDefault();

				    var href = $(this).prop('href');

				    $.get( href, function( data ) {
				    	$( document.body ).trigger( 'wc_fragment_refresh' );
					});
				});


				$(document).on('click', '.wl-menu-cart-button-action-click .wlmc-toggle-button-panel', function (e) {
				    $('.wlmc-modal-wrapper').slideToggle();
				});

				$(document).on('click', '.wl-menu-cart-button-action-slide .wlmc-toggle-button-panel', function (e) {
				    $('.wlmc-modal-wrapper').addClass('click');
				    $('.wlmc-modal-overlay').addClass('show');
				});

				$(document).on('click', '.wlmc-modal-overlay, .wlmc-modal-close', function (e) {
				    $('.wlmc-modal-wrapper').removeClass('click');
				    $('.wlmc-modal-overlay').removeClass('show');
				});


				$(document).on({
				    mouseenter: function () {
				        $('.wl-menu-cart-button-action-hover .wlmc-modal-wrapper').show();
				    },
				    mouseleave: function () {
				        $('.wl-menu-cart-button-action-hover .wlmc-modal-wrapper').hide();
				    }
				}, ".wlmc-cart-inner");
			});
		</script>
		<?php
	}
}