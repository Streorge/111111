<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use FarmartAddons\Elementor;
use FarmartAddons\Elementor_AjaxLoader;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_List_Carousel extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-products-list-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Farmart - Products List Carousel', 'farmart' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
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
		$this->_register_heading_settings_controls();
		$this->_register_products_settings_controls();
		$this->_register_carousel_settings_controls();
		$this->_register_lazy_load_controls();
	}

	protected function _register_heading_settings_controls() {
		// Heading Settings
		$this->start_controls_section(
			'section_heading',
			[ 'label' => esc_html__( 'Heading', 'farmart' ) ]
		);
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Heading Name', 'farmart' ),
				'placeholder' => esc_html__( 'Enter your title', 'farmart' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'title_icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => '',
					'library' => 'fa-solid',
				],
			]
		);

		$this->end_controls_section(); // End Heading Settings

		// Heading Style
		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-list-carousel .products-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-list-carousel .products-header' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => esc_html__( 'Border', 'farmart' ),
				'selector' => '{{WRAPPER}} .fm-products-list-carousel .products-header',

			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Title', 'farmart' ),
				'type'       => Controls_Manager::HEADING,
				'separator'  => 'before'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .fm-products-list-carousel .products-header h3',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-list-carousel .products-header h3' => 'color: {{VALUE}};',
				],
			]
		);

		// Icon
		$this->add_control(
			'title_icon_style',
			[
				'label'        => __( 'Icon', 'farmart' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart' ),
				'label_on'     => __( 'Custom', 'farmart' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'title_icon_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .fm-products-list-carousel .products-header h3 .farmart-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'title_icon_font_size',
			[
				'label'      => esc_html__( 'Font size', 'farmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-list-carousel .products-header h3 .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_icon_right_spacing',
			[
				'label'      => esc_html__( 'Right Spacing', 'farmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-list-carousel .products-header h3 .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();

		$this->end_controls_section();
	}

	protected function _register_products_settings_controls() {
		// Products Settings
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'farmart' ) ]
		);

		$this->add_control(
			'source',
			[
				'label'       => esc_html__( 'Source', 'farmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'default' => esc_html__( 'Default', 'farmart' ),
					'custom'  => esc_html__( 'Custom', 'farmart' ),
				],
				'default'     => 'default',
				'label_block' => true,
			]
		);
		$this->add_control(
			'ids',
			[
				'label'       => esc_html__( 'Products', 'farmart' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'farmart' ),
				'type'        => 'fmautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product',
				'sortable'    => true,
				'condition'   => [
					'source' => 'custom',
				],
			]
		);

		$this->add_control(
			'product_cats',
			[
				'label'       => esc_html__( 'Product Categories', 'farmart' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => Elementor::get_taxonomy(),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'per_page',
			[
				'label'     => esc_html__( 'Total Products', 'farmart' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 8,
				'min'       => 2,
				'max'       => 50,
				'step'      => 1,
				'condition' => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'products',
			[
				'label'     => esc_html__( 'Product', 'farmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'recent'       => esc_html__( 'Recent', 'farmart' ),
					'featured'     => esc_html__( 'Featured', 'farmart' ),
					'best_selling' => esc_html__( 'Best Selling', 'farmart' ),
					'top_rated'    => esc_html__( 'Top Rated', 'farmart' ),
					'sale'         => esc_html__( 'On Sale', 'farmart' ),
				],
				'default'   => 'recent',
				'toggle'    => false,
				'condition' => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'      => esc_html__( 'Order By', 'farmart' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''           => esc_html__( 'Default', 'farmart' ),
					'date'       => esc_html__( 'Date', 'farmart' ),
					'title'      => esc_html__( 'Title', 'farmart' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart' ),
					'rand'       => esc_html__( 'Random', 'farmart' ),
				],
				'default'    => '',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'products',
							'value' => [ 'recent', 'top_rated', 'sale', 'featured' ],
						],
						[
							'name'  => 'source',
							'value' => 'default',
						]
					]
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'      => esc_html__( 'Order', 'farmart' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''     => esc_html__( 'Default', 'farmart' ),
					'asc'  => esc_html__( 'Ascending', 'farmart' ),
					'desc' => esc_html__( 'Descending', 'farmart' ),
				],
				'default'    => '',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'products',
							'value' => [ 'recent', 'top_rated', 'sale', 'featured' ],
						],
						[
							'name'  => 'source',
							'value' => 'default',
						]
					]
				],
			]
		);

		$this->end_controls_section(); // End Products Settings

		// Products Style
		$this->start_controls_section(
			'section_products_style',
			[
				'label' => esc_html__( 'Products', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-list-carousel .products-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.fm-products-list-carousel .slick-slider .slick-slide > div:not(:last-child)' => 'border-bottom-color: {{VALUE}}'
				],
			]
		);

		$this->add_responsive_control(
			'products_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-list-carousel .products-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function _register_carousel_settings_controls() {
		// Carousel Settings
		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'farmart' ) ]
		);
		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'farmart' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 10,
				'default' => 1,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'   => esc_html__( 'Slides to scroll', 'farmart' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 10,
				'default' => 1,
			]
		);
		$this->add_responsive_control(
			'rows',
			[
				'label'   => esc_html__( 'Rows', 'farmart' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 10,
				'default' => 4,
			]
		);
		$this->add_responsive_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'farmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'both'   => esc_html__( 'Arrows and Dots', 'farmart' ),
					'arrows' => esc_html__( 'Arrows', 'farmart' ),
					'dots'   => esc_html__( 'Dots', 'farmart' ),
					'none'   => esc_html__( 'None', 'farmart' ),
				],
				'default' => 'dots',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'     => __( 'Infinite Loop', 'farmart' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'farmart' ),
				'label_on'  => __( 'On', 'farmart' ),
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => __( 'Autoplay', 'farmart' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'farmart' ),
				'label_on'  => __( 'On', 'farmart' ),
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'   => __( 'Autoplay Speed (in ms)', 'farmart' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3000,
				'min'     => 100,
				'step'    => 100,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => __( 'Speed', 'farmart' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 800,
				'min'         => 100,
				'step'        => 50,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'farmart' ),
			]
		);

		// Additional Settings
		$this->_register_responsive_settings_controls();

		$this->end_controls_section(); // End Carousel Settings

		// Carousel Style
		// Carousel Settings
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Settings', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrows_style_divider',
			[
				'label' => esc_html__( 'Arrows', 'farmart' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		// Arrows
		$this->add_control(
			'arrows_style',
			[
				'label'        => __( 'Options', 'farmart' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart' ),
				'label_on'     => __( 'Custom', 'farmart' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sliders_arrows_size',
			[
				'label'     => __( 'Size', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-products-list-carousel .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_width',
			[
				'label'      => esc_html__( 'Width', 'farmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-list-carousel .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'sliders_arrow_height',
			[
				'label'      => esc_html__( 'Height', 'farmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-list-carousel .slick-arrow' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'farmart' ) ] );

		$this->add_control(
			'sliders_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-list-carousel .slick-prev-arrow, .fm-products-list-carousel .slick-next-arrow' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'sliders_arrow_background',
		// 	[
		// 		'label'     => esc_html__( 'Background Color', 'farmart' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'default'   => '',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .fm-products-list-carousel .slick-prev-arrow, .fm-products-list-carousel .slick-next-arrow' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );
		// $this->add_control(
		// 	'sliders_arrow_border_color',
		// 	[
		// 		'label'     => esc_html__( 'Border Color', 'farmart' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'default'   => '',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .fm-products-list-carousel .slick-prev-arrow, .fm-products-list-carousel .slick-next-arrow' => 'border-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_hover', [ 'label' => esc_html__( 'Hover', 'farmart' ) ] );

		$this->add_control(
			'sliders_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-list-carousel .slick-prev-arrow:hover, .fm-products-list-carousel .slick-next-arrow:hover' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'sliders_arrow_hover_background',
		// 	[
		// 		'label'     => esc_html__( 'Background Color', 'farmart' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'default'   => '',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .fm-products-list-carousel .slick-prev-arrow:hover, .fm-products-list-carousel .slick-next-arrow:hover' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );
		// $this->add_control(
		// 	'sliders_arrow_hover_border_color',
		// 	[
		// 		'label'     => esc_html__( 'Border Color', 'farmart' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'default'   => '',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .fm-products-list-carousel .slick-prev-arrow:hover, .fm-products-list-carousel .slick-next-arrow:hover' => 'border-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dots_style_divider',
			[
				'label'     => esc_html__( 'Dots', 'farmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'dots_style',
			[
				'label'        => __( 'Options', 'farmart' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart' ),
				'label_on'     => __( 'Custom', 'farmart' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();
		$this->add_responsive_control(
			'sliders_dots_gap',
			[
				'label'     => __( 'Gap', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-products-list-carousel .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'sliders_dots_width',
			[
				'label'      => esc_html__( 'Size', 'farmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-list-carousel .slick-dots li button'        => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-products-list-carousel .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);
		$this->add_responsive_control(
			'sliders_dots_offset',
			[
				'label'      => esc_html__( 'Margin', 'farmart' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => 'vertical',
				'size_units' => [ 'px', 'em', '%' ],
				'placeholder' => [
					'top'    => '25',
					'right'  => esc_html__( 'Auto', 'farmart' ),
					'bottom' => '25',
					'left'   => esc_html__( 'Auto', 'farmart' )
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-list-carousel .slick-dots' => 'margin-top: {{TOP}}{{UNIT}};margin-bottom:{{BOTTOM}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'sliders_dots_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-list-carousel .slick-dots li button:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_dots_active_background',
			[
				'label'     => esc_html__( 'Active Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-list-carousel .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fm-products-list-carousel .slick-dots li button:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_popover();
		$this->end_controls_section();
	}

	protected function _register_responsive_settings_controls() {
		$this->add_control(
			'responsive_settings_divider',
			[
				'label' => __( 'Additional Settings', 'farmart' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'responsive_breakpoint', [
				'label' => __( 'Breakpoint', 'farmart' ) . ' (px)',
				'description' => __( 'Below this breakpoint the options below will be triggered', 'farmart' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1200,
				'min'             => 320,
				'max'             => 1920,
			]
		);
		$repeater->add_control(
			'responsive_slidesToShow',
			[
				'label'           => esc_html__( 'Slides to show', 'farmart' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' => 1,
			]
		);
		$repeater->add_control(
			'responsive_slidesToScroll',
			[
				'label'           => esc_html__( 'Slides to scroll', 'farmart' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' => 1,
			]
		);
		$repeater->add_control(
			'responsive_rows',
			[
				'label'           => esc_html__( 'Rows', 'farmart' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' => 4,
			]
		);
		$repeater->add_control(
			'responsive_navigation',
			[
				'label'           => esc_html__( 'Navigation', 'farmart' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					'both'   => esc_html__( 'Arrows and Dots', 'farmart' ),
					'arrows' => esc_html__( 'Arrows', 'farmart' ),
					'dots'   => esc_html__( 'Dots', 'farmart' ),
					'none'   => esc_html__( 'None', 'farmart' ),
				],
				'default' => 'dots',
				'toggle'          => false,
			]
		);

		$this->add_control(
			'carousel_responsive_settings',
			[
				'label' => __( 'Settings', 'farmart' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default' => [

				],
				'title_field' => '{{{ responsive_breakpoint }}}' . 'px',
				'prevent_empty' => false,
			]
		);
	}

	/**
	 * Lazy Load
	 */
	protected function _register_lazy_load_controls() {
		// Content
		$this->start_controls_section(
			'section_lazy_load',
			[ 'label' => esc_html__( 'Lazy Load', 'farmart' ) ]
		);
		$this->add_control(
			'lazy_load',
			[
				'label'        => esc_html__( 'Enable', 'farmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'farmart' ),
				'label_off'    => esc_html__( 'No', 'farmart' ),
				'default'      => '',
			]
		);
		$this->add_responsive_control(
			'lazy_load_height',
			[
				'label'     => esc_html__( 'Height', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading-wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section(); // End

		// Style
		$this->start_controls_section(
			'section_lazy_load_style',
			[
				'label' => esc_html__( 'Lazy Load', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'loading_width',
			[
				'label'      => esc_html__( 'Loading Width', 'farmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading:after' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'loading_height',
			[
				'label'      => esc_html__( 'Loading Height', 'farmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading:after' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'loading_border_color',
			[
				'label'     => esc_html__( 'Loading Border Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading:after' => 'border-color: {{VALUE}} transparent {{VALUE}} transparent;',
				],
				'separator' => 'before',
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
			'fm-products-list-carousel woocommerce',
			$settings['lazy_load'] == 'yes' ? '' : 'no-infinite'
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$is_rtl    = is_rtl();
		$direction = $is_rtl ? 'rtl' : 'ltr';
		$this->add_render_attribute( 'wrapper', 'dir', $direction );

		$this->add_render_attribute( 'wrapper', 'data-settings', wp_json_encode( Elementor::get_data_slick( $settings ) ) );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $settings['lazy_load'] == 'yes' ) : ?>
				<?php
				// AJAX settings
				$this->add_render_attribute(
					'ajax_wrapper', 'class', [
						'fm-product-list-carousel-loading fm-elementor-ajax-wrapper'
					]
				);
				$ajax_settings = [
					'slidesToShow' => $settings['slidesToShow'],
					'title'        => $settings['title'],
					'title_icon'   => $settings['title_icon'],
					'ids'          => $settings['ids'],
					'product_cats' => $settings['product_cats'],
					'per_page'     => $settings['per_page'],
					'products'     => $settings['products'],
					'orderby'      => $settings['orderby'],
					'order'        => $settings['order'],
				];
				$this->add_render_attribute( 'ajax_wrapper', 'data-settings', wp_json_encode( $ajax_settings ) );
				?>
                <div <?php echo $this->get_render_attribute_string( 'ajax_wrapper' ); ?>>
                    <div class="farmart-loading-wrapper"><div class="farmart-loading"></div></div>
                </div>
			<?php else : ?>
				<?php Elementor_AjaxLoader::get_products_list_carousel( $settings ); ?>
			<?php endif; ?>
		</div>
		<?php
	}
}