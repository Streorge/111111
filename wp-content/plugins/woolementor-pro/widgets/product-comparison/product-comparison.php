<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Product_Comparison extends Widget_Base {

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
		return [ "woolementor-{$this->id}", 'chosen' ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", 'chosen' ];
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
			'product_comparison_section',
			[
				'label' => __( 'Content', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'product_comparison_label', [
				'label' => __( 'Label', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Feature' , 'woolementor-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_comparison_value',
			[
				'label' 		=> __( 'Data', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT2,
				'multiple' 		=> false,
				'label_block' 	=> true,
				'options' 		=> [
					'price'  			=> __( 'Price', 'woolementor-pro' ),
					'average_rating'  	=> __( 'Average Rating', 'woolementor-pro' ),
					'description'  		=> __( 'Description', 'woolementor-pro' ),
					'short_description'	=> __( 'Short Description', 'woolementor-pro' ),
					'attributes'		=> __( 'Attributes', 'woolementor-pro' ),
					'categories'		=> __( 'Categories', 'woolementor-pro' ),
					'tags'				=> __( 'Tags', 'woolementor-pro' ),
					'meta_fields'		=> __( 'Meta Fields', 'woolementor-pro' ),
				],
				'default' 		=> 'price',
			]
		);

		$_attributes 	= function_exists( 'wc_get_attribute_taxonomies' ) ? wc_get_attribute_taxonomies() : [];
		
		$attributes 	= [];
		foreach ( $_attributes as $_attribute ) {
			$attributes[ $_attribute->attribute_name ] = $_attribute->attribute_label;
		}

		$repeater->add_control(
			'product_comparison_attribute',
			[
				'label' 		=> __( 'Attribute', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT2,
				'multiple' 		=> false,
				'label_block' 	=> true,
				'options' 		=> $attributes,
                'condition' 	=> [
                    'product_comparison_value' => 'attributes'
                ],
			]
		);

		$unset_meta_fields = [ '_thumbnail_id', '_product_attributes', '_price' ];

		$repeater->add_control(
			'product_comparison_meta_fields',
			[
				'label' 		=> __( 'Meta Field', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT2,
				'multiple' 		=> false,
				'label_block' 	=> true,
				'options' 		=> wcd_get_meta_fields( $unset_meta_fields ),
                'condition' 	=> [
                    'product_comparison_value' => 'meta_fields'
                ],
			]
		);

		$this->add_control(
			'comparison_features',
			[
				'label' 	=> __( 'Features', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::REPEATER,
				'fields' 	=> $repeater->get_controls(),
				'default' 	=> [
					[
						'product_comparison_label' => __( 'Price', 'woolementor-pro' ),
						'product_comparison_value' => 'price',
					],
					[
						'product_comparison_label' => __( 'Average Rating', 'woolementor-pro' ),
						'product_comparison_value' => 'average_rating',
					],
					[
						'product_comparison_label' => __( 'Short Description', 'woolementor-pro' ),
						'product_comparison_value' => 'short_description',
					],
					[
						'product_comparison_label' => __( 'Categories', 'woolementor-pro' ),
						'product_comparison_value' => 'categories',
					],
				],
				'title_field' => '{{{ product_comparison_label }}}',
			]
		);

		$this->end_controls_section();

		/**
		 * Remove Button
		 */
		$this->start_controls_section(
			'comparison_remove_button',
			[
				'label' 		=> __( 'Remove Button', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'remove_icon',
            [
                'label'         => __( 'Icon', 'woolementor-pro' ),
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'eicon-close',
                    'library'   => 'solid',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Image controls
         */
        $this->start_controls_section(
            'section_content_product_image',
            [
                'label' => __( 'Product Image', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image_show_hide',
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
                'condition'     => [
                    'image_show_hide' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

		/**
		 * Button
		 */
		$this->start_controls_section(
			'_sectio_comparison_button',
			[
				'label' 		=> __( 'Search Section', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_button',
			[
				'label' 	=> __( 'Show Search Section', 'plugin-domain' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Show', 'woolementor' ),
				'label_off' => __( 'Hide', 'woolementor' ),
				'return_value' => 'yes',
				'default' 	=> 'yes',
			]
		);

		$this->add_control(
			'use_chosen',
			[
				'label' 	=> __( 'Enable Chosen', 'plugin-domain' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Yes', 'woolementor' ),
				'label_off' => __( 'No', 'woolementor' ),
				'return_value' => 'yes',
				'separator'	=> 'before',
				'default' 	=> '',
                'description'   => sprintf( __( 'Check this to enable <a href="%s" target="_blank">Chosen</a> jQuery library', 'woolementor-pro' ), 'https://plugins.jquery.com/chosen/' ),
                'condition'	=> [
                	'show_button' => 'yes'
                ]
			]
		);

		$this->add_control(
            'button_text',
            [
                'label' 	=> __( 'Button Text', 'woolementor' ),
                'type' 		=> Controls_Manager::TEXT,
                'default' 	=> 'Compare',
                'separator'	=> 'before',
                'condition'	=> [
                	'show_button' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /**
		 * Table
		 */
		$this->start_controls_section(
			'section_comparison_table',
			[
				'label' => __( 'Table', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'comparison_table_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-comparison-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default'       => [
                    'top'           => '10',
                    'right'         => '10',
                    'bottom'        => '10',
                    'left'          => '10',
                ],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'comparison_table_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-comparison-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'comparison_table_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .wl-product-comparison-table',
			]
		);

		$this->end_controls_section();

        /**
		 * Table Header
		 */
		$this->start_controls_section(
			'section_comparison_table_header',
			[
				'label' => __( 'Header', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'comparison_table_header_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wl-product-comparison-table tbody tr th',
			]
		);

		$this->add_control(
			'comparison_table_header_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' 	=> [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'default'   => '#484848',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-comparison-table tbody tr th' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
            'comparison_table_header_alignment',
            [
                'label' 		=> __( 'Alignment', 'woolementor' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'options' 		=> [
                    'left' 		=> [
                        'title' 	=> __( 'Left', 'woolementor' ),
                        'icon' 		=> 'eicon-text-align-left',
                    ],
                    'center' 	=> [
                        'title' 	=> __( 'Center', 'woolementor' ),
                        'icon' 		=> 'eicon-text-align-center',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'woolementor' ),
                        'icon' 		=> 'eicon-text-align-right',
                    ],
                ],
                'toggle' 		=> true,
                'default' 		=> 'center',
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-product-comparison-table tbody tr th' => 'text-align: {{VALUE}};'
                ]
            ]
        );

		$this->add_control(
			'comparison_table_header_background',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' 	=> [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'default'   => '#fff',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-comparison-table tbody tr th' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'comparison_table_header_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-comparison-table tbody tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'comparison_table_header_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wl-product-comparison-table tbody tr th',
				'fields_options'	=> [
					'border' 		=> [
						'default' 	=> 'solid',
					],
					'width' 		=> [
						'default' 	=> [
							'top' 		=> '1',
							'right' 	=> '1',
							'bottom' 	=> '1',
							'left' 		=> '1',
							'isLinked' 	=> false,
						],
					],
					'color' => [
						'default' => 'var(--wl-light-border)',
					],
				],
				'separator'		=> 'before'
			]
		);

		$this->end_controls_section();

        /**
		 * Table Body
		 */
		$this->start_controls_section(
			'section_comparison_body',
			[
				'label' => __( 'Body', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'comparison_table_body_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wl-product-comparison-table tbody tr td',
			]
		);

		$this->add_control(
			'comparison_table_body_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' 	=> [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'default'   => '#484848',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-comparison-table tbody tr td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'comparison_table_body_link_color',
			[
				'label' => __( 'Link Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-comparison-table tbody tr td a' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
            'comparison_table_body_alignment',
            [
                'label' 		=> __( 'Alignment', 'woolementor' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'options' 		=> [
                    'left' 		=> [
                        'title' 	=> __( 'Left', 'woolementor' ),
                        'icon' 		=> 'eicon-text-align-left',
                    ],
                    'center' 	=> [
                        'title' 	=> __( 'Center', 'woolementor' ),
                        'icon' 		=> 'eicon-text-align-center',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'woolementor' ),
                        'icon' 		=> 'eicon-text-align-right',
                    ],
                ],
                'toggle' 		=> true,
                'default' 		=> 'center',
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-product-comparison-table tbody tr td' => 'text-align: {{VALUE}};'
                ]
            ]
        );

		$this->add_control(
			'comparison_table_body_background',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' 	=> [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'default'   => '#fff',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-comparison-table tbody tr td' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'comparison_table_body_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-comparison-table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'comparison_table_body_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wl-product-comparison-table tbody tr td',
				'fields_options'	=> [
					'border' 		=> [
						'default' 	=> 'solid',
					],
					'width' 		=> [
						'default' 	=> [
							'top' 		=> '1',
							'right' 	=> '1',
							'bottom' 	=> '1',
							'left' 		=> '1',
							'isLinked' 	=> false,
						],
					],
					'color' => [
						'default' => 'var(--wl-light-border)',
					],
				],
				'separator'		=> 'before'
			]
		);

		$this->end_controls_section();

        /**
		 * Remove column Button
		 */
		$this->start_controls_section(
			'section_comparison_remove_button',
			[
				'label' => __( 'Remove Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
            'comparison_button_remove_size',
            [
                'label'     => __( 'Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
            ]
        );

        $this->add_control(
            'sale_ribbon_offset_toggle',
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
            'media_offset_x',
            [
                'label'         => __( 'Offset Left', 'woolementor' ),
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
                    '.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove' => 'right: {{SIZE}}{{UNIT}}'
                ],
                'render_type'   => 'ui',
            ]
        );

        $this->add_responsive_control(
            'media_offset_y',
            [
                'label'         => __( 'Offset Top', 'woolementor' ),
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
                    '.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();

		$this->add_responsive_control(
			'comparison_button_remove_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default'       => [
                    'top'           => '1',
                    'right'         => '3',
                    'bottom'        => '1',
                    'left'          => '3',
                ],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'comparison_button_remove_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'comparison_button_remove_normal_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'comparison_button_remove_normal',
			[
				'label'     => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'comparison_button_remove_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove' => 'color: {{VALUE}}',
				],
				'default'   => '#fff',
			]
		);

		$this->add_control(
			'comparison_button_remove_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove' => 'background: {{VALUE}}',
				],
				'default'   => '#f00',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'comparison_button_remove_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove',
				'fields_options'	=> [
					'border' 		=> [
						'default' 	=> 'solid',
					],
					'width' 		=> [
						'default' 	=> [
							'top' 		=> '1',
							'right' 	=> '1',
							'bottom' 	=> '1',
							'left' 		=> '1',
							'isLinked' 	=> false,
						],
					],
					'color' => [
						'default' => '#f00',
					],
				],
			]
		);

		$this->add_control(
			'comparison_button_remove_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'comparison_button_remove_hover',
			[
				'label'     => __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'comparison_button_remove_color_hover',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'comparison_button_remove_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'comparison_button_remove_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove:hover',
			]
		);

		$this->add_control(
			'comparison_button_remove_border_radius_hover',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-pct-table-header-content button.wl-pct-product-remove:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
         * Product Image controls
         */
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __( 'Product Image', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'image_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image_thumbnail',
                'exclude'   => [],
                'include'   => [],
                'default'   => 'woolementor-thumb',
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'     => __( 'Image Width', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pct-table-header-content img' => 'width: {{SIZE}}{{UNIT}}',
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
            'image_height',
            [
                'label'     => __( 'Image Height', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pct-table-header-content img' => 'height: {{SIZE}}{{UNIT}}',
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
            'image_box_height',
            [
                'label'     => __( 'Image Box Height', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pct-table-header-content' => 'height: {{SIZE}}{{UNIT}}',
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
            'image_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pct-table-header-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-pct-table-header-content img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-pct-table-header-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'image_box_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-pct-table-header-content img',
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
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label'     => __( 'Opacity', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 1,
                        'min'   => 0.10,
                        'step'  => 0.01,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pct-table-header-content img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'      => 'image_css_filters',
                'selector'  => '.wl {{WRAPPER}} .wl-pct-table-header-content img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'image_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label'     => __( 'Opacity', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 1,
                        'min'   => 0.10,
                        'step'  => 0.01,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-pct-table-header-content img:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'      => 'image_css_filters_hover',
                'selector'  => '.wl {{WRAPPER}} .wl-pct-table-header-content img:hover',
            ]
        );

        $this->add_control(
            'image_hover_transition',
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
                    '.wl {{WRAPPER}} .wl-pct-table-header-content img:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
		 * Table Select Box
		 */
		$this->start_controls_section(
			'section_comparison_select_box',
			[
				'label' => __( 'Select Box', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'comparison_select_box_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wl-product-comparison-wrapper .wl-comparison-products',
			]
		);

        $this->add_responsive_control(
            'comparison_select_box_width',
            [
                'label'     => __( 'Width', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-product-comparison-wrapper .wl-comparison-products' => 'width: {{SIZE}}{{UNIT}}',
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
			'comparison_select_box_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-comparison-wrapper .wl-comparison-products' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'comparison_select_box_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wl-product-comparison-wrapper .wl-comparison-products',
				'fields_options'	=> [
					'border' 		=> [
						'default' 	=> 'solid',
					],
					'width' 		=> [
						'default' 	=> [
							'top' 		=> '1',
							'right' 	=> '1',
							'bottom' 	=> '1',
							'left' 		=> '1',
							'isLinked' 	=> false,
						],
					],
					'color' => [
						'default' => 'var(--wl-light-border)',
					],
				],
				'separator'		=> 'before'
			]
		);

		$this->add_control(
			'comparison_select_box_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-product-comparison-wrapper .wl-comparison-products' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

        /**
		 * Table Button
		 */
		$this->start_controls_section(
			'section_comparison_button',
			[
				'label' => __( 'Search Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'comparison_button_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wl-comparison-product-add-button',
			]
		);

		$this->add_responsive_control(
			'comparison_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-comparison-product-add-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'comparison_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-comparison-product-add-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'comparison_button_normal_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'comparison_button_normal',
			[
				'label'     => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'comparison_button_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-comparison-product-add-button' => 'color: {{VALUE}}',
				],
				'default'   => '#fff',
			]
		);

		$this->add_control(
			'comparison_button_bg',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-comparison-product-add-button' => 'background: {{VALUE}}',
				],
				'default'   => '#61ce70',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'comparison_button_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-comparison-product-add-button',
				'fields_options'	=> [
					'border' 		=> [
						'default' 	=> 'solid',
					],
					'width' 		=> [
						'default' 	=> [
							'top' 		=> '1',
							'right' 	=> '1',
							'bottom' 	=> '1',
							'left' 		=> '1',
							'isLinked' 	=> false,
						],
					],
					'color' => [
						'default' => '#61ce70',
					],
				],
			]
		);

		$this->add_control(
			'comparison_button_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-comparison-product-add-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'comparison_button_hover',
			[
				'label'     => __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'comparison_button_color_hover',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-comparison-product-add-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'comparison_button_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-comparison-product-add-button:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'comparison_button_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '.wl {{WRAPPER}} .wl-comparison-product-add-button:hover',
			]
		);

		$this->add_control(
			'comparison_button_border_radius_hover',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-comparison-product-add-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'button_text', 'class', 'wl-product-comparison-table' );

        $products 			= isset( $_GET['products'] ) ? $_GET['products'] : [];
		$comparison_page_id = Helper::get_option( 'woolementor_tools', 'comparison_page' );
		$compare_key 		= wcd_compare_cookie_key();

		if ( isset( $_COOKIE[ $compare_key ] ) ) {
		    $_products 	= $_COOKIE[ $compare_key ];
		    $_products  = $_products ? unserialize( $_products ) : [];
		    $products 	= array_merge( $products, $_products );
		}
		?>

        <div class="wl-product-comparison-wrapper">
        	<div class="wl-product-comparison-content">
		       	<?php 
		       		if ( ! is_woocommerce_activated()  ) return;
		       		if ( empty( $products ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ){
		       			$products[] = wcd_get_product_id();
		       			$products[] = wcd_get_product_id();
		       		}

					$products = array_unique( $products );
		       		$hidden_products = '';
					if ( !empty( $products ) ) {
						foreach ( $products as $product_id ) {
							$hidden_products .= "<input type='hidden' name='products[]' value='{$product_id}'>";
						}
					}

					$comparison_page_id = Helper::get_option( 'woolementor_tools', 'comparison_page' );
		        
				$_products 		= Helper::get_posts( [ 'post_type' => 'product', 'post__not_in' => $products ] );
				$table_data 	= [];
				$product_count 	= count( $products );
				$column_width 	= "style='width:" . 100/($product_count+1) . "%'";

				$table_data['title'][] 	= "<th class='wl-pct-table-empty-header'></th>";
		        foreach ( $settings['comparison_features'] as $feature ) {
		        	$data_key 			= $feature['product_comparison_value'];
		        	$data_label 		= $feature['product_comparison_label'];
		        	$data_attribute		= $feature['product_comparison_attribute'];
		        	$meta_key			= $feature['product_comparison_meta_fields'];


		        	$table_data[ $data_label . $feature['_id'] ][] = "<th {$column_width}>{$data_label}</th>";
		        	foreach ( $products as $key => $product_id ) {
		        		$product = wc_get_product( $product_id );
		        		if( $product ){		        			
			        		$product_name 		= $product->get_name();
			        		$product_image 		= $product->get_image();
			        		$product_url 		= get_permalink( $product_id );
			        		$data_value 		= $this->get_product_data( $product, $data_key, $data_attribute, $meta_key );
			        		$thumbnail_size 	= sanitize_text_field( $settings['image_thumbnail_size'] );
			        		$thumbnail          = get_the_post_thumbnail_url( $product_id, $thumbnail_size );

			        		$product_image_html = "";
			        		if ( 'yes' == $settings['image_show_hide'] ): 
	                            if ( 'none' == $settings['image_on_click'] ): 
	                            	$product_image_html = "<img src='". esc_url( $thumbnail ) ."' alt='". esc_attr( $product_name ) ."'/>  ";
	                            elseif ( 'zoom' == $settings['image_on_click'] ) : 
	                            	$product_image_html = "<a id='wl-product-image-zoom' href='". esc_url( $thumbnail ) ."'><img src='". esc_url( $thumbnail ) ."' alt='". esc_attr( $product_name ) ."'/></a>";
	                            elseif ( 'product_page' == $settings['image_on_click'] ) : 
	                            	$product_image_html = "<a href='". esc_url( $product_url ) ."'>
	                                    <img src='". esc_url( $thumbnail ) ."' alt='". esc_attr( $product_name ) ."'/>                              
	                                </a>";
	                            endif;
	                        endif;

			        		$url_products = $products;

			        		if ( in_array( $product_id, $url_products ) ) {
			        			if ( isset( $url_products[ $key ] ) ) {
									unset( $url_products[ $key ] );
								}
			        		}

							$remove_url 	= add_query_arg( 'products', $url_products, get_permalink( $comparison_page_id ) );
		        			$remove_button 	= "<button class='wl-pct-product-remove' data-product='{$product_id}'><i class='{$settings['remove_icon']['value']}'></i></button>";

			        		$table_data[ $data_label . $feature['_id'] ][] 	= "<td ". esc_attr( $column_width ) .">". wp_kses_post( $data_value ) ."</td>";

			        		if ( !isset( $table_data['title'][ $product_id ] ) ) {
			        			$table_data['title'][ $product_id ] = "<td  ". esc_attr( $column_width ) ." class='wl-pct-table-header'><div class='wl-pct-table-header-content'>{$product_image_html}<p><a href='". esc_url( $product_url ) ."'>". esc_html( $product_name ) ."</a></p>{$remove_button}</div></td>";
		        				if ( function_exists( 'wc_get_product' ) ) {
			        				$product = wc_get_product( $product_id );
			        				if( $product ) {
				        				$product_name 		= $product->get_name();
				        				$product_image 		= $product->get_image();
				        				$product_url 		= get_permalink( $product_id );
				        				$data_value 		= $this->get_product_data( $product, $data_key, $data_attribute, $meta_key );
				        				$thumbnail_size 	= sanitize_text_field( $settings['image_thumbnail_size'] );
				        				$thumbnail          = get_the_post_thumbnail_url( $product_id, $thumbnail_size );

				        				$product_image_html = "";
				        				if ( 'yes' == $settings['image_show_hide'] ): 
		                            		if ( 'none' == $settings['image_on_click'] ): 
		                            			$product_image_html = "<img src='{$thumbnail}' alt='{$product_name}'/>  ";
		                            		elseif ( 'zoom' == $settings['image_on_click'] ) : 
		                            			$product_image_html = "<a id='wl-product-image-zoom' href='{$thumbnail}'><img src='{$thumbnail}' alt='{$product_name}'/></a>";
		                            		elseif ( 'product_page' == $settings['image_on_click'] ) : 
		                            			$product_image_html = "<a href='{$product_url}'>
		                                    		<img src='{$thumbnail}' alt='{$product_name}'/>                              
		                                		</a>";
		                            		endif;
		                        		endif;

				        				$url_products = $products;

				        				if ( in_array( $product_id, $url_products ) ) {
				        					if ( isset( $url_products[ $key ] ) ) {
												unset( $url_products[ $key ] );
											}
				        				}

										$remove_url 	= add_query_arg( 'products', $url_products, get_permalink( $comparison_page_id ) );
			        					$remove_button 	= "<button class='wl-pct-product-remove' data-product='{$product_id}'><i class='{$settings['remove_icon']['value']}'></i></button>";

				        				$table_data[ $data_label . $feature['_id'] ][] 	= "<td {$column_width}>{$data_value}</td>";

				        				if ( !isset( $table_data['title'][ $product_id ] ) ) {
				        					$table_data['title'][ $product_id ] = "<td  {$column_width} class='wl-pct-table-header'><div class='wl-pct-table-header-content'>{$product_image_html}<p><a href='{$product_url}'>{$product_name}</a></p>{$remove_button}</div></td>";
				        				}	
				        			}	
				        		}
			        		
			        		}
		        		
		        		}
		        	
		        	}
		        
		        } 

		        $table_html = "";

		        foreach ( $table_data as $key => $row ) {
		        	$_row = implode( '', $row );
		        	$table_html .= "<tr>{$_row}</tr>";
		        }

		        if ( count( $products ) > 0 ) {
		        	echo "<table class='wl-product-comparison-table'>{$table_html}</table>";
		        }

				?>
			</div>
			<?php if( $settings['show_button'] == 'yes' ): ?>
		        <form action="" method="">

					<input type="hidden" name="page" value="<?php echo get_permalink( $comparison_page_id ); ?>">

					<?php 

						echo $hidden_products;
						$chosen = $settings['use_chosen'] == 'yes' ? 'wcd-chosen' : '';
						echo "<select name='products[]' class='wl-comparison-products {$chosen}' required>";
						echo "<option value=''>". __( 'Select a Product', 'woolementor-pro' ) ."</option>";
						foreach ( $_products as $product_id => $product_name ):
							echo "<option value='". esc_attr( $product_id ) ."'>". esc_html( $product_name ) ."</option>";
						endforeach;
						echo "</select>";
					?>

		        	<button class="wl-comparison-product-add-button"><?php echo esc_html( $settings['button_text'] ); ?></button>
		        </form>
		        <?php if( $settings['use_chosen'] == 'yes' ): ?>
		        <script type="text/javascript">
		        	jQuery(document).ready(function(){
		        		jQuery(".wcd-chosen").chosen();
		        	});
		        </script>
		    	<?php endif;
		    endif; ?>
        </div>
        <?php
	}

	public function get_product_data( $product, $data_key, $data_attribute = '', $meta_key = '' ) {

		switch ( $data_key ) {
			case 'price':
				$currency = get_woocommerce_currency_symbol();
				return $currency.$product->get_price();
				break;

			case 'average_rating':
				return $product->get_average_rating();
				break;

			case 'description':
				return $product->get_description();
				break;

			case 'short_description':
				return $product->get_short_description();
				break;

			case 'categories':
				return wc_get_product_category_list( $product->get_id(), ', ', '','' );
				break;

			case 'tags':
				$tags = wc_get_product_tag_list( $product->get_id(), ', ', '','' );
				if ( $tags ) {
					return $tags;
				}
				else {
					return '';
				}
				break;

			case 'attributes':

				return $product->get_attribute( $data_attribute );
				break;

			case 'meta_fields':

				return get_post_meta( $product->get_id(), $meta_key, true );
				break;
			
			default:
				return '';
				break;
		}
	}
}