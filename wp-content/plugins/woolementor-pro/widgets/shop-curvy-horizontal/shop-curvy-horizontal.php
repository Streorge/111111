<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
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

class Shop_Curvy_Horizontal extends Widget_Base {

    public $id;

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );

        $this->id       = wcd_get_widget_id( __CLASS__ );
        $this->widget   = wcd_get_widget( $this->id );
        
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
                'label' 		=> __( 'Layout', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_CONTENT,
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
                'tablet_default'    => 1,
                'mobile_default'    => 1,
                'style_transfer'    => true,
                'selectors' => [
                    '.wl {{WRAPPER}} .cx-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(100px,1fr));',
                ],
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label'     	=> __( 'Content Alignment', 'woolementor-pro' ),
                'type'      	=>Controls_Manager::CHOOSE,
                'options'   	=> [
                    'wl-sch-left' 	=> [
                        'title'     => __( 'Left', 'woolementor-pro' ),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'wl-sch-right' => [
                        'title'     => __( 'Right', 'woolementor-pro' ),
                        'icon'      => 'eicon-text-align-right',
                    ],
                ],
                'default'  		=> 'wl-sch-left',
                'toggle'    	=> false,
            ]
        );

        $this->end_controls_section();

        do_action( 'codesigner_shop_query_controls', $this );

        /**
         * Product Image
         */
        $this->start_controls_section(
            'section_content_product_image',
            [
                'label' 		=> __( 'Product Image', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image_on_click',
            [
                'label'     	=> __( 'On Click', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SELECT,
                'options'   	=> [
                    'none'          => __( 'None', 'woolementor-pro' ),
                    'zoom'          => __( 'Zoom', 'woolementor-pro' ),
                    'product_page'  => __( 'Product Page', 'woolementor-pro' ),
                ],
                'default'   	=> 'none',
            ]
        );

        $this->end_controls_section();

        /**
         * Product Description
         */
        $this->start_controls_section(
            'section_content_product_desc',
            [
                'label' 		=> __( 'Product Description', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_CONTENT,
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
                'label' 		=> __( 'Star Rating', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_CONTENT,
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
         * Icon Position
         */
        $this->start_controls_section(
            'section_content_icon_position',
            [
                'label' 		=> __( 'Icon Position', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon_position_alignment',
            [
                'label'     	=> __( 'Alignment', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::CHOOSE,
                'options'   	=> [
                    'bottom'        => [
                        'title'     => __( 'Bottom', 'woolementor-pro' ),
                        'icon'      => 'fas fa-grip-lines',
                    ],
                    'side'      => [
                        'title'     => __( 'Side', 'woolementor-pro' ),
                        'icon'      => 'fas fa-grip-lines-vertical',
                    ],
                ],
                'default'   	=> 'bottom',
                'toggle'    	=> false,
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
                'label' => __( 'Stock Ribbon', 'woolementor' ),
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
         * Cart controls
         */
        $this->start_controls_section(
            'section_content_cart',
            [
                'label' 		=> __( 'Cart', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'cart_show_hide',
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
                'label'         => __( 'Wishlist', 'woolementor-pro' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
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
         * Pagination controls
         */
        $this->start_controls_section(
            'section_content_pagination',
            [
                'label' 		=> __( 'Pagination', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_CONTENT,
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
                'label' 		=> __( 'Card', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'widget_box_height',
            [
                'label'     => __( 'Box Height', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sch-single-widget' => 'height: {{SIZE}}{{UNIT}}',
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
                'desktop_default' => [
                    'size' => 220,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 230,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'widget_box_background',
                'label'     => __( 'Background', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl {{WRAPPER}} .wl-sch-single-widget',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      	=> 'widget_box_border',
                'label'     	=> __( 'Border', 'woolementor-pro' ),
                'selector'  	=> '.wl {{WRAPPER}} .wl-sch-single-widget',
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'widget_box_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-single-widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'     => 'after'
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-single-widget' => 'Padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      	=> 'widget_box_shadow',
                'label'     	=> __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  	=> '.wl {{WRAPPER}} .wl-sch-single-widget',
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

        $this->end_controls_section();

        /**
         * Product Title
         */
        $this->start_controls_section(
            'section_style_title',
            [
                'label' 		=> __( 'Product Title', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'title_color',
                'selector' => '.wl {{WRAPPER}} .wl-gradient-heading',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      	=> 'title_typography',
                'label'     	=> __( 'Typography', 'woolementor-pro' ),
                'scheme'    	=> Typography::TYPOGRAPHY_3,
                'selector'  	=> '.wl {{WRAPPER}} .wl-sch-product-name a',
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
         * Product Price
         */
        $this->start_controls_section(
            'section_style_price',
            [
                'label' 		=> __( 'Product Price', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     	=> __( 'Color', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                     '.wl {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price' => 'color: {{VALUE}}', 
                     '.wl {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price  .amount ' => 'color: {{VALUE}}', 
                    '.wl {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price ins .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
                     '.wl {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price > .amount' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      	=> 'price_size_typography',
                'label'     	=> __( 'Typography', 'woolementor-pro' ),
                'scheme'    	=> Typography::TYPOGRAPHY_3,
                'selector'  	=> '.wl {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price ins, {{WRAPPER}} .wl-icons-side .wl-sch-price h2, {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price > .amount',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_control(
            'sale_price_show_hide',
            [
                'label'         => __( 'Show Sale Price', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'your-plugin' ),
                'label_off'     => __( 'Hide', 'your-plugin' ),
                'return_value'  => 'block',
                'default'       => 'none',
                'separator'     => 'before',
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price del, {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price del' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sale_price_color',
            [
                'label'     	=> __( 'Color', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price del'=> 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price del' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price del .amount' => 'color: {{VALUE}}',
                ],
                'condition' 	=> [
                    'sale_price_show_hide' => 'block'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      	=> 'sale_price_size_typography',
                'label'     	=> __( 'Typography', 'woolementor-pro' ),
                'scheme'    	=> Typography::TYPOGRAPHY_3,
                'selector'  	=> '.wl {{WRAPPER}} .wl-sch-product-info h2.wl-sch-price del,{{WRAPPER}} .wl-icons-side .wl-sch-price h2 del',
                'condition' 	=> [
                    'sale_price_show_hide' => 'block'
                ],
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Product Currency Symbol
         */
        $this->start_controls_section(
            'section_style_currency',
            [
                'label' 		=> __( 'Currency Symbol', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_currency',
            [
                'label'     	=> __( 'Color', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      	=> 'price_currency_typography',
                'label'     	=> __( 'Typography', 'woolementor-pro' ),
                'scheme'    	=> Typography::TYPOGRAPHY_3,
                'selector'  	=> '.wl {{WRAPPER}} .woocommerce-Price-currencySymbol',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
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
                'label' 		=> __( 'Product Image', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      	=> 'image_thumbnail',
                'exclude'   	=> [ 'custom' ],
                'include'   	=> [],
                'default'   	=> 'large',
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'     	=> __( 'Image Width', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', '%', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-img img' => 'width: {{SIZE}}{{UNIT}}',
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
                'label'     	=> __( 'Image Height', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', '%', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-img img' => 'height: {{SIZE}}{{UNIT}}',
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
                'label'     	=> __( 'Image Box Height', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-img' => 'height: {{SIZE}}{{UNIT}}',
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
            'image_margin',
            [
                'label'         => __( 'Margin', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-product-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'     => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-product-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      	=> 'image_border',
                'label'     	=> __( 'Border', 'woolementor-pro' ),
                'selector'  	=> '.wl {{WRAPPER}} .wl-sch-product-img img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-product-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      	=> 'image_box_shadow',
                'label'     	=> __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  	=> '.wl {{WRAPPER}} .wl-sch-product-img img',
            ]
        );

        $this->start_controls_tabs(
            'image_effects',
            [
                'separator' 	=> 'before'
            ]
        );

        $this->start_controls_tab(
            'image_effects_normal',
            [
                'label'     	=> __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label'     	=> __( 'Opacity', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'range'     	=> [
                    'px'    		=> [
                        'max'   		=> 1,
                        'min'   		=> 0.10,
                        'step'  		=> 0.01,
                    ],
                ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'      	=> 'image_css_filters',
                'selector'  	=> '.wl {{WRAPPER}} .wl-sch-product-img img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'image_hover',
            [
                'label'     	=> __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label'     	=> __( 'Opacity', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'range'     	=> [
                    'px'    		=> [
                        'max'   		=> 1,
                        'min'   		=> 0.10,
                        'step'  		=> 0.01,
                    ],
                ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-img img:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'      	=> 'image_css_filters_hover',
                'selector'  	=> '.wl {{WRAPPER}} .wl-sch-product-img img:hover',
            ]
        );

        $this->add_control(
            'image_hover_transition',
            [
                'label'     	=> __( 'Transition Duration', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'range'     	=> [
                    'px'    		=> [
                        'max'   		=> 3,
                        'step'  		=> 0.1,
                    ],
                ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-img img:hover' => 'transition-duration: {{SIZE}}s',
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
                'label' 		=> __( 'Product Description', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'product_desc_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'product_desc_color',
            [
                'label'     	=> __( 'Color', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-desc p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      	=> 'product_desc_typography',
                'label'     	=> __( 'Typography', 'woolementor-pro' ),
                'scheme'    	=> Typography::TYPOGRAPHY_3,
                'selector'  	=> '.wl {{WRAPPER}} .wl-sch-product-desc p',
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
				'label' 		=> __( 'Words Count', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> 8,
			]
		);

        $this->end_controls_section();

        /**
         * star_rating
         */
        $this->start_controls_section(
            'section_style_star_rating',
            [
                'label' 		=> __( 'Star Rating', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
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
                'label'     	=> __( 'Icon Size', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-rating' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-sch-rating span ' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'star_rating_color',
            [
                'label'     	=> __( 'Color', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-rating' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sch-rating span' => 'color: {{VALUE}}',
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
                    '.wl {{WRAPPER}} .wl-sch-corner-ribbon' => 'left: {{SIZE}}{{UNIT}}'
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
                    '.wl {{WRAPPER}} .wl-sch-corner-ribbon' => 'top: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-sch-corner-ribbon' => 'width: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-sch-corner-ribbon' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
                    '.wl {{WRAPPER}} .wl-sch-corner-ribbon' => 'color: {{VALUE}}',
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
                'selector'  => '.wl {{WRAPPER}} .wl-sch-corner-ribbon',
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
                    '.wl {{WRAPPER}} .wl-sch-corner-ribbon' => 'background: {{VALUE}}',
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
                    '.wl {{WRAPPER}} .wl-sch-corner-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector'      => '.wl {{WRAPPER}} .wl-sch-corner-ribbon',
            ]
        );

        $this->add_responsive_control(
            'sale_ribbon_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-corner-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-sch-stock' => 'left: {{SIZE}}{{UNIT}}'
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
                    '.wl {{WRAPPER}} .wl-sch-stock' => 'top: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-sch-stock' => 'width: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-sch-stock' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
                    '.wl {{WRAPPER}} .wl-sch-stock' => 'color: {{VALUE}}',
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
                'selector'  => '.wl {{WRAPPER}} .wl-sch-stock',
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
                    '.wl {{WRAPPER}} .wl-sch-stock' => 'background: {{VALUE}}',
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
                    '.wl {{WRAPPER}} .wl-sch-stock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'stock_ribbon_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sch-stock',
            ]
        );

        $this->add_responsive_control(
            'stock_ribbon_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-stock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Cart Button
         */
        $this->start_controls_section(
            'section_style_cart',
            [
                'label' 		=> __( 'Cart Button', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'cart_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'cart_icon',
            [
                'label'         => __( 'Icon', 'woolementor' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'eicon-cart-solid',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'luggage-cart',
                        'opencart',
                    ],
                    'fa-solid'  => [
                        'shopping-cart',
                        'cart-arrow-down',
                        'cart-plus',
                        'luggage-cart',
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'cart_icon_size',
            [
                'label'     	=> __( 'Icon Size', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_area_size',
            [
                'label'     	=> __( 'Area Size', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-cart a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_area_line_height',
            [
                'label'         => __( 'Line Height', 'woolementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-product-cart a' => 'line-height: {{SIZE}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-sch-product-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-sch-product-cart .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'label'         => __( 'Color', 'woolementor-pro' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-product-cart a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg',
            [
                'label'         => __( 'Background', 'woolementor-pro' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-product-cart a' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sch-product-cart a',
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
                    '.wl {{WRAPPER}} .wl-sch-product-cart a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sch-product-cart a:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sch-product-cart a:hover',
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
            'cart_icon_color_view_cart',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_view_cart',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_icon_view_cart_top',
            [
                'label'     => __( 'Margin Top', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sch-product-cart .added_to_cart.wc-forward::after' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_icon_view_cart_left',
            [
                'label'     => __( 'Margin Left', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sch-product-cart .added_to_cart.wc-forward::after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_view_cart',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sch-product-cart .added_to_cart.wc-forward::after',
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
                'label' 		=> __( 'Wishlist Button', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'wishlist_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon',
            [
                'label'         => __( 'Icon', 'woolementor' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'eicon-heart',
                    'library'   => 'fa-solid',
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
                'label'     	=> __( 'Icon Size', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wishlist_area_size',
            [
                'label'     	=> __( 'Area Size', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-fav' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wishlist_area_line_height',
            [
                'label'         => __( 'Line Height', 'woolementor-pro' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-product-fav' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_color',
            [
                'label'     	=> __( 'Color', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-fav a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg',
            [
                'label'     	=> __( 'Background', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-product-fav' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sch-product-fav',
            ]
        );

        $this->add_responsive_control(
            'wishlist_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-product-fav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'label' 		=> __( 'Pagination', 'woolementor-pro' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pagination_show_hide' => 'yes',
                    'product_source' => 'shop'
                ],
            ]
        );

        $this->add_control(
            'pagination_alignment',
            [
                'label'         => __( 'Alignment', 'woolementor-pro' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'          => [
                        'title'         => __( 'Left', 'woolementor-pro' ),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'        => [
                        'title'         => __( 'Center', 'woolementor-pro' ),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'right'         => [
                        'title'         => __( 'Right', 'woolementor-pro' ),
                        'icon'          => 'eicon-text-align-right',
                    ],
                ],
                'default'       => 'center',
                'toggle'        => true,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-pagination' => 'text-align: {{VALUE}};',
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
                    '.wl {{WRAPPER}} .wl-sch-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
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
                'separator'     => 'before'
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
                'label'     	=> __( 'Font Size', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers' => 'font-size: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
      
        $this->start_controls_tabs(
            'pagination_separator',
            [
                'separator' 	=> 'before'
            ]
        );

        $this->start_controls_tab(
            'pagination_normal_item',
            [
                'label'     	=> __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label'     	=> __( 'Color', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_icon_bg',
            [
                'label'     	=> __( 'Background', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers',
            ]
        );

        $this->add_responsive_control(
            'pagination_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pagination_current_item',
            [
                'label'     	=> __( 'Active', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'pagination_current_item_color',
            [
                'label'     	=> __( 'Color', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers.current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_current_item_bg',
            [
                'label'     	=> __( 'Background', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers.current' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_current_item_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers.current',
            ]
        );

        $this->add_responsive_control(
            'pagination_current_item_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'pagination_hover',
            [
                'label'     	=> __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'pagination_hover_item_color',
            [
                'label'     	=> __( 'Color', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_item_bg',
            [
                'label'     	=> __( 'Background', 'woolementor-pro' ),
                'type'      	=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_hover_item_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers:hover',
            ]
        );

        $this->add_responsive_control(
            'pagination_hover_item_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-sch-pagination .page-numbers:hover' => 'transition-duration: {{SIZE}}s',
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

        $columns_tablet = isset( $columns_tablet ) && $columns_tablet ? $columns_tablet : 1;
        $columns_mobile = isset( $columns_mobile ) && $columns_mobile ? $columns_mobile : 1;

        $data = [
            'sale_ribbon_text'              => $sale_ribbon_text,
            'stock_ribbon_text'             => $stock_ribbon_text,
            'woolementor_condition_list'    => $woolementor_condition_list,
            'custom_query'                  => $custom_query,
            'columns'                       => $columns,
            'columns_tablet'                => $columns_tablet,
            'columns_mobile'                => $columns_mobile,
            'alignment'                     => $alignment,
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
            'image_on_click'                => $image_on_click,
            'sale_ribbon_show_hide'         => $sale_ribbon_show_hide,
            'stock_show_hide'               => $stock_show_hide,
            'cart_show_hide'                => $cart_show_hide,
            'wishlist_show_hide'            => $wishlist_show_hide,
            'pagination_show_hide'          => $pagination_show_hide,
            'image_thumbnail_size'          => $image_thumbnail_size,
            'quick_view_show_hide'          => $quick_view_show_hide,
            'wishlist_icon'                 => $wishlist_icon,
            'cart_icon'                     => $cart_icon,
            'pagination_left_icon'          => $pagination_left_icon,
            'pagination_right_icon'         => $pagination_right_icon,
            'icon_position_alignment'       => $icon_position_alignment,
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