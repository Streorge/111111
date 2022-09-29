<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Wishlist extends Widget_Base {

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

		$this->start_controls_section(
            '_section_settings',
            [
                'label' => __( 'Columns', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
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
            'id_show_hide',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'image_section',
            [
                'label'         => __( 'Image', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
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
            'image_show_hide',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'separator'     => 'after',
                'label_block'   => true,
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
            'title_show_hide',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
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
            'category_show_hide',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'separator'     => 'after',
                'label_block'   => true
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
            'short_desc_show_hide',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'separator'     => 'after',
                'label_block'   => true
            ]
        );

        $this->add_control(
            'price_section',
            [
                'label'         => __( 'Price', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
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
            'price_show_hide',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'separator'     => 'after',
                'label_block'   => true
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
            'action_show_hide',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'label_block'   => true,
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
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Multiselect', 'woolementor-pro' ),
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

        $this->add_control(
            'table_header',
            [
                'label'     => __( 'Table Header', 'woolementor-pro' ),
                'type'      => Controls_Manager::SELECT2,
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

        $this->start_controls_section(
            'section_content_data_table',
            [
                'label' => __( 'DataTables', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
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
		 * product image controls
		 */
		$this->start_controls_section(
            'section_content_product_image',
            [
                'label' => __( 'Product Image', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image_on_click',
            [
                'label'     => __( 'On Click', 'woolementor-pro' ),
                'type'      => Controls_Manager::SELECT2,
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
         * Table Header
         */
        $this->start_controls_section(
            'tbl_header',
            [
                'label' => __( 'Table Header', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // start default style
        $this->add_control(
            'wishlist_default_styles',
            [
                'label'     => __( 'Display', 'woolementor-pro' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-table-div .wl-wlst-main_table' => 'width: 100%;margin: 0px;',
                    '.wl {{WRAPPER}} .wl-wlst-table-div' => 'overflow-x: auto;overflow-y: hidden;',
                    '.wl {{WRAPPER}} .wl-wlst-table-div .wl-wlst-main_table thead tr th' => 'border: 1px solid #f2f2f2;',
                    '.wl {{WRAPPER}} .wl-wlst-table-div .wl-wlst-main_table tr td' => 'vertical-align: middle;',
                    '.wl {{WRAPPER}} .wl-wlst-table-div .wl-wlst-main_table td, th' => 'padding: 8px;',
                    '.wl {{WRAPPER}} .wl-wlst-cart' => 'position: relative;margin: 3px;padding: 0;display: inline-block;',
                    '.wl {{WRAPPER}} .wl-wlst-table-div .wl-wlst-main_table tr td a, 
                    .wl-wlst-table-div .wl-wlst-main_table tr td ins' => 'text-decoration: none;',
                    '.wl {{WRAPPER}} .wl-wlst-info-icons .wl-wlst-product-cart i' => 'text-align: center;border-radius: 50%;position: relative;',
                    '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist i' => 'text-align: center;border-radius: 21px;',
                    '.wl {{WRAPPER}} .wl-wlst-table-div .wl-wlst-main_table tbody tr td.wl-wlst-img' => 'width: 120px;',
                    '.wl {{WRAPPER}} .wl-wlst-table-div th' => 'text-transform: capitalize;',
                    '.wl {{WRAPPER}} .wl-wlst-info-icons .wl-wlst-product-cart' => 'outline: none;background: transparent;border: none;position: relative;',
                ],
                'default' => 'traditional',
            ]
        );
        // end default css

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
                    '.wl {{WRAPPER}} .wl-wlst-main_table th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => __( 'Background Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-main_table th' => 'background-color: {{VALUE}}',
                ],
                'default' => 'transparent'
            ]
        );

        $this->add_control(
            'th_text_color',
            [
                'label'     => __( 'Text Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-main_table th' => 'color: {{VALUE}}',
                ],
                'default' => 'var(--wl-black)'
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-wlst-main_table tr th',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Noto Sans' ],
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
                    '.wl {{WRAPPER}} .wl-wlst-main_table td' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'short_tbl_row_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-wlst-main_table .wl-wlst-td',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Noto Sans' ],
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
                    '.wl {{WRAPPER}} .wl-wlst-main_table tr:nth-child(odd) td' => 'background-color: {{VALUE}}',
                ],
                'default'   => 'transparent',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'short_row_text_color_odd',
            [
                'label'     => __( 'Odd Row Text Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-main_table tr:nth-child(odd) .wl-wlst-td,
                     {{WRAPPER}} .wl-wlst-main_table tr:nth-child(odd) .wl-wlst-td a,
                     {{WRAPPER}} .wl-wlst-main_table tr:nth-child(odd) .wl-wlst-td ins,
                     {{WRAPPER}} .wl-wlst-main_table tr:nth-child(odd) .wl-wlst-td del' => 'color: {{VALUE}}',
                ],
                'default'   => 'var(--wl-black)',
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'short_row_color_even',
            [
                'label'     => __( 'Even Row Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-main_table tr:nth-child(even) td' => 'background-color: {{VALUE}}',
                ],
                'default'   => 'transparent',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'short_row_text_color_even',
            [
                'label'     => __( 'Even Row Text Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-main_table tr:nth-child(even) .wl-wlst-td,
                     {{WRAPPER}} .wl-wlst-main_table tr:nth-child(even) .wl-wlst-td a,
                     {{WRAPPER}} .wl-wlst-main_table tr:nth-child(even) .wl-wlst-td ins,
                     {{WRAPPER}} .wl-wlst-main_table tr:nth-child(even) .wl-wlst-td del' => 'color: {{VALUE}}',
                ],
                'default'   => 'var(--wl-black)',
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
                'selector'  => '.wl {{WRAPPER}} .wl-wlst-main_table td, .wl-wlst-main_table th',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top'       => '1',
                            'right'     => '1',
                            'bottom'    => '1',
                            'left'      => '1',
                            'isLinked'  => false,
                        ],
                    ],
                    'color' => [
                        'default' => '#f2f2f2',
                    ],
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
				'label'			=> __( 'Show Sale Price', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'your-plugin' ),
				'label_off' 	=> __( 'Hide', 'your-plugin' ),
				'return_value' 	=> 'block',
				'default' 		=> 'none',
				'separator' 	=> 'before',
				'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-wlst-main_table td del' => 'display: {{VALUE}}',
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
                    '.wl {{WRAPPER}} .wl-wlst-img img' => 'width: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-wlst-img img' => 'height: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-wlst-img' => 'height: {{SIZE}}{{UNIT}}',
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
                    '.wl {{WRAPPER}} .wl-wlst-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-wlst-img img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-wlst-img img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-wlst-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'image_box_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-wlst-img img',
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
                    '.wl {{WRAPPER}} .wl-wlst-img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'      => 'image_css_filters',
                'selector'  => '.wl {{WRAPPER}} .wl-wlst-img img',
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
                    '.wl {{WRAPPER}} .wl-wlst-img img:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'      => 'image_css_filters_hover',
                'selector'  => '.wl {{WRAPPER}} .wl-wlst-img img:hover',
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
                    '.wl {{WRAPPER}} .wl-wlst-img img:hover' => 'transition-duration: {{SIZE}}s',
                ],
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
                    '.wl {{WRAPPER}} .wl-wlst-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14,
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
                    '.wl {{WRAPPER}} .wl-wlst-product-cart i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-wlst-info-icons .wl-wlst-cart .wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_line height',
            [
                'label' => __( 'Lign Height', 'woolementor-pro' ),
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
                    '.wl {{WRAPPER}} .wl-wlst-product-cart i' => 'line-height: {{SIZE}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-wlst-info-icons .wl-wlst-cart .wc-forward::after' => 'line-height: {{SIZE}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .wl-wlst-product-cart i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-wlst-info-icons .wl-wlst-cart .wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'cart_icons_color'
        );

        $this->start_controls_tab(
            'cart_icon_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );
        $this->add_control(
            'cart_icon_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-product-cart i' => 'color: {{VALUE}}',
                ],
                'default' => '#551FE8'
            ]
        );

        $this->add_control(
            'cart_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-product-cart i' => 'background: {{VALUE}}',
                ],
                'default' => 'transparent'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border',
                'label'         => __( 'Cart Icon Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-wlst-product-cart i',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top'       => '1',
                            'right'     => '1',
                            'bottom'    => '1',
                            'left'      => '1',
                            'isLinked'  => false,
                        ],
                    ],
                    'color' => [
                        'default' => '#551FE8',
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cart_icon_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );
        $this->add_control(
            'cart_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-product-cart:hover i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-product-cart:hover i' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_hover',
                'label'         => __( 'Cart Icon Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-wlst-product-cart:hover i',
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

        $this->add_responsive_control(
            'cart_icon_view_cart_top',
            [
                'label'     => __( 'Margin Top', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'top: {{SIZE}}{{UNIT}};',
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
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'left: {{SIZE}}{{UNIT}};',
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

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_view_cart',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .added_to_cart.wc-forward::after',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * rmv_wishlist_icon Button
         */
        $this->start_controls_section(
            'section_style_rmv_wishlist',
            [
                'label' => __( 'Remove Item Button', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'rmv_wishlist_icon',
            [
                'label'     => __( 'Icon', 'woolementor-pro' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'eicon-close',
                    'library'   => 'solid',
                ],
            ]
        );

        $this->add_responsive_control(
            'rmv_wishlist_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
            ]
        );
        
        $this->add_control(
            'rmv_wishlist_icon_area',
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
                    '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'rmv_wishlist_icon_line_height',
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
                    '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'rmv_wishlist_icon_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'rmv_btn_control'
        );

        $this->start_controls_tab(
            'rmv_btn_normal',
            [
                'label' => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'rmv_wishlist_icon_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist i' => 'color: {{VALUE}}',
                ],
                'default' => '#E9345F'
            ]
        );

        $this->add_control(
            'rmv_wishlist_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist i' => 'background: {{VALUE}}',
                ],
                'default' => '#fff'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'rmv_wishlist_icon_border',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist i',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top'       => '1',
                            'right'     => '1',
                            'bottom'    => '1',
                            'left'      => '1',
                            'isLinked'  => false,
                        ],
                    ],
                    'color' => [
                        'default' => '#E9345F',
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'rmv_btn_hover',
            [
                'label' => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'rmv_wishlist_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist:hover i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'rmv_wishlist_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist:hover i' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'rmv_wishlist_icon_border_hover',
                'label'         => __( 'Border', 'woolementor-pro' ),
                'selector'      => '.wl {{WRAPPER}} .wl-wlst-rmv-wishlist:hover i',
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
                    'font_family'   => [ 'default' => 'Noto Sans' ],
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

        $this->end_controls_section();
	}

	protected function render() {

		$settings		        = $this->get_settings_for_display();
        extract( $settings );

        if ( ! is_woocommerce_activated() ) return;

        $this->render_editing_attributes();

        $data_table_show_hide   = $settings[ 'data_table_show_hide' ] == 'yes' ? 'wl-wlst-data-table' : '';
        $user_id                = get_current_user_id();
        $wishlist_pids          = wcd_get_wishlist( $user_id );
		?>
        <?php if( count( $wishlist_pids ) > 0 ) : ?>

            <div class="wl-wlst-table-div">
            <?php if( 'yes' == $multiselect_show_hide ): ?>
                <form method="POST" class="multiple-product-add-to-cart">
            <?php endif; ?>
                <table id="wl-wlst-data-table" class="wl-wlst-main_table <?php echo $data_table_show_hide;?>">  
                    <?php if ( 'top-btm-header' == $table_header || 'top-header' == $table_header ) : ?>
                <thead>
                    <tr>
                        <?php $this->render_table_heading(); ?>
                    </tr>
                </thead>

                <tbody>
                    <?php endif; $s = 1; 

                    if( count( $wishlist_pids ) > 0 ) : 
                        foreach ( $wishlist_pids as $product_id ) :
                            $product    = wc_get_product( $product_id );
                            if( get_post_type( $product_id ) != 'product' ) continue;
                            $thumbnail  = get_the_post_thumbnail_url( $product_id, $image_thumbnail_size );
                            ?>
                    <tr class="wl-single-<?php echo $product_id; ?>">

                        <?php
                            if ( is_array( $id_show_hide ) && count( $id_show_hide ) > 0 ) {
                                printf( '<td class="wl-wlst-td %s">%d</td>',
                                    esc_attr( implode( ' ', $id_show_hide ) ),
                                    esc_html( $product_id )
                                );
                            }

                            $image_show_hide_class = '';
                            if ( is_array( $image_show_hide ) && count( $image_show_hide ) > 0 ) {
                                $image_show_hide_class = implode( ' ', $image_show_hide );
                            }
                        ?>

                        <td class="wl-wlst-td wl-wlst-img <?php echo $image_show_hide_class; ?>"> 

                            <?php if ( 'none' == $image_on_click ): ?>
                                <img src="<?php echo esc_attr( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>  
                            <?php elseif ( 'zoom' == $image_on_click ) : ?>
                                <a id="wl-wlst-product-image-zoom" href="<?php echo esc_attr( $thumbnail ); ?>"><img src="<?php echo esc_attr( $thumbnail ); ?>" alt=""/></a>
                            <?php elseif ( 'product_page' == $image_on_click ) : ?>
                                <a href="<?php the_permalink( $product_id ); ?>">
                                    <img src="<?php echo esc_attr( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>         
                                </a>
                            <?php endif; ?>
                        </td>

                        <?php

                            if ( is_array( $title_show_hide ) && count( $title_show_hide ) > 0 ) {
                                printf( '<td class="wl-wlst-td wl-wlst-product-title wl-wlst-td %s"><a href="%s">%s</a></td>',
                                    esc_attr( implode( ' ', $title_show_hide ) ),
                                    esc_url( get_permalink( $product_id ) ),
                                    $product->get_name()
                                );
                            }

                            if ( is_array( $category_show_hide ) && count( $category_show_hide ) > 0 ) {
                                printf( '<td class="wl-wlst-td wl-wlst-product-category wl-wlst-td %s">%s</td>',
                                    esc_attr( implode( ' ', $category_show_hide ) ),
                                    wc_get_product_category_list( $product_id )
                                );
                            }

                            if ( is_array( $short_desc_show_hide ) && count( $short_desc_show_hide ) > 0 ) {
                                printf( '<td class="wl-wlst-td %s">%s</td>',
                                    esc_attr( implode( ' ', $short_desc_show_hide ) ),
                                    $product->get_short_description()
                                );
                            }

                            if ( is_array( $price_show_hide ) && count( $price_show_hide ) > 0 ) {
                                printf( '<td class="wl-wlst-td %s">%s</td>',
                                    esc_attr( implode( ' ', $price_show_hide ) ),
                                    $product->get_price_html()
                                );
                            }

                            $action_show_hide_class = '';
                            if ( is_array( $action_show_hide ) && count( $action_show_hide ) > 0 ) {
                                $action_show_hide_class = implode( ' ', $action_show_hide );
                            }
                        ?>

                        <td class="wl-wlst-td <?php echo $action_show_hide_class; ?>"> 
                            
                            <div class="wl-wlst-info-icons">
                                <div class="wl-wlst-cart">
                                    <?php if( 'simple' == $product->get_type() ) : ?>
                                        <a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="wl-wlst-product-cart button product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
                                    <?php else: ?>
                                        <a class="wl-wlst-product-cart button" href="<?php echo get_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
                                    <?php endif; ?>
                                </div>
                                <a class="wl-wlst-rmv-wishlist ajax_remove_from_wish" href="" data-product_id="<?php echo $product_id; ?>">
                                    <i class="<?php echo esc_attr( $rmv_wishlist_icon['value'] ); ?>"></i>
                                </a>     
                            </div>
                        </td>

                        <?php if( 'yes' == $multiselect_show_hide && 'simple' == $product->get_type() ): ?>
                            <td class="wl-st-td">
                                <input type="checkbox" name="cart_item_ids[]" value="<?php echo $product_id; ?>">
                            </td>
                        <?php elseif( 'yes' == $multiselect_show_hide && 'simple' != $product->get_type() ): ?>
                            <td class="wl-st-td">
                                <input type="checkbox" name="cart_item_ids[]" value="<?php echo $product_id; ?>" disabled="">
                            </td>
                        <?php endif ?>
                    </tr> 
                    <?php endforeach ; ?>
                </tbody>

                <?php if ( 'top-btm-header' == $table_header ) : ?>
                <tfoot>
                    <tr>  
                        <?php $this->render_table_heading(); ?>
                    </tr> 
                </tfoot>
                <?php endif;

                else: 

                    echo '<h4>' . __( 'Wish list is empty !!', 'woolementor-pro' ) . '</h4>';

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
                            
                            printf( '<a class="button multiselect-view-cart" href="%s" >%s</a>',
                                esc_url( wc_get_cart_url() ),
                                __( 'View Cart', 'woolementor-pro' )
                            );
                        ?>
                    </div>
                    </form>
                <?php endif; ?>

            </div>

        <?php 
        /**
         * Load Script
         */
        $this->render_script();

        else: ?>
            <div class="wl-wlst-empty-notice">
                <h3><?php _e( 'Wish list is empty !', 'woolementor-pro' ); ?></h3>
            </div>
        <?php endif; 
	}

    private function render_editing_attributes() {
        $settings           = $this->get_settings_for_display();
        extract( $settings );

        $id_class = '';
        if ( is_array( $id_show_hide ) && count( $id_show_hide ) > 0 ) {
            $id_class = implode( ' ', $id_show_hide );
        }

        $img_class = '';
        if ( is_array( $image_show_hide ) && count( $image_show_hide ) > 0 ) {
            $img_class = implode( ' ', $image_show_hide );
        }

        $title_class = '';
        if ( is_array( $title_show_hide ) && count( $title_show_hide ) > 0 ) {
            $title_class = implode( ' ', $title_show_hide );
        }

        $category_class = '';
        if ( is_array( $category_show_hide ) && count( $category_show_hide ) > 0 ) {
            $category_class = implode( ' ', $category_show_hide );
        }

        $desc_class = '';
        if ( is_array( $short_desc_show_hide ) && count( $short_desc_show_hide ) > 0 ) {
            $desc_class = implode( ' ', $short_desc_show_hide );
        }

        $price_class = '';
        if ( is_array( $price_show_hide ) && count( $price_show_hide ) > 0 ) {
            $price_class = implode( ' ', $price_show_hide );
        }

        $action_class = '';
        if ( is_array( $action_show_hide ) && count( $action_show_hide ) > 0 ) {
            $action_class = implode( ' ', $action_show_hide );
        }

        $class              = 'wl-wlst-table-header';

        $this->add_inline_editing_attributes( 'id_text', 'none' );
        $this->add_render_attribute( 'id_text', 'class', $class .' '. $id_class );

        $this->add_inline_editing_attributes( 'image_text', 'none' );
        $this->add_render_attribute( 'image_text', 'class', $class .' '. $img_class );

        $this->add_inline_editing_attributes( 'title_text', 'none' );
        $this->add_render_attribute( 'title_text', 'class', $class .' '. $title_class );

        $this->add_inline_editing_attributes( 'category_text', 'none' );
        $this->add_render_attribute( 'category_text', 'class', $class .' '. $category_class );

        $this->add_inline_editing_attributes( 'short_desc_text', 'none' );
        $this->add_render_attribute( 'short_desc_text', 'class', $class .' '. $desc_class );

        $this->add_inline_editing_attributes( 'price_text', 'none' );
        $this->add_render_attribute( 'price_text', 'class', $class .' '. $price_class );

        $this->add_inline_editing_attributes( 'action_text', 'none' );
        $this->add_render_attribute( 'action_text', 'class', $class .' '. $action_class );

        $this->add_inline_editing_attributes( 'multiselect_text', 'none' );
        $this->add_render_attribute( 'multiselect_text', 'class', 'wl-st-table-header' );

        $this->add_inline_editing_attributes( 'multiselect_submit_text', 'none' );
        $this->add_render_attribute( 'multiselect_submit_text', 'class', 'multiselect-submit' );
    }

    private function render_table_heading() {
        $settings = $this->get_settings_for_display();
        extract( $settings );

        printf( '<th %s>%s</th>',
            $this->get_render_attribute_string( 'id_text' ),
            esc_html( $id_text )
        );

        printf( '<th %s>%s</th>',
            $this->get_render_attribute_string( 'image_text' ),
            esc_html( $image_text )
        );

        printf( '<th %s>%s</th>',
            $this->get_render_attribute_string( 'title_text' ),
            esc_html( $title_text )
        );

        printf( '<th %s>%s</th>',
            $this->get_render_attribute_string( 'category_text' ),
            esc_html( $category_text )
        );

        printf( '<th %s>%s</th>',
            $this->get_render_attribute_string( 'short_desc_text' ),
            esc_html( $short_desc_text )
        );

        printf( '<th %s>%s</th>',
            $this->get_render_attribute_string( 'price_text' ),
            esc_html( $price_text )
        );

        printf( '<th %s>%s</th>',
            $this->get_render_attribute_string( 'action_text' ),
            esc_html( $action_text )
        );

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
                $('.wl-wlst-data-table').DataTable();
            })
        </script>
        <?php
    }

}