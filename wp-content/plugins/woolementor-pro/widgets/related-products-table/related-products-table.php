<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

class Related_Products_Table extends Widget_Base {

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

        /**
         * Query controls
         */
        $this->start_controls_section(
            'query',
            [
                'label' => __( 'Product Query', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_source',
            [
                'label'         => __( 'Content Source', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'current_product'   => __( 'Current Product', 'woolementor-pro' ),
                    'cart_items'        => __( 'Cart Items', 'woolementor' ),
                    'custom'            => __( 'Custom', 'woolementor-pro' ),
                ],
                'default'       => 'current_product' ,
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'main_product_id',
            [
                'label'         => __( 'Product ID', 'woolementor-pro' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => get_post_type( get_the_ID() ) == 'product' ? get_the_ID() : '',
                'description'   => __( 'Input the base product ID', 'woolementor-pro' ),
                'condition'     => [
                    'content_source' => 'custom'
                ],
            ]
        );

        $this->add_control(
            'product_limit',
            [
                'label'     => __( 'Products Limit', 'woolementor-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5,
                'separator' => 'before',
                'description'  => __( 'Number of related products to show', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'exclude_products',
            [
                'label'     => __( 'Exclude Products', 'woolementor-pro' ),
                'type'      => Controls_Manager::TEXT,
                'description'  => __( "Comma separated ID's of products that should be excluded", 'woolementor-pro' ),
            ]
        );
        
        $this->end_controls_section();

		/**
		 * Settings controls
		 */
		$this->start_controls_section(
            '_section_settings',
            [
                'label'     => __( 'Layout', 'woolementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'id_show_hide',
            [
                'label'         => __( 'ID', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => '',
            ]
        );

        $this->add_control(
            'id_text',
            [
                'label'         => __( 'ID', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'ID', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'condition' => [
                    'id_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'image_show_hide',
            [
                'label'         => __( 'Image', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => '',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'image_text',
            [
                'label'         => __( 'Image Heading', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Image', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'condition' => [
                    'image_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'title_show_hide',
            [
                'label'         => __( 'Name', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label'         => __( 'Name Heading', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Name', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'condition' => [
                    'title_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'category_show_hide',
            [
                'label'         => __( 'Category', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'category_text',
            [
                'label'         => __( 'Category Heading', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Category', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'condition' => [
                    'category_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'short_desc_show_hide',
            [
                'label'         => __( 'Short Description', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => '',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'short_desc_text',
            [
                'label'         => __( 'Short Description Heading', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Short Description', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'condition' => [
                    'short_desc_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'price_show_hide',
            [
                'label'         => __( 'Price', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'price_text',
            [
                'label'         => __( 'Price Heading', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Price', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'condition' => [
                    'price_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'action_show_hide',
            [
                'label'         => __( 'Action', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'action_text',
            [
                'label'         => __( 'Action Heading', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Action', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'condition' => [
                    'action_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'multiselect_show_hide',
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
                    'multiselect_show_hide' => 'yes'
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
                    'multiselect_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
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
				'label' 		=> __( 'Show/Hide', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
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
                    '{{WRAPPER}} .wl-rpt-main_table th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => __( 'Background Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-main_table th' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'th_text_color',
            [
                'label'     => __( 'Text Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-main_table th' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-rpt-main_table th',
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
                    '{{WRAPPER}} .wl-rpt-main_table td' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .wl-rpt-info-icons' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'short_tbl_row_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .wl-rpt-main_table .wl-rpt-td,
                                {{WRAPPER}} .wl-rpt-main_table .wl-rpt-td a',
            ]
        ); 


        $this->add_control(
            'short_row_color_odd',
            [
                'label'     => __( 'Odd Row Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-main_table tr:nth-child(odd) td' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .wl-rpt-main_table tr:nth-child(odd) .wl-rpt-td,
                     {{WRAPPER}} .wl-rpt-main_table tr:nth-child(odd) .wl-rpt-td a' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .wl-rpt-main_table tr:nth-child(even) td' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .wl-rpt-main_table tr:nth-child(even) .wl-rpt-td,
                     {{WRAPPER}} .wl-rpt-main_table tr:nth-child(even) .wl-rpt-td a' => 'color: {{VALUE}}',
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
                'selector'  => '{{WRAPPER}} .wl-rpt-main_table td, {{WRAPPER}} .wl-rpt-table-div .wl-rpt-main_table th',
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
				'label'			=> __( 'Show Sale Price', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'your-plugin' ),
				'label_off' 	=> __( 'Hide', 'your-plugin' ),
				'return_value' 	=> 'block',
				'default' 		=> 'none',
				'separator' 	=> 'before',
				'selectors' 	=> [
                    '{{WRAPPER}} .wl-rpt-main_table td del' => 'display: {{VALUE}}',
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
                    '{{WRAPPER}} .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
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
                'condition' => [
                    'image_show' => 'yes'
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' 		=> 'image_thumbnail',
				'exclude' 	=> [ 'custom' ],
				'include' 	=> [],
				'default' 	=> 'large',
			]
		);

		$this->end_controls_section();


        /**
         * Cart Button
         */
        $this->start_controls_section(
            'section_style_cart',
            [
                'label' => __( 'Cart Button', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'cart_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'cart_icon',
            [
                'label'     => __( 'Icon', 'woolementor-pro' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'eicon-cart-solid',
                    'library'   => 'solid',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .wl-rpt-info-icons .added_to_cart.wc-forward::after' => 'font-size: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .wl-rpt-product-cart i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wl-rpt-info-icons .added_to_cart.wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wl-rpt-product-cart i' => 'line-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wl-rpt-info-icons .added_to_cart.wc-forward::after' => 'line-height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wl-rpt-product-cart i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wl-rpt-product-cart i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-product-cart i' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '{{WRAPPER}} .wl-rpt-product-cart i',
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
                    '{{WRAPPER}} .wl-rpt-product-cart i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-product-cart i:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '{{WRAPPER}} .wl-rpt-product-cart i:hover',
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
                    '{{WRAPPER}} .wl-rpt-product-cart .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_view_cart',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-product-cart .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
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
                    '{{WRAPPER}} .wl-rpt-product-cart .added_to_cart.wc-forward::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wl-rpt-product-cart .added_to_cart.wc-forward::after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_view_cart',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '{{WRAPPER}} .wl-rpt-product-cart .added_to_cart.wc-forward::after',
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
                'condition' 	=> [
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
                    'value'     => 'eicon-heart',
                    'library'   => 'solid',
                ],
            ]
        );

        $this->add_responsive_control(
            'wishlist_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .wl-rpt-product-fav i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wl-rpt-product-fav i' => 'line-height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .wl-rpt-product-fav i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wl-rpt-product-fav i' => 'color: {{VALUE}}',
                ],
            ]
        );        

        $this->add_control(
            'wishlist_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-product-fav i' => 'background: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '{{WRAPPER}} .wl-rpt-product-fav i',
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
                    '{{WRAPPER}} .wl-rpt-product-fav i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-product-fav i:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '{{WRAPPER}} .wl-rpt-product-fav i:hover',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'wishlist_active',
            [
                'label'     => __( 'active', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color_active',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-product-fav.button.ajax_add_to_wish.fav-item i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_active',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-rpt-product-fav.button.ajax_add_to_wish.fav-item i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_active',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '{{WRAPPER}} .wl-rpt-product-fav.button.ajax_add_to_wish.fav-item i',
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
                    'multiselect_show_hide' => 'yes'
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
                    '{{WRAPPER}} .multiselect-submit-div' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'miltiple_cart_btn_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .multiselect-submit-div .multiselect-submit',
            ]
        );

        $this->add_responsive_control(
            'miltiple_cart_btn_margin',
            [
                'label'         => __( 'Margin', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .multiselect-submit-div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'miltiple_cart_btn_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '{{WRAPPER}} .multiselect-submit-div .multiselect-submit',
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
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'miltiple_cart_btn_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '{{WRAPPER}} .multiselect-submit-div .multiselect-submit:hover',
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
	}

	protected function render() {
		$settings		= $this->get_settings_for_display();
        extract( $settings );

        if ( ! is_woocommerce_activated() ) return;

        $this->render_editing_attributes();

        if ( 'cart_items' == $content_source ) {
            $related_product_ids = wcd_get_cart_related_products( $product_limit );
        }
        else {
            $exclude_products_array = explode( ',', $exclude_products );
            $related_product_ids    = wc_get_related_products( $main_product_id, $product_limit, $exclude_products_array );
        }

        $related_product_count  = count( $related_product_ids );
        $data_table_show_hide   = $settings['data_table_show_hide'] == 'yes' ? 'wl-rpt-data-table ' : '';
		?>

        <div class="wl-rpt-table-div">
            <?php if( 'yes' == $multiselect_show_hide ): ?>
                <form method="POST" class="multiple-product-add-to-cart">
            <?php endif; ?>
            <table class="wl-rpt-main_table <?php echo $data_table_show_hide; ?>">  
                <?php if ( ('top-btm-header' == $table_header || 'top-header' == $table_header) && $related_product_count > 0 ) : ?>
            <thead>
                <tr>
                    <?php $this->render_table_heading(); ?>
                </tr> 
            </thead>

            <?php endif; $s=1; 
            
            if( $related_product_count > 0 ) : 
                foreach( $related_product_ids as $product_id ) :
                    $product    = wc_get_product( $product_id );
                    $thumbnail  = get_the_post_thumbnail_url( $product_id, $image_thumbnail_size );
                    $user_id    = get_current_user_id();
                    $fav_product= in_array( $product_id, wcd_get_wishlist( $user_id ) );

                    if ( !empty( $fav_product ) ) {
                        $fav_item = 'fav-item';
                    }
                    else{
                        $fav_item = '';
                    }
                    ?>
                    <tr> 
                        <?php if( 'yes' == $id_show_hide ): ?>
                            <td class="wl-rpt-td"> <?php echo $product_id; ?> </td>
                        <?php endif;

                        if( 'yes' == $image_show_hide ): ?>
                            <td class="wl-rpt-img"> 
                                <?php if ( 'none' == $image_on_click ): ?>
                                    <img src="<?php echo esc_html( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>  
                                <?php elseif ( 'zoom' == $image_on_click ) : ?>
                                    <a id="wl-rpt-product-image-zoom" href="<?php echo esc_html( $thumbnail ); ?>"><img src="<?php echo esc_html( $thumbnail ); ?>" alt=""/></a>
                                <?php elseif ( 'product_page' == $image_on_click ) : ?>
                                    <a href="<?php the_permalink( $product_id ); ?>">
                                        <img src="<?php echo esc_html( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>         
                                    </a>
                                <?php endif ?>
                            </td>
                        <?php endif;

                        if( 'yes' == $title_show_hide ): ?>
                            <td class="wl-rpt-td"> <a href="<?php echo get_the_permalink( $product_id ); ?>"><?php echo esc_attr( $product->get_name() ); ?></a> </td>
                        <?php endif;

                        if( 'yes' == $category_show_hide ): ?>
                            <td class="wl-rpt-td"> <?php echo wc_get_product_category_list( $product_id ) ?> </td>
                        <?php endif;

                        if( 'yes' == $short_desc_show_hide ): ?>
                            <td class="wl-rpt-td"> <?php echo esc_html( $product->get_short_description() ); ?> </td>
                        <?php endif;

                        if( 'yes' == $price_show_hide ): ?>
                            <td class="wl-rpt-td"> <?php echo $product->get_price_html(); ?> </td>
                        <?php endif;

                        if( 'yes' == $action_show_hide ): ?>
                            <td> 
                                <div class="wl-rpt-info-icons">
                                    <?php if ( 'yes' == $wishlist_show_hide ): ?>
                                        <a href="#" class="wl-rpt-product-fav button ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>"><i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>" ></i></a>
                                    <?php endif;

                                    if ( 'yes' == $cart_show_hide ): ?>
                                        <?php if( 'simple' == $product->get_type() ) : ?>
                                            <div class="wl-rpt-product-cart">
                                                <a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="wl-rpt-product-cart button product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
                                            </div>
                                        <?php else: ?>
                                            <div class="wl-rpt-product-cart">
                                                <a class="wl-rpt-product-cart button" href="<?php echo get_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
                                            </div>
                                        <?php endif;
                                    endif; ?>
                                    
                                </div>
                            </td>                        
                        <?php endif;

                        if( 'yes' == $multiselect_show_hide && 'simple' == $product->get_type() ): ?>
                            <td class="wl-st-td">
                                <input type="checkbox" name="cart_item_ids[]" value="<?php echo $product_id; ?>">
                            </td>
                        <?php elseif( 'yes' == $multiselect_show_hide && 'simple' != $product->get_type() ): ?>
                            <td class="wl-st-td">
                                <input type="checkbox" name="cart_item_ids[]" value="<?php echo $product_id; ?>" disabled="">
                            </td>
                        <?php endif; ?>
                    </tr> 
                <?php endforeach;

                if ('top-btm-header' == $table_header && $related_product_count > 0 ) : ?>
                <tfoot>
                    <tr>
                        <?php $this->render_table_heading(); ?>
                    </tr> 
                </tfoot> 
                <?php endif;

            else: 

                if ( 'cart_items' != $content_source || ( wcd_is_preview_mode() || wcd_is_edit_mode() ) ) {
                     echo '<p>' . __( 'No Related Product Found!', 'woolementor' ) . '</p>';   
                }

            endif; ?>

            </table>
            <?php if( 'yes' == $multiselect_show_hide ): ?>
                <div class="multiselect-submit-div">
                    <?php wp_nonce_field( 'woolementor' ); ?>
                    <input type="hidden" name="action" value="multiple-product-add-to-cart">
                    
                    <?php 
                        printf( '<input %s type="submit" value="%s">',
                            $this->get_render_attribute_string( 'multiselect_submit_text' ),
                            esc_attr( $multiselect_submit_text )
                        );
                    ?>

                    <a class="button multiselect-view-cart" href="<?php echo wc_get_cart_url(); ?>" >View Cart</a>
                </div>
                </form>
            <?php endif; ?>
        </div>
        
        <?php
        /**
         * Load Script
         */
        $this->render_script();
	}

    private function render_editing_attributes() {
        $class = 'wl-st-table-header';

        $this->add_inline_editing_attributes( 'id_text', 'none' );
        $this->add_render_attribute( 'id_text', 'class', $class );

        $this->add_inline_editing_attributes( 'image_text', 'none' );
        $this->add_render_attribute( 'image_text', 'class', $class );

        $this->add_inline_editing_attributes( 'title_text', 'none' );
        $this->add_render_attribute( 'title_text', 'class', $class );

        $this->add_inline_editing_attributes( 'category_text', 'none' );
        $this->add_render_attribute( 'category_text', 'class', $class );

        $this->add_inline_editing_attributes( 'short_desc_text', 'none' );
        $this->add_render_attribute( 'short_desc_text', 'class', $class );

        $this->add_inline_editing_attributes( 'price_text', 'none' );
        $this->add_render_attribute( 'price_text', 'class', $class );

        $this->add_inline_editing_attributes( 'action_text', 'none' );
        $this->add_render_attribute( 'action_text', 'class', $class );

        $this->add_inline_editing_attributes( 'multiselect_text', 'none' );
        $this->add_render_attribute( 'multiselect_text', 'class', 'wl-st-table-header' );

        $this->add_inline_editing_attributes( 'multiselect_submit_text', 'none' );
        $this->add_render_attribute( 'multiselect_submit_text', 'class', 'multiselect-submit' );
    }

    private function render_table_heading() {
        $settings = $this->get_settings_for_display();
        extract( $settings );

        if( 'yes' == $id_show_hide ): 

            printf( '<th %s>%s</th>',
                $this->get_render_attribute_string( 'id_text' ),
                esc_html( $id_text )
            );

        endif;

        if( 'yes' == $image_show_hide ):

            printf( '<th %s>%s</th>',
                $this->get_render_attribute_string( 'image_text' ),
                esc_html( $image_text )
            );

        endif;

        if( 'yes' == $title_show_hide ):

            printf( '<th %s>%s</th>',
                $this->get_render_attribute_string( 'title_text' ),
                esc_html( $title_text )
            );

        endif;

        if( 'yes' == $category_show_hide ):

            printf( '<th %s>%s</th>',
                $this->get_render_attribute_string( 'category_text' ),
                esc_html( $category_text )
            );

        endif;

        if( 'yes' == $short_desc_show_hide ):

            printf( '<th %s>%s</th>',
                $this->get_render_attribute_string( 'short_desc_text' ),
                esc_html( $short_desc_text )
            );

        endif;

        if( 'yes' == $price_show_hide ):

            printf( '<th %s>%s</th>',
                $this->get_render_attribute_string( 'price_text' ),
                esc_html( $price_text )
            );

        endif;

        if( 'yes' == $action_show_hide ):

            printf( '<th %s>%s</th>',
                $this->get_render_attribute_string( 'action_text' ),
                esc_html( $action_text )
            );

        endif;

        if( 'yes' == $multiselect_show_hide ):

            printf( '<th %s>%s</th>',
                $this->get_render_attribute_string( 'multiselect_text' ),
                esc_html( $multiselect_text )
            );

        endif; 
    }

    protected function render_script() {
        ?>
        <script type="text/javascript">
            jQuery(function($){
                $('.wl-rpt-data-table').DataTable();
            })
        </script>
        <?php
    }
}