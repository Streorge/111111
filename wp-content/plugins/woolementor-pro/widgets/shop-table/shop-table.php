<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Stack;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Codexpert\Woolementor\Helper as WCDH;

class Shop_Table extends Widget_Base {

    public $id;

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );

        $this->id       = wcd_get_widget_id( __CLASS__ );
        $this->widget   = wcd_get_widget( $this->id );
        
        // Are we in debug mode?
        $min = defined( 'WOOLEMENTOR_PRO_DEBUG' ) && WOOLEMENTOR_PRO_DEBUG ? '' : '.min';

        wp_register_script( "woolementor-{$this->id}", plugins_url( "assets/js/script{$min}.js", __FILE__ ), ['jquery'], '1.1', true );

        wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
    }

    public function get_script_depends() {
        return [ "woolementor-{$this->id}", 'fancybox', 'dataTables' ];
    }

    public function get_style_depends() {
        return [ "woolementor-{$this->id}", 'fancybox', 'dataTables' ];
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

        $screen_options = [
            'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
            'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
            'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
        ];

        /**
         * Settings controls
         */
        $this->start_controls_section(
            '_section_settings',
            [
                'label'     => __( 'Columns', 'woolementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'id_section',
            [
                'label'         => __( 'ID', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'id_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'ID', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,           
            ]
        );

        $this->add_control(
            'id_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => $screen_options,
                'default'       => array_keys( $screen_options ),
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'sale_ribbon_section',
            [
                'label'         => __( 'Sale Ribbon', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(

            'show_sale_ribbon',
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
            'sale_ribbon_text',
            [
                'label'         => __( 'Text', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'condition' => [
                   'show_sale_ribbon' => 'yes'
                ],
                'default'   => __( 'Sale', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'image_section',
            [
                'label'         => __( 'Image', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );

        $this->add_control(
            'image_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Image', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'image_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => $screen_options,
                'default'       => array_keys( $screen_options ),
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'title_section',
            [
                'label'         => __( 'Title', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Name', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'title_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => $screen_options,
                'default'       => array_keys( $screen_options ),
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'category_section',
            [
                'label'         => __( 'Category', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'category_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Category', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'category_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => $screen_options,
                'default'       => array_keys( $screen_options ),
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'short_desc_section',
            [
                'label'         => __( 'Short Description', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'short_desc_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Short Description', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'short_desc_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => $screen_options,
                'default'       => array_keys( $screen_options ),
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'brief_desc_section',
            [
                'label'         => __( 'Brief Description', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'brief_desc_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Description', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'brief_desc_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => $screen_options,
                // 'default'       => array_keys( $screen_options ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'brief_description_enable_hyperlink',
            [
                'label'         => __( 'Enable details link', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => false,
            ]
        );

        $this->add_control(
            'brief_description_read_more',
            [
                'label'         => __( 'Read More Text', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => ' Read More ...',
                'condition'     => [
                    'brief_description_enable_hyperlink' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'rm_hyperlink_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td a.rm-link' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td a.rm-link' => 'color: {{VALUE}}',
                ],
                'condition'     => [
                    'brief_description_enable_hyperlink' => 'yes'
                ]
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

        $this->add_control(
            'price_section',
            [
                'label'         => __( 'Price', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'price_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Price', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'price_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => $screen_options,
                'default'       => array_keys( $screen_options ),
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'action_section',
            [
                'label'         => __( 'Action', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'action_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Action', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'action_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => $screen_options,
                'default'       => array_keys( $screen_options ),
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'multiselect_visibility',
            [
                'label'         => __( 'Multiple Product Selection', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'woolementor-pro' ),
                'label_off'     => __( 'No', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => '',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'multiselect_text',
            [
                'label'         => __( 'Heading', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Purchase', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'condition' => [
                    'multiselect_visibility' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'multiselect_submit_text',
            [
                'label'         => __( 'Button Text', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Add Selected To Cart', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your text here', 'woolementor-pro' ),
                'condition' => [
                    'multiselect_visibility' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'table_header',
            [
                'label'     => __( 'Table Header', 'woolementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'top-header'        => __( 'Top Header', 'woolementor-pro' ),
                    'top-btm-header'    => __( 'Top & Bottom Headers', 'woolementor-pro' ),
                    'no-header'         => __( 'No Headers', 'woolementor-pro' ),
                ],
                'separator'         => 'before',
                'default'           => 'top-header',
                'style_transfer'    => true,
            ]
        );       

        $this->end_controls_section();

        do_action( 'codesigner_shop_query_controls', $this );

        /**
         * Data table controll
         */
        $this->start_controls_section(
            'section_content_data_table',
            [
                'label'     => __( 'DataTables', 'woolementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'data_table_show_hide',
            [
                'label'         => __( 'Enable DataTables', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => '',
                'description'   => sprintf( __( 'Check this to enable <a href="%s" target="_blank">DataTables</a> jQuery library', 'woolementor-pro' ), 'https://datatables.net/' ),
            ]
        );

        $this->add_control(
            'hide_data_table_footer',
            [
                'label'         => __( 'Hide Table Footer', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Hide', 'woolementor-pro' ),
                'label_off'     => __( 'Show', 'woolementor-pro' ),
                'return_value'  => 'none',
                'default'       => '',
                'condition'       => [
                    'data_table_show_hide' => 'yes'
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-table-div .dataTables_info' => 'display:{{VALUE}};',
                    '.wl {{WRAPPER}} .wl-st-table-div .dataTables_paginate.paging_simple_numbers' => 'display:{{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Wishlist controls
         */
        $this->start_controls_section(
            'section_content_product_image',
            [
                'label'     => __( 'Product Image', 'woolementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
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
         * Quantity controls
         */
        $this->start_controls_section(
            'section_content_qty',
            [
                'label'     => __( 'Quantity Input', 'woolementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'qty_show_hide',
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
                'label'     => __( 'Wishlist', 'woolementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
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
         * Cart controls
         */
        $this->start_controls_section(
            'section_content_cart',
            [
                'label'     => __( 'Cart', 'woolementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
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
         * Pagination controls
         */
        $this->start_controls_section(
            'section_content_pagination',
            [
                'label'         => __( 'Pagination', 'woolementor-pro' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
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
         * Table Header
         */
        $this->start_controls_section(
            'tbl_header',
            [
                'label' => __( 'Table Header', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tbl_header_alignment',
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
                    '.wl {{WRAPPER}} .wl-st-main_table th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => __( 'Background Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-main_table th' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'th_text_color',
            [
                'label'     => __( 'Text Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-main_table th' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-st-main_table th',
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
         * Table Row
         */

        $this->start_controls_section(
            'section_row_design',
            [
                'label' => __( 'Table Row', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tbl_row_alignment',
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
                    '.wl {{WRAPPER}} .wl-st-main_table td' => 'text-align: {{VALUE}};',
                    '.wl {{WRAPPER}} .wl-st-info-icons' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'short_tbl_row_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-st-main_table .wl-st-td,
                                .wl {{WRAPPER}} .wl-st-main_table .wl-st-td a',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        ); 


        $this->add_control(
            'short_row_color_odd',
            [
                'label'     => __( 'Odd Row Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(odd) td' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'short_row_text_color_odd',
            [
                'label'     => __( 'Odd Row Text Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td,
                     .wl {{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td a' => 'color: {{VALUE}}',
                     '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td .amount' => 'color: {{VALUE}}',
                     '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td del .amount' => 'color: {{VALUE}}',
                     '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td ins .amount' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'short_row_color_even',
            [
                'label'     => __( 'Even Row Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(even) td' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'short_row_text_color_even',
            [
                'label'     => __( 'Even Row Text Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td,
                     .wl {{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td a' => 'color: {{VALUE}}',
                     '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td .amount' => 'color: {{VALUE}}',
                     '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td del .amount' => 'color: {{VALUE}}',
                     '.wl {{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td ins .amount' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->end_controls_section();

        /**
         * Table border
         */
        $this->start_controls_section(
            'section_tbl_border',
            [
                'label' => __( 'Table Border', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'table_border_type',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-st-main_table td, {{WRAPPER}} .wl-st-table-div .wl-st-main_table th',
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
                    '.wl {{WRAPPER}} .wl-st-img img' => 'width: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-st-img img' => 'height: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-st-img' => 'height: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-st-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-st-img img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-st-img img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'image_box_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-st-img img',
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
                    '.wl {{WRAPPER}} .wl-st-img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'      => 'image_css_filters',
                'selector'  => '.wl {{WRAPPER}} .wl-st-img img',
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
                    '.wl {{WRAPPER}} .wl-st-img img:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'      => 'image_css_filters_hover',
                'selector'  => '.wl {{WRAPPER}} .wl-st-img img:hover',
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
                    '.wl {{WRAPPER}} .wl-st-img img:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Sale Ribbon section Style
         */
        $this->start_controls_section(
            'style_section_sale_ribbon',
            [
                'label' => __( 'Sale Ribbon', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,             
                'condition' => [
                    'show_sale_ribbon' => 'yes'
                ],

            ]
        );

        $this->add_control(
            'sale_ribbon_color',
            [
                'label' => __( 'Text Color', 'woolementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-sale' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'sale_ribbon_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-st-sale',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 12 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sale_ribbon_bg_color',
                'label' => __( 'Front Side', 'woolementor-pro' ),
                'types' => [ 'classic', 'gradient'],
                'selector' => '.wl {{WRAPPER}} .wl-st-sale',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'sale_border_type',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-st-sale',
            ]
        );

        $this->add_control(
            'sale_ribbon_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'separator'     => 'after',
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-sale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'Sale_ribbon_width',
            [
                'label' => __( 'Width', 'woolementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-sale' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'Sale_ribbon_height',
            [
                'label' => __( 'Height', 'woolementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],              
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-sale' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sale_ribbon_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'separator'     => 'after',
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-sale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'Sale_ribbon_rotation',
            [
                'label' => __( 'Rotation', 'woolementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 360,
                        'step' => 1,
                    ],                      
                ],
                'separator' => 'after',
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-sale' => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );

        $this->add_control(
            'Sale_ribbon_x_position',
            [
                'label' => __( 'Position X', 'woolementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -180,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-sale' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'Sale_ribbon_y_position',
            [
                'label' => __( 'Position Y', 'woolementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -80,
                        'max' => 300,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-sale' => 'top: {{SIZE}}{{UNIT}};',
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
                'label' => __( 'Product Price', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sale_price_show_hide',
            [
                'label'         => __( 'Show Sale Price', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'block',
                'default'       => 'none',
                'separator'     => 'before',
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-main_table td del' => 'display: {{VALUE}}',
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
                'label' => __( 'Currency Symbol', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_currency',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Quantity Field
         */
        $this->start_controls_section(
            'section_style_qty',
            [
                'label' => __( 'Quantity Input', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'qty_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'qty_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .wl-st-info-icons .wl-st-qty',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_control(
            'qty_width',
            [
                'label' => __( 'Width', 'woolementor-pro' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 300,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'qty_color',
            [
                'label'     => __( 'Text Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'qty_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'qty_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-st-info-icons .wl-st-qty',
            ]
        );

        $this->add_responsive_control(
            'qty_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'qty_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'separator'     => 'before',
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'qty_margin',
            [
                'label'         => __( 'Margin', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

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
                'label'     => __( 'Icon Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_area',
            [
                'label' => __( 'Area', 'woolementor-pro' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 300,
                        'step'  => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-fav i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

         $this->add_control(
            'wishlist_icon_line_height',
            [
                'label' => __( 'Line Height', 'woolementor-pro' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 300,
                        'step'  => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-fav i' => 'line-height: {{SIZE}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-st-product-fav i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'wishlist_normal_separator',
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
                    '.wl {{WRAPPER}} .wl-st-product-fav i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-fav i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-st-product-fav i',
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
                    '.wl {{WRAPPER}} .wl-st-product-fav i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-fav i:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-st-product-fav i:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'wishlist_active',
            [
                'label'     => __( 'Active', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color_active',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-fav.button.ajax_add_to_wish.fav-item i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_active',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-fav.button.ajax_add_to_wish.fav-item i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_active',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-st-product-fav.button.ajax_add_to_wish.fav-item i',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /**
         * Cart Button
         */
        $this->start_controls_section(
            'section_style_cart',
            [
                'label' => __( 'Cart Button', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
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
                'label'     => __( 'Icon Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-st-info-icons .added_to_cart.wc-forward::after' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_area',
            [
                'label' => __( 'Area', 'woolementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-cart i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-st-info-icons .added_to_cart.wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_line_hight',
            [
                'label' => __( 'Line Height', 'woolementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-cart i' => 'line-height: {{SIZE}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-st-info-icons .added_to_cart.wc-forward::after' => 'line-height: {{SIZE}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-st-product-cart i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-st-product-cart i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-cart i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-st-product-cart i',
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
                    '.wl {{WRAPPER}} .wl-st-product-cart i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-cart i:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-st-product-cart i:hover',
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
                    '.wl {{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_view_cart',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
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
                    '.wl {{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'view_cart_icon_position_y',
            [
                'label'     => __( 'Position Adjust Y', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after' => 'padding-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'view_cart_icon_position_x',
            [
                'label'     => __( 'Position Adjust X', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'default'   => [
                    'unit'  => 'px',
                    'size'  => 13
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after' => 'padding-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_view_cart',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Multiselect cart Button
         */
        $this->start_controls_section(
            'section_style_miltiple_cart_btn',
            [
                'label' => __( 'Multiselect cart Button', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'multiselect_visibility' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_alignment',
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
                'default'   => 'right',
                'toggle'    => true,
                'selectors' => [
                    '.wl {{WRAPPER}} .multiselect-submit-div' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'miltiple_cart_btn_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-submit',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_responsive_control(
            'miltiple_cart_btn_margin',
            [
                'label'         => __( 'Margin', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .multiselect-submit-div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'miltiple_cart_btn_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'miltiple_cart_btn_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'miltiple_cart_btn_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'miltiple_cart_btn_normal',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'miltiple_cart_btn_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-submit',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'miltiple_cart_btn_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_color_hover',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-submit:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-submit:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'miltiple_cart_btn_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-submit:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'more_options',
            [
                'label' => __( 'View Cart Button', 'woolementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'miltiple_view_cart_btn_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-view-cart',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_responsive_control(
            'miltiple_view_cart_btn_padding',
            [
                'label'         => __( 'Padding', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-view-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'miltiple_view_cart_btn_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-view-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'miltiple_view_cart_btn_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'miltiple_view_cart_btn_normal',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'miltiple_view_cart_btn_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-view-cart' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'miltiple_view_cart_btn_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-view-cart' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'miltiple_view_cart_btn_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-view-cart',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'miltiple_view_cart_btn_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'miltiple_view_cart_btn_color_hover',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-view-cart:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'miltiple_view_cart_btn_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-view-cart:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'miltiple_view_cart_btn_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .multiselect-submit-div .multiselect-view-cart:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Pagination Controll
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
                'label'        => __( 'Alignment', 'woolementor-pro' ),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
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
                    '.wl {{WRAPPER}} .wl-st-pagination' => 'text-align: {{VALUE}};',
                ],
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
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers' => 'font-size: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-st-pagination .page-numbers',
            ]
        );

        $this->add_responsive_control(
            'pagination_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers.current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_current_item_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers.current' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_current_item_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-st-pagination .page-numbers.current',
            ]
        );

        $this->add_responsive_control(
            'pagination_current_item_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_item_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_hover_item_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-st-pagination .page-numbers:hover',
            ]
        );

        $this->add_responsive_control(
            'pagination_hover_item_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-st-pagination .page-numbers:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        do_action( 'codesigner_after_shop_style_controls', $this );
    }

    protected function render() {
        $settings  = $this->get_settings_for_display();
        $widget_id = $this->id;
        extract( $settings );

        $data_table_show_hide = $settings['data_table_show_hide'] == 'yes' ? 'wl-st-data-table ' : '';

        $data = [
            'sale_ribbon_text'                   => $sale_ribbon_text,
            'woolementor_condition_list'         => $woolementor_condition_list,
            'custom_query'                       => $custom_query,
            'product_source'                     => $product_source,
            'content_source'                     => $content_source,
            'main_product_id'                    => $main_product_id,
            'product_limit'                      => $product_limit,
            'ns_exclude_products'                => $ns_exclude_products,
            'number'                             => $number,
            'order'                              => $order,
            'orderby'                            => $orderby,
            'author'                             => $author,
            'categories'                         => $categories,
            'exclude_categories'                 => $exclude_categories,
            'include_products'                   => $include_products,
            'exclude_products'                   => $exclude_products,
            'sale_products_show_hide'            => $sale_products_show_hide,
            'out_of_stock'                       => $out_of_stock,
            'offset'                             => $offset,
            'image_on_click'                     => $image_on_click,
            'cart_show_hide'                     => $cart_show_hide,
            'wishlist_show_hide'                 => $wishlist_show_hide,
            'pagination_show_hide'               => $pagination_show_hide,
            'image_thumbnail_size'               => $image_thumbnail_size,
            'quick_view_show_hide'               => $quick_view_show_hide,
            'wishlist_icon'                      => $wishlist_icon,
            'cart_icon'                          => $cart_icon,
            'pagination_left_icon'               => $pagination_left_icon,
            'pagination_right_icon'              => $pagination_right_icon,
            'multiselect_visibility'             => $multiselect_visibility,
            'table_header'                       => $table_header,
            'table_header'                       => $table_header,
            'id_visibility'                      => $id_visibility,
            'image_visibility'                   => $image_visibility,
            'category_visibility'                => $category_visibility,
            'short_desc_visibility'              => $short_desc_visibility,
            'brief_desc_visibility'              => $brief_desc_visibility,
            'price_visibility'                   => $price_visibility,
            'action_visibility'                  => $action_visibility,
            'id_visibility'                      => $id_visibility,
            'id_text'                            => $id_text,
            'image_text'                         => $image_text,
            'title_text'                         => $title_text,
            'category_text'                      => $category_text,
            'short_desc_text'                    => $short_desc_text,
            'brief_desc_text'                    => $brief_desc_text,
            'price_text'                         => $price_text,
            'action_text'                        => $action_text,
            'multiselect_text'                   => $multiselect_text,
            'title_visibility'                   => $title_visibility,
            'show_sale_ribbon'                   => $show_sale_ribbon,
            'brief_description_enable_hyperlink' => $brief_description_enable_hyperlink,
            'brief_description_read_more'        => $brief_description_read_more,
            'product_desc_words_count'           => $product_desc_words_count,
            'brief_description_enable_hyperlink' => $brief_description_enable_hyperlink,
            'brief_description_read_more'        => $brief_description_read_more,
            'product_desc_words_count'           => $product_desc_words_count,
            'brief_description_enable_hyperlink' => $brief_description_enable_hyperlink,
            'brief_description_read_more'        => $brief_description_read_more,
            'product_desc_words_count'           => $product_desc_words_count,
            'brief_description_enable_hyperlink' => $brief_description_enable_hyperlink,
            'brief_description_read_more'        => $brief_description_read_more,
            'product_desc_words_count'           => $product_desc_words_count,
            'brief_description_enable_hyperlink' => $brief_description_enable_hyperlink,
            'brief_description_read_more'        => $brief_description_read_more,
            'product_desc_words_count'           => $product_desc_words_count,
            'brief_description_enable_hyperlink' => $brief_description_enable_hyperlink,
            'brief_description_read_more'        => $brief_description_read_more,
            'product_desc_words_count'           => $product_desc_words_count,
            'qty_show_hide'                      => $qty_show_hide,
            'multiselect_submit_text'            => $multiselect_submit_text,
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