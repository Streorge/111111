<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Payment_Methods extends Widget_Base {

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
			'payment_section_title',
			[
				'label' => __( 'Section Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'payment_title_show',
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
		    'payment_section_title_text',
		    [
		        'label' 		=> __( 'Text', 'woolementor-pro' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Payment Methods', 'woolementor-pro' ) ,
                'condition' => [
                    'payment_title_show' => 'yes'
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
                    'payment_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'payment_title_alignment',
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
                    'payment_title_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pm-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		//section title style
		$this->start_controls_section(
			'payment_title_style',
			[
				'label' => __( 'Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'payment_title_show' => 'yes'
                ],
			]
		);

		// start default style
		$this->add_control(
			'payment_default_styles',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-pm' => 'background: #ebe9eb;',
					'.wl {{WRAPPER}} .wl-pm #payment' => 'background: transparent;',
					'.wl {{WRAPPER}} .wl-pm .woocommerce-checkout-payment ul li label' => 'display: inline;',
				],
				'default' => 'traditional',
			]
		);
		// end default css

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'payment_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-pm-title',
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
				'name' => 'payment_title_color',
				'selector' => '{{WRAPPER}} .wl-pm-title',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'payment_input_background_color',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .wl-pm-title',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'payment_title_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '{{WRAPPER}} .wl-pm-title',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'payment_title_border_radius',
			[
				'label' 	=> __( 'Border Redius', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-pm-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'payment_title_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-pm-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'payment_title_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-pm-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Input Label Color
		 */
		$this->start_controls_section(
			'_pm_footer_style',
			[
				'label' => __( 'Payment Methods', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'pm_bg_color',
			[
				'label'     => __( 'Section Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-pm #payment .wc_payment_methods.payment_methods.methods' => 'background-color: {{VALUE}}',
				],
				'default' => 'transparent'
			]
		);

		$this->start_controls_tabs('payement methods');

		$this->start_controls_tab(
		    'pm_titles',
		    [
		        'label' => __( 'Titles', 'woolementor-pro' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'pm_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-pm #payment .wc_payment_methods.payment_methods.methods .wc_payment_method label',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);


        $this->add_control(
			'pm_text_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-pm #payment .wc_payment_methods.payment_methods.methods .wc_payment_method label' => 'color: {{VALUE}}',
				],
				'default' 	=> 'var(--wl-black)'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    'pm_contents',
		    [
		        'label' => __( 'Contents', 'woolementor-pro' ),
		    ]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'pm_content_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-pm #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);


        $this->add_control(
			'pm_content_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-pm #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box' => 'color: {{VALUE}}',
				],
			]
		);

		 $this->add_control(
			'pm_content_bg_color',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-pm #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .wl-pm #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box::before' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		//section footer style
		$this->start_controls_section(
			'payment_footer_style',
			[
				'label' => __( 'Footer', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'payment_footer_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .form-row.place-order .woocommerce-privacy-policy-text p',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'pm_footer_content_color',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .form-row.place-order' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'pm_footer_content_text_color',
			[
				'label'     => __( 'Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .form-row.place-order .woocommerce-privacy-policy-text' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .form-row.place-order .woocommerce-privacy-policy-text p' => 'color: {{VALUE}}',
					// '.wl {{WRAPPER}} .form-row.place-order .woocommerce-privacy-policy-text a' => 'color: {{VALUE}}',
				],
				'default' 	=> 'var(--wl-black)'
			]
		);

		$this->add_control(
			'pm_footer_content_href_color',
			[
				'label'     => __( 'Hyperlink Text Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .form-row.place-order .woocommerce-privacy-policy-text a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		//section button style
		$this->start_controls_section(
			'payment_btn_style',
			[
				'label' => __( 'Order Button', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'payment_btn_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .form-row.place-order .woocommerce-terms-and-conditions-wrapper button',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'pm_btn_padding',
			[
				'label'         => __( 'Padding', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} #payment .form-row.place-order #place_order' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pm_btn_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} #payment .form-row.place-order #place_order' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'pm_btn_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'pm_btn_normal',
			[
				'label'     => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'pm_btn_text_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row.place-order #place_order' => 'color: {{VALUE}}',
				],
				'default' => '#fff'
			]
		);

		$this->add_control(
			'pm_btn_color',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row.place-order #place_order' => 'background-color: {{VALUE}}',
				],
				'default' => 'var(--wl-black)'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pm_btn_border',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} #payment .form-row.place-order #place_order',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' 		=> [
							'top' 		=> '1',
							'right' 	=> '1',
							'bottom' 	=> '1',
							'left' 		=> '1',
							'isLinked' 	=> false,
						],
					],
					'color' => [
						'default' => 'var(--wl-black)',
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pm_btn_hover',
			[
				'label'     => __( 'Hover', 'woolementor-pro' ),
			]
		);
		
		$this->add_control(
			'pm_btn_text_color_hover',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row.place-order #place_order:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pm_btn_color_hover',
			[
				'label'     => __( 'Background', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row.place-order #place_order:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pm_btn_border_hover',
				'label'         => __( 'Border', 'woolementor-pro' ),
				'selector'      => '{{WRAPPER}} #payment .form-row.place-order #place_order:hover',
			]
		);

        $this->add_control(
            'pm_btn_border_hover_transition',
            [
                'label' 	=> __( 'Transition Duration', 'woolementor-pro' ),
                'type' 		=> Controls_Manager::SLIDER,
                'range' 	=> [
                    'px' 	=> [
                        'max' 	=> 3,
                        'step' 	=> 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} #payment .form-row.place-order #place_order:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
		if ( ! function_exists( 'is_checkout' ) || ( is_checkout() && ! empty( is_wc_endpoint_url( 'order-received' ) ) ) ) return;
		
		$settings = $this->get_settings_for_display();
		// extract( $settings );

		/**
		 * Load attributes
		 */
		$this->render_editing_attributes();

		if( wcd_is_edit_mode() ) {
			wc_load_cart();
			wc()->frontend_includes();
			?>
			<style type="text/css">.woocommerce-checkout #payment div.form-row{padding-bottom:2em}.wl .button{padding:8px;margin-top:-20px}</style>
			<?php
		}

		/**
		 * We need to force payment options to show up in the edit screen
		 */
		add_filter( 'woocommerce_cart_needs_payment', function( $needs_payment, $cart ){
			if( wcd_is_edit_mode() ) {
				return true;
			}
			return $needs_payment;
		}, 10, 2 );

		if( 'yes' == $settings['payment_title_show'] ):

			printf( '<%1$s %2$s>%3$s</%1$s>',
				esc_attr( $settings['payment_title_tag'] ),
				$this->get_render_attribute_string( 'payment_section_title_text' ),
				esc_html( $settings['payment_section_title_text'] )
			);

		endif;

		echo wcd_notice( sprintf( __( 'Are you facing any issues with the checkout page? Please <a href="%s", target="_blank">click here and follow the instruction</a> to get things ready!', 'woolementor-pro' ), 'https://help.codexpert.io/docs/woolementor/my-checkout-page-isnt-working/' ), '<i class="eicon-warning"></i> ' . __( 'Problem with checkout?', 'woolementor-pro' ) );

		$order_button_text = __( 'Place order', 'woocommerce' );

		echo '<div class="wl-pm">';
		wc_get_template( 'checkout/payment.php', [ 'available_gateways' => WC()->payment_gateways->get_available_payment_gateways(), 'order_button_text' => apply_filters( 'woocommerce_order_button_text', $order_button_text ) ] );
		echo '</div>';

		/**
		 * Load Script
		 */
		$this->render_script();
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'payment_section_title_text', 'none' );
		$this->add_render_attribute( 'payment_section_title_text', 'class', 'wl-pm-title' );
	}

	protected function render_script() {
		?>
		<script type="text/javascript">
			jQuery(function($){
				$('#billing_country').change();
			})
		</script>
		<?php
	}
}

