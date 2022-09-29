<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use FarmartAddons\Elementor;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Product_Categories_Carousel_2 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'fm-product-categories-carousel-2';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Product Categories Carousel 2', 'farmart' );
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
		$this->_register_categories_settings_controls();
		$this->_register_carousel_settings_controls();
	}

	protected function _register_heading_settings_controls() {
		// Heading Content
		$this->start_controls_section(
			'heading_content',
			[ 'label' => esc_html__( 'Heading', 'farmart' ) ]
		);

		$this->start_controls_tabs(
			'heading_tabs'
		);

		$this->start_controls_tab(
			'title_tab',
			[
				'label' => __( 'Title', 'farmart' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is the title', 'farmart' ),
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

		$this->end_controls_tab();

		$this->start_controls_tab(
			'link_tab',
			[
				'label' => __( 'Link', 'farmart' ),
			]
		);

		$this->add_control(
			'link_text',
			[
				'label'       => esc_html__( 'Link Text', 'farmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'See all', 'farmart' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'link', [
				'label'         => esc_html__( 'Link', 'farmart' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'farmart' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'link_icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-chevron-right',
					'library' => 'linearicons',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section(); // End Heading Content

		// Heading Style
		$this->start_controls_section(
			'heading_style',
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
					'{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => __( 'Border', 'farmart' ),
				'selector' => '{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header',
			]
		);

		$this->start_controls_tabs('heading_style_tabs',[ 'separator' => 'before', ]);

		$this->start_controls_tab(
			'heading_title_style_tab',
			[
				'label' => __( 'Title', 'farmart' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header h3',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header h3' => 'color: {{VALUE}};',
				],
			]
		);
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
					'{{WRAPPER}}   .fm-product-categories-carousel-2 .cat-header h3 .farmart-svg-icon' => 'color: {{VALUE}}',
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
					'{{WRAPPER}}  .fm-product-categories-carousel-2 .cat-header h3 .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}}  .fm-product-categories-carousel-2 .cat-header h3 .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'heading_link_style_tab',
			[
				'label' => __( 'Link', 'farmart' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_typography',
				'selector' => '{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header .header-link',
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header .header-link span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_color_hover',
			[
				'label'     => __( 'Hover Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header .header-link:hover .link-text'     => 'color: {{VALUE}}; text-shadow: 0 0 {{VALUE}};',
					'{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header .header-link:hover .farmart-svg-icon' => 'color: {{VALUE}};',
				],
			]
		);

		// Icon
		$this->add_control(
			'icon_style',
			[
				'label'        => __( 'Icon', 'farmart' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart' ),
				'label_on'     => __( 'Custom', 'farmart' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'icon_font_size',
			[
				'label'     => __( 'Font Size', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header .header-link .farmart-svg-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header .header-link .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'     => __( 'Spacing', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 20,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .cat-header .header-link .farmart-svg-icon' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section(); // End Heading Style
	}

	protected function _register_categories_settings_controls() {
		// Cats Content
		$this->start_controls_section(
			'cats_content',
			[
				'label' => esc_html__( 'Categories', 'farmart' ),
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'thumbnail',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'cats_source',
			[
				'label'       => esc_html__( 'Source', 'farmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'default' => esc_html__( 'Default', 'farmart' ),
					'custom'  => esc_html__( 'Custom', 'farmart' ),
				],
				'default'     => 'default',
				'label_block' => false,
			]
		);
		$this->add_control(
			'cats_display',
			[
				'label'       => esc_html__( 'Categories Display', 'farmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'all'    => esc_html__( 'All', 'farmart' ),
					'parent' => esc_html__( 'Parent Categories Only', 'farmart' ),
				],
				'default'     => 'parent',
				'label_block' => true,
				'condition'   => [
					'cats_source' => 'default',
				],
			]
		);
		$this->add_control(
			'cats_number',
			[
				'label'       => esc_html__( 'Categories to show', 'farmart' ),
				'description' => esc_html__( 'Set 0 to show all categories', 'farmart' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 8,
				'condition'   => [
					'cats_source' => 'default',
				],
			]
		);
		$this->add_control(
			'cats_orderby',
			[
				'label'       => esc_html__( 'Order by', 'farmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'name'  => esc_html__( 'Name', 'farmart' ),
					'id'    => esc_html__( 'ID', 'farmart' ),
					'count' => esc_html__( 'Count', 'farmart' ),
				],
				'default'     => 'name',
				'label_block' => false,
				'condition'   => [
					'cats_source' => 'default',
				],
			]
		);

		$this->add_control(
			'cats_order',
			[
				'label'       => esc_html__( 'Order', 'farmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'ASC'  => esc_html__( 'ASC', 'farmart' ),
					'DESC' => esc_html__( 'DESC', 'farmart' ),
				],
				'default'     => 'ASC',
				'label_block' => false,
				'condition'   => [
					'cats_source' => 'default',
				],
			]
		);

		$this->add_control(
			'cats_selected',
			[
				'label'       => esc_html__( 'Categories', 'farmart' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'farmart' ),
				'type'        => 'fmautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'condition'   => [
					'cats_source' => 'custom',
				],
			]
		);
		$this->end_controls_section(); // End Cats Content

		// Cats Style
		$this->start_controls_section(
			'cats_style',
			[
				'label' => esc_html__( 'Categories', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'cats_box_divider',
			[
				'label'     => __( 'Categories Box', 'farmart' ),
				'type'      => Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'categories_box_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .product-cats' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'categories_box_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .product-cats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		// Items
		$this->add_control(
			'cats_items_divider',
			[
				'label'     => __( 'Items', 'farmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'cats_items_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 ul.product-cats li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cats_items_width',
			[
				'label'      => esc_html__( 'Thumbnail Width', 'farmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}}  .fm-product-categories-carousel-2 .product-cats .cat-item .cat-thumb' => 'flex: 0 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'cat_item_hover_border_color',
			[
				'label'     => esc_html__( 'Thumbnail Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 ul.product-cats li:hover .cat-thumb img' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cat_item_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .slick-slide > *:not(:last-child) .cat-item' => 'border-color: {{VALUE}}',
				],
			]
		);

		// Cat Name
		$this->add_control(
			'cats_items_divider_2',
			[
				'label'     => __( 'Category Name', 'farmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cat_name_typography',
				'selector' => '{{WRAPPER}} .fm-product-categories-carousel-2 .product-cats .cat-text .cat-name',
			]
		);
		$this->start_controls_tabs(
			'cat_name_style_tabs'
		);

		$this->start_controls_tab(
			'cat_name_normal_style_tab',
			[
				'label' => __( 'Normal', 'farmart' ),
			]
		);

		$this->add_control(
			'cat_name_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .product-cats .cat-text .cat-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cat_name_hover_style_tab',
			[
				'label' => __( 'Hover', 'farmart' ),
			]
		);

		$this->add_control(
			'cat_name_hover_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .product-cats a:hover .cat-name' => 'color: {{VALUE}}; box-shadow: inset 0 0 0 transparent, inset 0 -1px 0 {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'cats_items_divider_3',
			[
				'label'     => __( 'Category Count', 'farmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'cats_count',
			[
				'label'        => __( 'Count', 'farmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'farmart' ),
				'label_off'    => __( 'Hide', 'farmart' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cat_count_typography',
				'selector' => '{{WRAPPER}} .fm-product-categories-carousel-2 .product-cats .cat-text .cat-count',
			]
		);
		$this->add_control(
			'cat_count_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .product-cats .cat-text .cat-count' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section(); // End Cats Style
	}

	protected function _register_carousel_settings_controls() {
		// Carousel Settings
		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'farmart' ),
			]
		);
		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'farmart' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 10,
				'default' => 3,
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
				'default' => 2,
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
				'step'        => 100,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'farmart' ),
			]
		);

		// Additional Settings
		$this->_register_responsive_settings_controls();

		$this->end_controls_section(); // End Carousel Settings

		// Carousel Style
		$this->start_controls_section(
			'carousel_style',
			[
				'label' => esc_html__( 'Carousel Settings', 'farmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'carousel_style_divider',
			[
				'label' => __( 'Arrows', 'farmart' ),
				'type'  => Controls_Manager::HEADING,
			]
		);
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

		$this->add_control(
			'arrows_size',
			[
				'label'     => __( 'Size', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'arrows_width',
			[
				'label'      => __( 'Width', 'farmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-arrow' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_height',
			[
				'label'      => __( 'Height', 'farmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-arrow' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'arrows_offset',
			[
				'label'     => esc_html__( 'Horizontal Offset', 'farmart' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-prev-arrow' => 'left: {{VALUE}}px;',
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-next-arrow' => 'right: {{VALUE}}px;',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'products_normal_settings' );

		$this->start_controls_tab( 'products_normal', [ 'label' => esc_html__( 'Normal', 'farmart' ) ] );

		$this->add_control(
			'arrows_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-arrow' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrows_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-arrow' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrows_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-arrow' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'products_hover', [ 'label' => esc_html__( 'Hover', 'farmart' ) ] );

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-arrow:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrows_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-arrow:hover' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrows_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-arrow:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'carousel_style_divider_2',
			[
				'label'     => __( 'Dots', 'farmart' ),
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

		$this->add_control(
			'dots_gap',
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
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'dots_size',
			[
				'label'     => __( 'Size', 'farmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 30,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-dots li button'        => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'dots_offset',
			[
				'label'     => esc_html__( 'Vertical Offset', 'farmart' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-dots' => 'bottom: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'dots_bg_color',
			[
				'label'     => esc_html__( 'Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-dots li button:before' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'dots_active_bg_color',
			[
				'label'     => esc_html__( 'Active Color', 'farmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .fm-product-categories-carousel-2 .categories-box .slick-dots li button:hover:before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_popover();
		$this->end_controls_section(); // End Carousel Style
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
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute(
			'wrapper', 'class', [
				'fm-product-categories-carousel-2 woocommerce',
			]
		);

		$title = $link = $icon = $title_icon = '';

		if ( $settings['title_icon'] && ! empty( $settings['title_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['title_icon'], [ 'aria-hidden' => 'true' ] );
			$title_icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if ( $settings['title'] ) {
			$title = '<h3>' . $title_icon . $settings['title'] . '</h3>';
		}

		if ( $settings['link_icon'] ) {
			if ( $settings['link_icon'] && ! empty( $settings['link_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['link_icon'], [ 'aria-hidden' => 'true' ] );
				$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
			}
		}

		if( empty( $icon ) ) {
			$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
		}

		if ( $settings['link_text'] ) {
			$text = '<span class="link-text">' . $settings['link_text'] . '</span>' . $icon;
			$link = $this->get_link_control( 'header_link', $settings['link'], $text, [ 'class' => 'header-link' ] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="cat-header">
				<?php echo $title . $link; ?>
			</div>
			<div class="categories-box">
				<?php $this->get_categories_content( $settings ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get Categories
	 */
	protected function get_categories_content( $settings ) {
		$source = $settings['cats_source'];

		$term_args = [
			'taxonomy' => 'product_cat',
		];

		if ( $source == 'default' ) {
			$display = $settings['cats_display'];
			$parent  = '';
			if ( $display == 'parent' ) {
				$parent = 0;
			}

			$term_args['orderby'] = $settings['cats_orderby'];
			$term_args['order']   = $settings['cats_order'];
			$term_args['number']  = $settings['cats_number'];
			$term_args['parent']  = $parent;

		} else {
			$cats                 = explode( ',', $settings['cats_selected'] );
			$term_args['slug']    = $cats;
			$term_args['orderby'] = 'slug__in';
		}

		$terms = get_terms( $term_args );

		$this->add_render_attribute( 'slick', 'class', [ 'product-cats' ] );
		$this->add_render_attribute( 'slick', 'data-slick', wp_json_encode( Elementor::get_data_slick($settings) ) );

		$output = [ ];

		if ( ! is_wp_error( $terms ) && $terms ) {
			$output[] = '<ul ' . $this->get_render_attribute_string( 'slick' ) . '>';

			foreach ( $terms as $term ) {
				$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );

				$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
				$settings['image']['id']  = $thumbnail_id;
				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

				$thumbnail_html = $thumbnail_id ? '<span class="cat-thumb">' . $image . '</span>' : '';
				$count        = '';

				if ( $settings['cats_count'] == 'yes' ) {
					$count = '<span class="cat-count">';
					$count .= sprintf( _n( '%s Item', '%s Items', $term->count, 'farmart' ), number_format_i18n( $term->count ) );
					$count .= '</span>';
				}

				$output[] = sprintf(
					'<li class="cat-item">
						<a href="%s">
							%s
							<span class="cat-text">
								<span class="cat-name">#%s</span>
								%s
							</span>
						</a>
					</li>',
					esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
					$thumbnail_html,
					esc_html( $term->name ),
					$count
				);
			}

			$output[] = '</ul>';
		}

		echo implode( '', $output );
	}

	/**
	 * Render link control output
	 *
	 * @param       $link_key
	 * @param       $url
	 * @param       $content
	 * @param array $attr
	 *
	 * @return string
	 */
	protected function get_link_control( $link_key, $url, $content, $attr = [ ] ) {
		$attr_default = [
			'href' => $url['url'] ? $url['url'] : '#',
		];

		if ( $url['is_external'] ) {
			$attr_default['target'] = '_blank';
		}

		if ( $url['nofollow'] ) {
			$attr_default['rel'] = 'nofollow';
		}

		$attr = wp_parse_args( $attr, $attr_default );

		$this->add_render_attribute( $link_key, $attr );

		return sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( $link_key ), $content );
	}
}