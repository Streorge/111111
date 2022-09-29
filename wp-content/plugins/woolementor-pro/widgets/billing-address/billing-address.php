<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Billing_Address extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [];
	}

	public function get_style_depends() {
		return [];
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
			'shipping_title',
			[
				'label' => __( 'Section Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'billing_title_show',
            [
                'label'         => __( 'Show/Hide Title', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
		$this->add_control(
		    'billing_title_text',
		    [
		        'label' 		=> __( 'Text', 'woolementor-pro' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Billing Address', 'woolementor-pro' ) ,
                'condition' 	=> [
                    'billing_title_show' => 'yes'
                ],
		        'dynamic' 		=> [
		            'active' 		=> true,
		        ]
		    ]
		);

		$this->add_control(
			'payment_title_tag',
			[
				'label' 	=> __( 'HTML Tag', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'h3',
				'options' 	=> [
					'h1'  => __( 'H1', 'woolementor-pro' ),
					'h2'  => __( 'H2', 'woolementor-pro' ),
					'h3'  => __( 'H3', 'woolementor-pro' ),
					'h4'  => __( 'H4', 'woolementor-pro' ),
					'h5'  => __( 'H5', 'woolementor-pro' ),
					'h6'  => __( 'H6', 'woolementor-pro' ),
				],
                'condition' => [
                    'billing_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'billing_title_alignment',
            [
                'label' 	   => __( 'Alignment', 'woolementor-pro' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
                    'left' 		=> [
                        'title' 	=> __( 'Left', 'woolementor-pro' ),
                        'icon' 		=> 'eicon-text-align-left',
                    ],
                    'center' 	=> [
                        'title' 	=> __( 'Center', 'woolementor-pro' ),
                        'icon' 		=> 'eicon-text-align-center',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'woolementor-pro' ),
                        'icon' 		=> 'eicon-text-align-right',
                    ],
                ],
                'default' 	=> 'left',
                'toggle' 	=> true,
                'condition' => [
                    'billing_title_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-billing-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Billing Fields', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();


		$repeater->add_control(
			'billing_input_label', [
				'label' => __( 'Input Label', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'New Section' , 'woolementor-pro' ),
				'label_block' => true,
				'separator' => 'after',
			]
		);

		$repeater->add_control(
			'billing_input_class', [
				'label' => __( 'Class Name', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'form-row-wide',
				'options' => [
					'form-row-first' => 'form-row-first',
					'form-row-last' => 'form-row-last',
					'form-row-wide' => 'form-row-wide',
				],
			]
		);

		$repeater->add_control(
			'billing_input_type', [
				'label' => __( 'Input Type', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT2,
				'default' => 'text',
				'options' => [
					'textarea'			=> __( 'Textarea', 'woolementor-pro' ),
					'checkbox'			=> __( 'Checkbox', 'woolementor-pro' ),
					'text'				=> __( 'Text', 'woolementor-pro' ),
					'password'			=> __( 'Password', 'woolementor-pro' ),
					'date'				=> __( 'Date', 'woolementor-pro' ),
					'number'			=> __( 'Number', 'woolementor-pro' ),
					'email'				=> __( 'Email', 'woolementor-pro' ),
					'url'				=> __( 'Url', 'woolementor-pro' ),
					'tel'				=> __( 'Tel', 'woolementor-pro' ),
					'select'			=> __( 'Select', 'woolementor-pro' ),
					'radio'				=> __( 'Radio', 'woolementor-pro' ),
				],
			]
		);

		$repeater->add_control(
			'billing_input_options', [
				'label' => __( 'Options', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => implode( PHP_EOL, [ __( 'Option 1', 'woolementor-pro' ), __( 'Option 2', 'woolementor-pro' ), __( 'Option 3', 'woolementor' ) ] ),
				'label_block' => true,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'billing_input_type',
							'operator' => '==',
							'value' => 'select',
						],
						[
							'name' => 'billing_input_type',
							'operator' => '==',
							'value' => 'radio',
						],
					],
				],
			]
		);

		$random_id = rand( 111, 999 );

		$repeater->add_control(
			'billing_input_name', [
				'label' => __( 'Field Name', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'name_' . $random_id,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'billing_input_placeholder', [
				'label' => __( 'Placeholder', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Placeholder' , 'woolementor-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'billing_input_autocomplete', [
				'label' => __( 'Autocomplete Value', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Given value' , 'woolementor-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'billing_show_in_mail', [
				'label' 		=> __( 'Show in Email', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'disable',
				'options' 		=> [ 'disable' => __( 'Disable', 'woolementor-pro' ) ] + wcd_get_wc_email_hooks(),
				'label_block' 	=> true,
				'conditions' 	=> [
					'terms' => [
						[
							'name' => 'billing_input_name',
							'operator' => '!in',
							'value' => wcd_wc_fields( 'billing' ),
						],
					],
				],
			]
		);
		
		$repeater->add_control(
			'billing_show_in_thankyou', [
				'label' 		=> __( 'Show on Thankyou Page', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'disable',
				'options' 		=> [ 'disable' => __( 'Disable', 'woolementor-pro' ) ] + wcd_get_wc_thankyou_hooks(),
				'label_block' 	=> true,
				'conditions' 	=> [
					'terms' => [
						[
							'name' => 'billing_input_name',
							'operator' => '!in',
							'value' => wcd_wc_fields( 'billing' ),
						],
					],
				],
			]
		);

		$repeater->add_control(
			'billing_show_in_editpage', [
				'label' 		=> __( 'Show on Order Edit Page', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'disable',
				'options' 		=> [ 'disable' => __( 'Disable', 'woolementor-pro' ) ] + wcd_get_wc_edit_order_hooks(),
				'label_block' 	=> true,
				'conditions' 	=> [
					'terms' => [
						[
							'name' => 'billing_input_name',
							'operator' => '!in',
							'value' => wcd_wc_fields( 'billing' ),
						],
					],
				],
			]
		);

		$repeater->add_control(
			'billing_input_required',
			[
				'label'         => __( 'Required', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'yes', 'woolementor-pro' ),
				'label_off'     => __( 'no', 'woolementor-pro' ),
				'return_value'  => true,
				'default'       => true,
			]
		);

		$this->add_control(
			'billing_form_items',
			[
				'label' => __( '', 'woolementor-pro' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => wcd_checkout_fields(),
				'title_field' => '{{{ billing_input_label }}}',
			]
		);

		$this->end_controls_section();

		//section title style
		$this->start_controls_section(
			'billing_title_style',
			[
				'label' => __( 'Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'billing_title_show' => 'yes'
                ],
			]
		);

		// start default style
		$this->add_control(
			'billing_default_styles',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-billing p label' 	=> 'display: block',
					'.wl {{WRAPPER}} .form-row-first' 		=> 'width: 48%;float: left;margin-right:0',
					'.wl {{WRAPPER}} .form-row-last' 		=> 'width: 48%;float: right;',
					'.wl {{WRAPPER}} .form-row-wide' 		=> 'clear: both;',
					'.rtl.wl {{WRAPPER}} .form-row-first' 	=> 'width: 48%;float: right;margin-right: 0px;margin-left: 0px;',
					'.rtl.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="radio"]' => 'margin-left: 10px;margin-right: 1px;',

					'.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="text"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="password"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="datetime"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="datetime-local"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="date"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="month"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="time"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="week"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="number"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="email"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="url"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper input[type="tel"],
					.wl {{WRAPPER}} .wl-billing .woocommerce-input-wrapper select' => 'width: 100%',
				],
				'default' => 'traditional',
			]
		);
		// end default css

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 				=> 'billing_title_typographyrs',
				'label' 			=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 			=> Typography::TYPOGRAPHY_3,
				'selector' 			=> '{{WRAPPER}} .wl-billing-title',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 22 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'billing_title_color',
				'selector' 	=> '{{WRAPPER}} .wl-billing-title',
				'fields_options' => [
					'color' => [ 'default' => 'var(--wl-black)' ], 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'billing_input_background_color',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .wl-billing-title',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'billing_title_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .wl-billing-title',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'billing_title_border_radius',
			[
				'label' 	=> __( 'Border Redius', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-billing-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'billing_title_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-billing-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'billing_title_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-billing-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Input Label Color
		 */
		$this->start_controls_section(
			'billing_style',
			[
				'label' 	=> __( 'Labels', 'woolementor-pro' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'billing_label_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-billing label',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 15 ] ],
					'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);


        $this->add_control(
			'billing_label_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-billing label' => 'color: {{VALUE}}',
				],
				'default' => 'var(--wl-black)'
			]
		);

        $this->add_control(
        	'billing_label_padding',
        	[
        		'label' => __( 'Padding', 'woolementor-pro' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-billing label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->add_control(
			'billing_label_line_hight',
			[
				'label' => __( 'Line Height', 'woolementor-pro' ),
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
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-billing label' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Input Color
		 */
		$this->start_controls_section(
			'billing_input_style',
			[
				'label' => __( 'Input Fields', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'billing_input_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
				'selector' => '
					{{WRAPPER}} .wl-billing input, 
					{{WRAPPER}} .wl-billing select, 
					{{WRAPPER}} .wl-billing option,
					{{WRAPPER}} .wl-billing textarea',
			]
		);

		$this->add_control(
			'billing_input_color',
			[
				'label'     => __( 'Input Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-billing input, 
					 {{WRAPPER}} .wl-billing select, 
					 {{WRAPPER}} .wl-billing option,
					 {{WRAPPER}} .wl-billing textarea' => 'color: {{VALUE}}',
				],
				'default' => 'var(--wl-gray)'
			]
		);

		$this->add_control(
			'billing_input_background_color',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-billing input, 
					 {{WRAPPER}} .wl-billing select, 
					 {{WRAPPER}} .wl-billing option,
					 {{WRAPPER}} .wl-billing .select2-container .select2-selection--single,
					 {{WRAPPER}} .wl-billing textarea' => 'background-color: {{VALUE}}',
				],
				// 'default' => 'var(--wl-black)'
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 				=> 'billing_input_border',
				'label' 			=> __( 'Border', 'woolementor-pro' ),
				'separator' 		=> 'before',
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
				'selector' => '
					.wl {{WRAPPER}} .wl-billing input, 
					.wl {{WRAPPER}} .wl-billing span select,
					.wl {{WRAPPER}} .wl-billing .select2-container .select2-selection--single,
					.wl {{WRAPPER}} .wl-billing textarea',
			]
		);

        $this->add_control(
			'billing_input_border_radius',
			[
				'label' => __( 'Border Redius', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-billing input, 
					 {{WRAPPER}} .wl-billing select,
					 {{WRAPPER}} .wl-billing textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'billing_input_padding',
			[
				'label' => __( 'Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-billing input, 
					 {{WRAPPER}} .wl-billing select,
					 {{WRAPPER}} .wl-billing textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		if ( ! function_exists( 'is_checkout' ) || ( is_checkout() && !empty( is_wc_endpoint_url('order-received') ) ) ) return;
		
		$settings = $this->get_settings_for_display();

		$this->render_editing_attributes();

		/**
		 * Store fields in the options table to regenerate with a filter hook
		 *
		 * @TODO: maybe store somewhere else
		 */
		if( wcd_is_edit_mode() ) {
			$_wcd_checkout_fields = get_option( '_wcd_checkout_fields', [] );
			$_wcd_checkout_fields['billing'] = $settings['billing_form_items'];
			update_option( '_wcd_checkout_fields', $_wcd_checkout_fields );
		}

		$billing_fields = [];
		foreach( $settings['billing_form_items'] as $item ) {	
			$billing_fields[ sanitize_text_field( $item['billing_input_name'] ) ] = 
	        [
	            'label'			=> sanitize_text_field( $item['billing_input_label'] ),
	            'type'			=> sanitize_text_field( $item['billing_input_type'] ),
	            'required'		=> $item['billing_input_required'] == 'true' ? true : false,
	            'class'			=> is_array( $item['billing_input_class'] ) ? $item['billing_input_class'] : explode( ' ', $item['billing_input_class'] ),
	            'autocomplete'	=> sanitize_text_field( $item['billing_input_autocomplete'] ), 
	            'placeholder'	=> sanitize_text_field( $item['billing_input_placeholder'] ),
	            'priority'		=> 10,
	        ];

	        if ( isset( $item['billing_input_options'] ) ) {
	        	$options = explode( PHP_EOL, $item['billing_input_options'] );
	        	$new_options = [];
	        	foreach ( $options as $option ) {
	        		$new_options[ strtolower( $option ) ] = $option;
	        	}
	        	$billing_fields[ sanitize_text_field( $item['billing_input_name'] ) ]['options'] = $new_options;
	        }
		}
		
		if( 'yes' == $settings['billing_title_show'] ): 

			printf( '<%1$s %2$s>%3$s</%1$s>',
				esc_attr( $settings['payment_title_tag'] ),
				$this->get_render_attribute_string( 'billing_title_text' ),
				esc_html( $settings['billing_title_text'] )
			);
			
		endif; 
		?>

		<div class="wl-billing">
			<?php
			foreach ( $billing_fields as $key => $field ) {
				woocommerce_form_field( $key, $field, WC()->checkout->get_value( $key ) );
			}
		?>
		</div>

		<?php 
		$checkout = new \WC_Checkout;
		if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
			<div class="woocommerce-account-fields">
				<?php if ( ! $checkout->is_registration_required() ) : ?>

					<p class="form-row form-row-wide create-account">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
						</label>
					</p>

				<?php endif;

				do_action( 'woocommerce_before_checkout_registration_form', $checkout );

				if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

					<div class="create-account">
						<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
							<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
						<?php endforeach; ?>
						<div class="clear"></div>
					</div>

				<?php endif;

				do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
			</div>
		<?php endif;

        /**
         * Load Script
         */
        $this->render_script();
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'billing_title_text', 'none' );
		$this->add_render_attribute( 'billing_title_text', 'class', 'wl-billing-title' );
	}

    protected function render_script() {
        ?>
        <script type="text/javascript">
            jQuery(function($){
            	$('.elementor-button.elementor-button-default.elementor-repeater-add').click(function(e){
            		e.preventDefault()
               		alert()
            	})
            })
        </script>
        <?php
    }
}

