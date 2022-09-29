<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Faqs extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-faqs';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - FAQs', 'farmart' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-bullet-list';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'farmart' ];
	}

	public function get_script_depends() {
		return [
			'farmart-elementor'
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	/**
	 * Section Content
	 */
	protected function section_content() {
		$section = apply_filters( 'farmart_faqs_section_number', 3 );

		for ( $i = 1; $i <= $section; $i ++ ) {
			$this->start_controls_section(
				'section_section_' . $i,
				[ 'label' => sprintf( '%s %s', esc_html__( 'Section', 'farmart' ), $i ) ]
			);

			$this->add_control(
				'title_' . $i,
				[
					'label'       => esc_html__( 'Title', 'farmart' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => sprintf( '%s %s', esc_html__( 'Title ', 'farmart' ), $i ),
					'label_block' => true,
				]
			);
			$repeater = new \Elementor\Repeater();
			$repeater->add_control(
				'title_' . $i,
				[
					'label'       => esc_html__( 'Title', 'farmart' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'FAQ Title', 'farmart' ),
					'placeholder' => esc_html__( 'This is title', 'farmart' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'desc_' . $i,
				[
					'label'       => esc_html__( 'Description', 'farmart' ),
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => esc_html__( 'This is the description. Sed elit quam, iaculis sed semper sit amet udin vitae nibh. at magna akal semperFusce commodo molestie', 'farmart' ),
					'placeholder' => esc_html__( 'Enter the Description', 'farmart' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'event_' . $i,
				[
					'label'         => '',
					'type'          => Controls_Manager::REPEATER,
					'fields'        => $repeater->get_controls(),
					'default'       => [
						[
							'title_' . $i => esc_html__( 'FAQ Title', 'farmart' ),
							'desc_' . $i  => esc_html__( 'This is the description. Sed elit quam, iaculis sed semper sit amet udin vitae nibh. at magna akal semperFusce commodo molestie', 'farmart' ),
						],
						[
							'title_' . $i => esc_html__( 'FAQ Title', 'farmart' ),
							'desc_' . $i  => esc_html__( 'This is the description. Sed elit quam, iaculis sed semper sit amet udin vitae nibh. at magna akal semperFusce commodo molestie', 'farmart' ),
						],
						[
							'title_' . $i => esc_html__( 'FAQ Title', 'farmart' ),
							'desc_' . $i  => esc_html__( 'This is the description. Sed elit quam, iaculis sed semper sit amet udin vitae nibh. at magna akal semperFusce commodo molestie', 'farmart' ),
						],
						[
							'title_' . $i => esc_html__( 'FAQ Title', 'farmart' ),
							'desc_' . $i  => esc_html__( 'This is the description. Sed elit quam, iaculis sed semper sit amet udin vitae nibh. at magna akal semperFusce commodo molestie', 'farmart' ),
						],
						[
							'title_' . $i => esc_html__( 'FAQ Title', 'farmart' ),
							'desc_' . $i  => esc_html__( 'This is the description. Sed elit quam, iaculis sed semper sit amet udin vitae nibh. at magna akal semperFusce commodo molestie', 'farmart' ),
						],
						[
							'title_' . $i => esc_html__( 'FAQ Title', 'farmart' ),
							'desc_' . $i  => esc_html__( 'This is the description. Sed elit quam, iaculis sed semper sit amet udin vitae nibh. at magna akal semperFusce commodo molestie', 'farmart' ),
						],
						[
							'title_' . $i => esc_html__( 'FAQ Title', 'farmart' ),
							'desc_' . $i  => esc_html__( 'This is the description. Sed elit quam, iaculis sed semper sit amet udin vitae nibh. at magna akal semperFusce commodo molestie', 'farmart' ),
						],
						[
							'title_' . $i => esc_html__( 'FAQ Title', 'farmart' ),
							'desc_' . $i  => esc_html__( 'This is the description. Sed elit quam, iaculis sed semper sit amet udin vitae nibh. at magna akal semperFusce commodo molestie', 'farmart' ),
						],
					],
					'prevent_empty' => false
				]
			);

			$this->end_controls_section();
		}

		// Button
		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'farmart' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-envelope',
					'library' => 'linearicons',
				],
			]
		);

		$this->add_control(
			'extra_text',
			[
				'label'   => esc_html__( 'Label', 'farmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Need more help?', 'farmart' ),
			]
		);

		$this->add_control(
			'text',
			[
				'label'   => esc_html__( 'Text', 'farmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact Us', 'farmart' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'farmart' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'farmart' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_tab_title_style();
		$this->section_button_style();
		$this->section_items_style();
		$this->section_faq_title_style();
		$this->section_faq_content_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * Tab Title
	 */
	protected function section_tab_title_style() {
		$this->start_controls_section(
			'section_tab_title_style',
			[
				'label' => __( 'Tab Title', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_title_typography',
				'selector' => '{{WRAPPER}} .farmart-faqs ul.tabs-nav a',
			]
		);
		$this->start_controls_tabs( 'tabs_tab_title_style' );
		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => __( 'Normal', 'farmart' ),
			]
		);
		$this->add_control(
			'tab_title_color',
			[
				'label'     => __( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs ul.tabs-nav a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => __( 'Hover', 'farmart' ),
			]
		);
		$this->add_control(
			'tab_title_color_hover',
			[
				'label'     => __( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs ul.tabs-nav a:hover' => 'color: {{VALUE}}; box-shadow: inset 0 0 0 transparent, inset 0 -1px 0 {{VALUE}}',
					'{{WRAPPER}} .farmart-faqs ul.tabs-nav a:focus' => 'color: {{VALUE}}; box-shadow: inset 0 0 0 transparent, inset 0 -1px 0 {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_active',
			[
				'label' => __( 'Active', 'farmart' ),
			]
		);
		$this->add_control(
			'tab_title_color_active',
			[
				'label'     => __( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs ul.tabs-nav a.active' => 'color: {{VALUE}}; box-shadow: inset 0 0 0 transparent, inset 0 -1px 0 {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Button
	 */
	protected function section_button_style() {
		// Label
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Button', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'button_label',
			[
				'label'     => __( 'Label', 'farmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'button_label_color',
			[
				'label'     => __( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper .extra-text' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_label_typography',
				'selector' => '{{WRAPPER}} .farmart-faqs .button-wrapper .extra-text',
			]
		);
		$this->add_responsive_control(
			'button_label_spacing',
			[
				'label'     => __( 'Bottom Spacing', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper .extra-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Content
		$this->add_control(
			'button_content',
			[
				'label'     => __( 'Button', 'farmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .farmart-faqs .button-wrapper a',
			]
		);

		$this->add_control(
			'border_setting',
			[
				'label'        => __( 'Border', 'farmart' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart' ),
				'label_on'     => __( 'Custom', 'farmart' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'button_border_width',
			[
				'label'     => __( 'Border Width', 'farmart' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'   => [ ],
			]
		);

		$this->add_control(
			'button_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'farmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'farmart' ),
					'dashed' => esc_html__( 'Dashed', 'farmart' ),
					'solid'  => esc_html__( 'Solid', 'farmart' ),
					'none'   => esc_html__( 'None', 'farmart' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper a' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_border_radius',
			[
				'label'     => __( 'Border Radius', 'farmart' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'   => [ ],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => __( 'Border Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'farmart' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'button_normal',
			[
				'label' => __( 'Normal', 'farmart' ),
			]
		);
		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper a' => 'color: {{VALUE}};',
				],
				'default'   => '',
			]
		);
		$this->add_control(
			'button_background_color',
			[
				'label'     => __( 'Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper a' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover',
			[
				'label' => __( 'Hover', 'farmart' ),
			]
		);
		$this->add_control(
			'button_hover_color',
			[
				'label'     => __( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-faqs .button-wrapper a:focus' => 'color: {{VALUE}};',
				],
				'default'   => '',
			]
		);
		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => __( 'Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper a:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .farmart-faqs .button-wrapper a:focus' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);
		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .button-wrapper a:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .farmart-faqs .button-wrapper a:focus' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Item
	 */
	protected function section_items_style() {
		$this->start_controls_section(
			'section_items_style',
			[
				'label' => __( 'Items', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'items_general',
			[
				'label' => __( 'General', 'farmart' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'items_padding_bottom',
			[
				'label'     => __( 'Padding Bottom', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .faq-tab .wrapper' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_margin_bottom',
			[
				'label'     => __( 'Margin Bottom', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .faq-tab .wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_item_setting',
			[
				'label'        => __( 'Border', 'farmart' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart' ),
				'label_on'     => __( 'Custom', 'farmart' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'items_border_color',
			[
				'label'     => __( 'Border Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .faq-tab .wrapper' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_border_width',
			[
				'label'     => __( 'Border Width', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .faq-tab .wrapper' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'items_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'farmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'farmart' ),
					'dashed' => esc_html__( 'Dashed', 'farmart' ),
					'solid'  => esc_html__( 'Solid', 'farmart' ),
					'none'   => esc_html__( 'None', 'farmart' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .faq-tab .wrapper' => 'border-bottom-style: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		// Left Column
		$this->add_control(
			'items_left_column',
			[
				'label'     => __( 'Left Column', 'farmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'items_right_spacing',
			[
				'label'     => __( 'Right Spacing', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 15,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .col-left' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Right Column
		$this->add_control(
			'items_right_column',
			[
				'label'     => __( 'Right Column', 'farmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'items_left_spacing',
			[
				'label'     => __( 'Left Spacing', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 15,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .col-right' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * FAQ Title
	 */
	protected function section_faq_title_style() {
		$this->start_controls_section(
			'section_faq_title_style',
			[
				'label' => __( 'FAQ Title', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'faq_title_color',
			[
				'label'     => __( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs h3.faq-title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'faq_title_typography',
				'selector' => '{{WRAPPER}} .farmart-faqs h3.faq-title',
			]
		);
		$this->add_responsive_control(
			'faq_title_spacing',
			[
				'label'     => __( 'Bottom Spacing', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs h3.faq-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * FAQ Content
	 */
	protected function section_faq_content_style() {
		$this->start_controls_section(
			'section_faq_content_style',
			[
				'label' => __( 'FAQ Content', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'faq_content_color',
			[
				'label'     => __( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faqs .faq-desc' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'faq_content_typography',
				'selector' => '{{WRAPPER}} .farmart-faqs .faq-desc',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'farmart-faqs farmart-tabs',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );
		$section       = apply_filters( 'farmart_faqs_section_number', 3 );
		$output        = [ ];
		$output_time   = [ ];
		$output_events = [ ];

		for ( $i = 1; $i <= $section; $i ++ ) {
			$active = $i == 1 ? 'active' : '';
			$key = 'key-'.$i;
			if ( $settings["title_$i"] ) {
				$output_time[] = sprintf( '<li><a href="#" data-key="%s">%s</a></li>', esc_attr( $key ), $settings["title_$i"] );
			}
			$array_left = $array_right = [ ];;
			$event = $settings["event_$i"];

			if ( ! empty ( $event ) ) {

				foreach ( $event as $index => $item ) {
					$title = $item["title_$i"] ? '<h4 class="faq-title">' . $item["title_$i"] . '</h4>' : '';
					$desc  = $item["desc_$i"] ? '<div class="faq-desc">' . $item["desc_$i"] . '</div>' : '';

					if ( $index % 2 == 0 ) {
						$array_left[] = sprintf( '<div class="faq-tab left"><div class="wrapper">%s%s</div></div>', $title, $desc );
					} else {
						$array_right[] = sprintf( '<div class="faq-tab right"><div class="wrapper">%s%s</div></div>', $title, $desc );
					}
				}
			}

			$output_events[] = sprintf(
				'<div class="tabs-panel %s row">
					<div class="col-left col-xs-12 col-sm-6">%s</div>
					<div class="col-right col-xs-12 col-sm-6">%s</div>
				</div>',
				esc_attr( $key ),
				implode( '', $array_left ),
				implode( '', $array_right )
			);
		}

		$button   = $icon   = '';
		if ( $settings['icon']  && ! empty($settings['icon']['value']) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
			$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}
		$button_content = $icon . $settings['text'];

		if ( $settings['link'] ) {
			$button = sprintf(
				'<div class="button-wrapper"><div class="extra-text">%s</div>%s</div>', $settings['extra_text'], $this->get_link_control( 'link', $settings['link'], $button_content, [] )
			);
		}

		$output[] = sprintf( '<div class="faq-col-left col-md-3 col-sm-12 col-xs-12"><ul class="tabs-nav">%s</ul>%s</div>', implode( '', $output_time ), $button );

		if ( $output_events ) {
			$output[] = sprintf( '<div class="faq-tabs tabs-content col-md-9 col-sm-12 col-xs-12">%s</div>', implode( '', $output_events ) );
		}

		echo sprintf(
			'<div %s><div class="row">%s</div></div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $output )
		);
	}

	/**
	 * Get the link control
	 *
	 * @return string.
	 */
	protected function get_link_control( $link_key, $url, $content, $attr = [ ] ) {
		$attr_default = [ ];
		if ( isset( $url['url'] ) && $url['url'] ) {
			$attr_default['href'] = $url['url'];
		}

		if ( isset( $url['is_external'] ) && $url['is_external'] ) {
			$attr_default['target'] = '_blank';
		}

		if ( isset( $url['nofollow'] ) && $url['nofollow'] ) {
			$attr_default['rel'] = 'nofollow';
		}

		$tag = 'a';

		if ( empty( $attr_default['href'] ) ) {
			$tag = 'span';
		}

		$attr = wp_parse_args( $attr, $attr_default );

		$this->add_render_attribute( $link_key, $attr );

		return sprintf( '<%1$s %2$s>%3$s</%1$s>', $tag, $this->get_render_attribute_string( $link_key ), $content );
	}
}