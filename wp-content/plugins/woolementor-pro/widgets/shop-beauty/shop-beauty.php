<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Helper as WCDH;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Shop_Beauty extends Widget_Base {

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

        do_action( 'codesigner_before_shop_content_controls', $this );

        /**
         * Settings controls
         */
        $this->start_controls_section(
            '_section_settings',
            [
                'label' => __( 'Layout', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'     => __( 'Columns', 'woolementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    1 => __( '1 Column', 'woolementor' ),
                    2 => __( '2 Columns', 'woolementor' ),
                    3 => __( '3 Columns', 'woolementor' ),
                    4 => __( '4 Columns', 'woolementor' ),
                ],
                'desktop_default'   => 2,
                'tablet_default'    => 2,
                'mobile_default'    => 1,
                'style_transfer'    => true,
                'selectors' => [
                    '.wl {{WRAPPER}} .cx-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(100px,1fr));',
                ],
            ]
        );

        $this->end_controls_section();

        do_action( 'codesigner_shop_query_controls', $this );

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
            ]
        );

        $this->end_controls_section();

        /**
         * Sale Ribbon controls
         */
        $this->start_controls_section(
            'section_content_sale_ribbon',
            [
                'label' => __( 'Sale Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'sale_ribbon_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'sale_ribbon_text',
            [
                'label'         => __( 'On Sale Test', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Sale', 'woolementor' ),
                'placeholder'   => __( 'Type your title here', 'woolementor' ),
            ]
        );

        $this->end_controls_section();

        /**
         * Sale Ribbon controls
         */
        $this->start_controls_section(
            'section_content_stock',
            [
                'label' => __( 'Stock text', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'stock_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'stock_ribbon_text',
            [
                'label'         => __( 'Text', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Out Of Stock', 'woolementor' ),
                'placeholder'   => __( 'Type your text here', 'woolementor' ),
                'condition' => [
                    'stock_show_hide' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Purchase controls
         */
        $this->start_controls_section(
            'section_content_purchase',
            [
                'label' => __( 'Purchase Button', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'purchase_button_text',
            [
                'label'         => __( 'Button Text', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Purchase for %price%', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'purchase_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Wishlist controls
         */
        $this->start_controls_section(
            'section_content_wishlist',
            [
                'label' => __( 'Wishlist', 'woolementor' ) . wcd_pro_text(),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'wishlist_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Product Description
         */
        $this->start_controls_section(
            'section_content_product_desc',
            [
                'label'         => __( 'Product Description', 'woolementor-pro' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'product_desc_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * star_rating
         */
        $this->start_controls_section(
            'section_content_star_rating',
            [
                'label'         => __( 'Star Rating', 'woolementor-pro' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'star_rating_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Pagination controls
         */
        $this->start_controls_section(
            'section_content_pagination',
            [
                'label' => __( 'Pagination', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition'     => [
                    'product_source' => 'shop'
                ],
            ]
        );

        $this->add_control(
            'pagination_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();
        
        do_action( 'codesigner_after_shop_content_controls', $this );
        do_action( 'codesigner_before_shop_style_controls', $this );

        /**
         * Product Style controls
         */
        $this->start_controls_section(
            'style_section_box',
            [
                'label' => __( 'Card', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'widget_card_height',
            [
                'label'     => __( 'Card Height', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-single-widget' => 'height: {{SIZE}}{{UNIT}}',
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

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'widget_card_background',
                'label'     => __( 'Background', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl {{WRAPPER}} .wl-sb-single-widget',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'widget_card_border',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-sb-single-widget',
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'widget_card_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-sb-single-widget',
            ]
        );

        $this->add_responsive_control(
            'widget_card_shadow_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-single-product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label'     => __( 'Gap Row', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .cx-grid' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
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
                    'size' => 15,
                ],
            ]
        );

        $this->add_responsive_control(
            'gap_column',
            [
                'label'     => __( 'Gap Column', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .cx-grid' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
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
                    'size' => 15,
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_section_position_y',
            [
                'label'     => __( 'Button Area Position Y', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'separator' => 'before',
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-purchase-wishlist-area' => 'bottom: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 300
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_section_position_x',
            [
                'label'     => __( 'Button Area Position X', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-purchase-wishlist-area' => 'right: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 300
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Product Title
         */
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __( 'Product Title', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name'      => 'title_color',
                'selector'  => '.wl {{WRAPPER}} .wl-gradient-heading',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-sb-product-name a',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 16 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

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
                    '.wl {{WRAPPER}} .wl-sb-product-img img' => 'width: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-sb-product-img img' => 'height: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-sb-product-img' => 'height: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-sb-product-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-sb-product-img img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-product-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'image_box_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-sb-product-img img',
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
                    '.wl {{WRAPPER}} .wl-sb-product-img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'      => 'image_css_filters',
                'selector'  => '.wl {{WRAPPER}} .wl-sb-product-img img',
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
                    '.wl {{WRAPPER}} .wl-sb-product-img img:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'      => 'image_css_filters_hover',
                'selector'  => '.wl {{WRAPPER}} .wl-sb-product-img img:hover',
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
                    '.wl {{WRAPPER}} .wl-sb-product-img img:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Product Description
         */
        $this->start_controls_section(
            'section_style_desc',
            [
                'label'         => __( 'Product Description', 'woolementor-pro' ),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'product_desc_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'product_desc_color',
            [
                'label'         => __( 'Color', 'woolementor-pro' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-product-desc p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'product_desc_typography',
                'label'         => __( 'Typography', 'woolementor-pro' ),
                'scheme'        => Typography::TYPOGRAPHY_3,
                'selector'      => '.wl {{WRAPPER}} .wl-sb-product-desc p',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_control(
            'product_desc_words_count',
            [
                'label'         => __( 'Words Count', 'woolementor-pro' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 10,
            ]
        );

        $this->end_controls_section();

        /**
         * star_rating
         */
        $this->start_controls_section(
            'section_style_star_rating',
            [
                'label'         => __( 'Star Rating', 'woolementor-pro' ),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'star_rating_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'star_rating_blockicon',
            [
                'label'         => __( 'Block Icon', 'woolementor-pro' ),
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'fas fa-star',
                    'library'   => 'solid',
                ],
            ]
        );

        $this->add_control(
            'star_rating_empty_icon',
            [
                'label'         => __( 'Empty Icon', 'woolementor-pro' ),
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'far fa-star',
                    'library'   => 'solid',
                ],
            ]
        );

        $this->add_responsive_control(
            'star_rating_icon_size',
            [
                'label'         => __( 'Icon Size', 'woolementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-rating' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'star_rating_color',
            [
                'label'         => __( 'Color', 'woolementor-pro' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-rating' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
        * Sale Ribbon Styleing 
        */

        $this->start_controls_section(
            'section_style_sale_ribbon',
            [
                'label' => __( 'Sale Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
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
                    '.wl {{WRAPPER}} .wl-sb-corner-ribbon' => 'left: {{SIZE}}{{UNIT}}'
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
                    '.wl {{WRAPPER}} .wl-sb-corner-ribbon' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();

        $this->add_responsive_control(
            'sale_ribbon_width',
            [
                'label'     => __( 'Width', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-corner-ribbon' => 'width: {{SIZE}}{{UNIT}}',
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
            'sale_ribbon_transform',
            [
                'label'     => __( 'Transform', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-corner-ribbon' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 360
                    ]
                ],
            ]
        );

        $this->add_control(
            'sale_ribbon_font_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-corner-ribbon' => 'color: {{VALUE}}',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'content_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-sb-corner-ribbon',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 12 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_control(
            'sale_ribbon_background',
            [
                'label'         => __( 'Background', 'woolementor' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-corner-ribbon' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'sale_ribbon_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-corner-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'top'           => '0',
                    'right'         => '12',
                    'bottom'        => '0',
                    'left'          => '12',
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'sale_ribbon_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sb-corner-ribbon',
            ]
        );

        $this->add_responsive_control(
            'sale_ribbon_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-corner-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
        * Stock Ribbon Styleing 
        */

        $this->start_controls_section(
            'section_style_stock_ribbon',
            [
                'label' => __( 'Stock Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'stock_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'stock_offset_toggle',
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
            'stock_media_offset_x',
            [
                'label'         => __( 'Offset Left', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%'],
                'condition'     => [
                    'stock_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                    '%'        => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-stock' => 'left: {{SIZE}}{{UNIT}}'
                ],
                'render_type'   => 'ui',
            ]
        );

        $this->add_responsive_control(
            'stock_media_offset_y',
            [
                'label'         => __( 'Offset Top', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%'],
                'condition'     => [
                    'stock_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                    '%'        => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-stock' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();

        $this->add_responsive_control(
            'stock_ribbon_width',
            [
                'label'     => __( 'Width', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-stock' => 'width: {{SIZE}}{{UNIT}}',
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
            'stock_ribbon_transform',
            [
                'label'     => __( 'Transform', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-stock' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 360
                    ]
                ],
            ]
        );

        $this->add_control(
            'stock_ribbon_font_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-stock' => 'color: {{VALUE}}',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'stock_content_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-sb-stock',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 12 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_control(
            'stock_ribbon_background',
            [
                'label'         => __( 'Background', 'woolementor' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-stock' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'stock_ribbon_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-stock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'stock_ribbon_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sb-stock',
            ]
        );

        $this->add_responsive_control(
            'stock_ribbon_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-stock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Purchase Button
         */
        $this->start_controls_section(
            'section_style_cart',
            [
                'label' => __( 'Purchase Button', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'purchase_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'cart_button_typography',
                'label'         => __( 'Typography', 'woolementor-pro' ),
                'scheme'        => Typography::TYPOGRAPHY_3,
                'selector'      => '.wl {{WRAPPER}} .wl-sb-cart-area .wl-sb-product-cart',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_button_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_button_marging',
            [
                'label'         => __( 'Margin', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-sb-info-icons a.added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'cart_normal_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'cart_normal',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'cart_icon_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
                ],
                'default'   => '#fff'
            ]
        );

        $this->add_control(
            'cart_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cart_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'cart_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart:hover' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart:hover .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sb-cart-area a.wl-sb-product-cart:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cart_view_cart',
            [
                'label'     => __( 'View Cart', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'payment_default_styles',
            [
                'label'     => __( 'Display', 'woolementor-pro' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-cart-area .added_to_cart.wc-forward::after' => "content: '" . __( 'View Cart', 'woolementor-pro' ) . "';line-height: 40px;",
                ],
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'cart_icon_color_view_cart',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-cart-area .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_view_cart',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-cart-area .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_view_cart',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sb-cart-area .added_to_cart.wc-forward::after',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Wishlist Button
         */
        $this->start_controls_section(
            'section_style_wishlist',
            [
                'label' => __( 'Wishlist Button', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'wishlist_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon',
            [
                'label'     => __( 'Icon', 'woolementor-pro' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'fas fa-heart',
                    'library'   => 'solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'heart',
                    ],
                    'fa-solid'  => [
                        'heart',
                        'heart-broken',
                        'heartbeat',
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'wishlist_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-product-fav a' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->start_controls_tabs(
            'wishlist__separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'wishlist_normal',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-product-fav a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-product-fav a' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sb-product-fav a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'wishlist_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-product-fav a:hover' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sb-product-fav a.ajax_add_to_wish.fav-item' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-product-fav a:hover' => 'background: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sb-product-fav a.ajax_add_to_wish.fav-item' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sb-product-fav a:hover, {{WRAPPER}} .wl-sb-product-fav a.ajax_add_to_wish.fav-item',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'wishlist_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-product-fav a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'wishlist_margin',
            [
                'label'         => __( 'Margin', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-product-fav a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wishlist_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-product-fav a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Pagination
         */
        $this->start_controls_section(
            'section_style_pagination',
            [
                'label' => __( 'Pagination', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pagination_show_hide' => 'yes',
                    'product_source' => 'shop'
                ],
            ]
        );

        $this->add_control(
            'pagination_alignment',
            [
                'label'     => __( 'Alignment', 'woolementor-pro' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'      => [
                        'title'     => __( 'Left', 'woolementor-pro' ),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title'     => __( 'Center', 'woolementor-pro' ),
                        'icon'      => 'eicon-text-align-center',
                    ],
                    'right'     => [
                        'title'     => __( 'Right', 'woolementor-pro' ),
                        'icon'      => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'toggle'    => true,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-pagination' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_gap',
            [
                'label'     => __( 'Gap with shop', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
                'default' =>[
                    'unit' => 'px',
                    'size' => 20
                ]
            ]
        );

        $this->add_control(
            'pagination_left_icon',
            [
                'label'     => __( 'Left Icon', 'woolementor-pro' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'eicon-chevron-left',
                    'library'   => 'solid',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'pagination_right_icon',
            [
                'label'     => __( 'Right Icon', 'woolementor-pro' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'eicon-chevron-right',
                    'library'   => 'solid',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_icon_size',
            [
                'label'     => __( 'Font Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_item_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'pagination_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'pagination_normal_item',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers',
            ]
        );

        $this->add_responsive_control(
            'pagination_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pagination_current_item',
            [
                'label'     => __( 'Active', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'pagination_current_item_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers.current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_current_item_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers.current' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_current_item_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers.current',
            ]
        );

        $this->add_responsive_control(
            'pagination_current_item_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'pagination_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'pagination_hover_item_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_item_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_hover_item_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers:hover',
            ]
        );

        $this->add_responsive_control(
            'pagination_hover_item_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_transition',
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
                    '.wl {{WRAPPER}} .wl-sb-pagination .page-numbers:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        do_action( 'codesigner_after_shop_style_controls', $this );
    }

    protected function render() {  

        $settings   = $this->get_settings_for_display();
        $widget_id  = $this->id;
        extract( $settings );

        $data = [
            'sale_ribbon_text'              => $sale_ribbon_text,
            'stock_ribbon_text'             => $stock_ribbon_text,
            'woolementor_condition_list'    => $woolementor_condition_list,
            'custom_query'                  => $custom_query,
            'columns'                       => $columns,
            'product_source'                => $product_source,
            'content_source'                => $content_source,
            'main_product_id'               => $main_product_id,
            'product_limit'                 => $product_limit,
            'ns_exclude_products'           => $ns_exclude_products,
            'number'                        => $number,
            'order'                         => $order,
            'orderby'                       => $orderby,
            'author'                        => $author,
            'categories'                    => $categories,
            'exclude_categories'            => $exclude_categories,
            'include_products'              => $include_products,
            'exclude_products'              => $exclude_products,
            'sale_products_show_hide'       => $sale_products_show_hide,
            'out_of_stock'                  => $out_of_stock,
            'offset'                        => $offset,
            'image_show_hide'               => $image_show_hide,
            'image_on_click'                => $image_on_click,
            'sale_ribbon_show_hide'         => $sale_ribbon_show_hide,
            'stock_show_hide'               => $stock_show_hide,
            'wishlist_show_hide'            => $wishlist_show_hide,
            'pagination_show_hide'          => $pagination_show_hide,
            'image_thumbnail_size'          => $image_thumbnail_size,
            'quick_view_show_hide'          => $quick_view_show_hide,
            'wishlist_icon'                 => $wishlist_icon,
            'pagination_left_icon'          => $pagination_left_icon,
            'pagination_right_icon'         => $pagination_right_icon,
            'purchase_button_text'          => $purchase_button_text,
            'purchase_show_hide'            => $purchase_show_hide,
            'product_desc_show_hide'        => $product_desc_show_hide,
            'product_desc_words_count'      => $product_desc_words_count,
            'star_rating_show_hide'         => $star_rating_show_hide,
            'star_rating_empty_icon'        => $star_rating_empty_icon,
            'star_rating_blockicon'         => $star_rating_blockicon,
        ];

        if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
            $wishlist_show_hide = 'no';
        }

        do_action( 'codesigner_before_main_content' );
        
        echo '<div class="wl-shop wl-'. esc_attr( $widget_id ) .'" data-settings="'. esc_attr( serialize( $data ) ) .'">';
        echo Helper::get_template( 'template', "widgets/{$this->id}", [ 'widget_id' => $widget_id, 'settings' => $settings ] );
        echo '</div>';


        update_post_meta( get_the_ID(), 'codesigner_quick_checkout', 0 );
        if ( wcd_is_pro_activated() && 'yes' == $quick_checkout_show_hide ) {
            $config = [
                'active_mode' => $quick_checkout_modal_active_mode
            ];
            do_action( 'codesigner_quick_checkout', $config );

            update_post_meta( get_the_ID(), 'codesigner_quick_checkout', 1 );
        }

        do_action( 'codesigner_after_main_content' );
    }
}