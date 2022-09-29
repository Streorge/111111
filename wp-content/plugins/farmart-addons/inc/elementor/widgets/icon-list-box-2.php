<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Box widget
 */
class Icon_List_Box_2 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-list-box-2';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Icon List Box 2', 'farmart' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-icon-box';
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
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'farmart' ) ]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart' ),
				'type'    => Controls_Manager::ICONS,
				'default'          => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);
		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is the title', 'farmart' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'desc',
			[
				'label'       => esc_html__( 'Description', 'farmart' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is the desc', 'farmart' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'elements',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'icon'  => [
							'value'   => 'icon-clock',
						],
						'title' => esc_html__( 'PREP: 10 MINS', 'farmart' ),
						'desc' => esc_html__( 'COOK: 3 HRS - 4 HRS', 'farmart' ),
					],[
						'icon'  => [
							'value'   => 'icon-chef',
						],
						'title' => esc_html__( 'Difficulties', 'farmart' ),
						'desc' => esc_html__( 'NORMAL', 'farmart' ),
					],[
						'icon'  => [
							'value'   => 'icon-dinner2',
						],
						'title' => esc_html__( 'SERVES 2 OR 4 WITH ', 'farmart' ),
						'desc' => esc_html__( 'OTHER MEALS FOOD', 'farmart' ),
					]
				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->general_section_style();
		$this->item_section_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * General
	 */
	protected function general_section_style() {

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'General', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'content_position',
			[
				'label'     => esc_html__( 'Align', 'farmart' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					''   => [
						'title' => esc_html__( 'Left', 'farmart' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'farmart' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'farmart' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-list-box .box-item' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'        => esc_html__( 'Columns', 'farmart' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'1' => esc_html__( '1 Columns', 'farmart' ),
					'2' => esc_html__( '2 Columns', 'farmart' ),
					'3' => esc_html__( '3 Columns', 'farmart' ),
					'4' => esc_html__( '4 Columns', 'farmart' ),
				],
				'default'      => '3',
				'toggle'       => false,
				'prefix_class' => 'columns-%s',
			]
		);
		$this->add_control(
			'content_background_color',
			[
				'label'     => __( 'Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-list-box .farmart-list-box__wrapper' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
				'separator'  => 'after',
			]
		);


		$this->add_control(
			'border_style',
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
					'{{WRAPPER}} .farmart-list-box, {{WRAPPER}} .farmart-list-box__wrapper .box-item' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-list-box, {{WRAPPER}} .farmart-list-box__wrapper .box-item' => 'border-color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'farmart' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-list-box__wrapper .box-item' => 'border-width: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
					'{{WRAPPER}} .farmart-list-box' => 'border-width: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 *
	 */
	protected function item_section_style() {
		$this->start_controls_section(
			'section_item_style',
			[
				'label' => __( 'Items', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      =>esc_html__( 'Padding', 'farmart' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-list-box__wrapper .box-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Top icon
		$this->add_control(
			'icon_style',
			[
				'label'     => esc_html__( 'Icon', 'farmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'     => esc_html__( 'Icon Spacing', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'default'   => [],
				'selectors' => [
					'{{WRAPPER}}  .farmart-list-box__wrapper .box-item__icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_font_size',
			[
				'label'     => esc_html__( 'Font Size', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-list-box .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-list-box .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-list-box .farmart-svg-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .farmart-list-box .farmart-svg-icon svg' => 'fill: {{VALUE}};',

				],
			]
		);

		// Text
		$this->start_controls_tabs( 'text_style_tabs', [ 'separator' => 'before', ] );

		$this->start_controls_tab(
			'heading_title_style',
			[
				'label' => __( 'Title', 'farmart' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .farmart-list-box .box-item__content .title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-list-box .box-item__content .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 5,
					],
				],
				'default'   => [],
				'selectors' => [
					'{{WRAPPER}} .farmart-list-box .box-item__content .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'desc_style',
			[
				'label' => __( 'Desc', 'farmart' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .farmart-list-box .box-item__content .desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-list-box .box-item__content .desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'wrapper', 'class', [
				'farmart-list-box content-horizontal',
			]
		);

		$els = $settings['elements'];

		$output = [ ];
		if ( ! empty ( $els ) ) {
			$output[] = '<div class="farmart-list-box__wrapper">';

			foreach ( $els as $index => $item ) {
				$icon = $desc = $title  = '';
				if ( $item['icon'] && ! empty($item['icon']['value']) && \Elementor\Icons_Manager::is_migration_allowed() ) {
					ob_start();
					\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
					$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
				}

				if ( $item['title'] ) {
					$title = '<h6 class="title">' . $item['title'] . '</h6>';
				}

				if ( $item['desc'] ) {
					$desc = '<div class="desc">' . $item['desc'] . '</div>';
				}

				$output[] = sprintf(
					'<div class="box-item">
						<div class="box-item__icon">%s</div>
						<div class="box-item__content">%s%s</div>
					</div>',
					$icon,$title,$desc
				);
			}

			$output[] = '</div>';
		}

		echo sprintf(
			'<div %s>%s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $output )
		);

	}
}