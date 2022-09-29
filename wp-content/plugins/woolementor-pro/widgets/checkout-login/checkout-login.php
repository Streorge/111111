<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Checkout_Login extends Widget_Base {

	public $id;
	protected $form_close='';

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}" ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}" ];
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
			'form-content',
			[
				'label' => __( 'Form Content', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'form_collapse',
			[
				'label' => __( 'Show Toggle Text', 'woolementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'woolementor-pro' ),
				'label_off' => __( 'No', 'woolementor-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'form_collapse_label',
			[
				'label' => __( 'Instruction Text', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Already have an account? Click to login.' ),
				'condition' => [
                    'form_collapse' => 'yes'
                ],
			]
		);

		$this->end_controls_section();


		//section title style
		$this->start_controls_section(
			'form_label_style',
			[
				'label' => __( 'Toggle Text	', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'form_label_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .wl-form-collapse',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'form_label_color',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .wl-form-collapse',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'form_label_background',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .wl-form-collapse',
			]
		);

		$this->add_control(
			'form_label_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-checkout-login .wl-form-collapse' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'form_label_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .wl-form-collapse',
			]
		);

		$this->add_control(
			'form_label_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login .wl-form-collapse' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		*Form styling
		*/
		$this->start_controls_section(
			'login_form',
			[
				'label' => __( 'Form', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		// start default style
		$this->add_control(
			'checkout_login_default_styles',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit' => 'background: var(--wl-black)',
					'.wl {{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit' => 'padding: .5rem 1rem;margin-top: 10px;width: 150px;',
					'.wl {{WRAPPER}} .wl-checkout-login .wl-form-collapse' => 'cursor: pointer;',
					'.wl {{WRAPPER}} .wl-checkout-login p label' => 'margin-bottom: 5px;',
					'.wl {{WRAPPER}} .wl-checkout-login .form-row-first,
					.wl {{WRAPPER}} .wl-checkout-login .form-row-last' => 'width: 100%;',
				],
				'default' => 'traditional',
			]
		);
		// end default css

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'login_form_background',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login  form',
			]
		);

		$this->add_control(
			'form_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login  form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'form_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form',
			]
		);

		$this->add_control(
			'form_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		*Input fields Labels
		*/
		$this->start_controls_section(
			'form_input_labels',
			[
				'label' => __( 'Form Input Labels', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'form_input_labels_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form label',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'form_input_labels_text_color',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form label',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'input_labels_background',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form label',
			]
		);

		$this->add_control(
			'form_input_labels_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'before',
				'selectors' 	=> [
					'{{WRAPPER}} .wl-checkout-login form label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_input_labels_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-checkout-login form label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'active_menu_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form label',
			]
		);

		$this->end_controls_section();

		/*
		*Input fields
		*/
		$this->start_controls_section(
			'form_input_fields',
			[
				'label' => __( 'Form Input Fields', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'form_input_fields_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form input',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'form_input_fields_text_color',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form input',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'input_fields_background',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form input',
			]
		);

		$this->add_control(
			'form_input_fields_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'before',
				'selectors' 	=> [
					'{{WRAPPER}} .wl-checkout-login form input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_input_fields_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-checkout-login form input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'input_fields_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
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
						'default' => '#ccc',
					],
				],
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form input',
			]
		);

		$this->add_control(
			'input_fields_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login form input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		*Button 
		*/
		$this->start_controls_section(
			'button_style',
			[
				'label' => __( 'Button', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'form_button_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->start_controls_tabs(
			'form-button',
			[
				'separator' => 'before',
			]
		);

		$this->start_controls_tab(
			'form-button-normal',
			[
				'label' => __( 'Normal', 'woolementor' )
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'form_button_color',
				'selector' 	=> '.wl {{WRAPPER}} .wl-checkout-login button.woocommerce-form-login__submit',
				'fields_options' => [
					'color' => [ 'default' => '#fff' ], 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'form_button_background',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '.wl {{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'form_button_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
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
				'selector' 	=> '.wl {{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit',
			]
		);

		$this->add_control(
			'form_button_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'form-button-hover',
			[
				'label' => __( 'Hover', 'woolementor-pro' )
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'form_button_color_hover',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login button.woocommerce-form-login__submit:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'form_button_background_hover',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'form_button_border_hover',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'separator' => 'before',
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
						'default' => '#ccc',
					],
				],
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit:hover',
			]
		);

		$this->add_control(
			'form_button_border_raidus_hover',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->end_controls_tabs();
		
		$this->end_controls_section();

		/*
		*Lost Password
		*/
		$this->start_controls_section(
			'lost_pass_style',
			[
				'label' => __( 'Lost Password Link', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'lost_pass_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .lost_password a',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'lost_pass_color',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .lost_password a',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$enabled = get_option( 'woocommerce_enable_checkout_login_reminder' ) == 'yes';

		if( wcd_is_live_mode() && ( is_user_logged_in() || !$enabled || is_order_received_page() ) ) return;

		$settings = $this->get_settings_for_display();
		extract( $settings );

		/**
		 * Load attributes
		 */
		$this->render_editing_attributes();
		?>

		<div class="wl-checkout-login">
			<?php if( 'yes' == $form_collapse ): ?>
				<p class="wl-form-collapse-p">

					<?php 
						printf( '<span %s>%s</span>',
							$this->get_render_attribute_string( 'form_collapse_label' ),
							sanitize_text_field( $form_collapse_label )
						);
					?>

				</p>
			<?php endif; ?>
			<form class="woocommerce-form woocommerce-form-login login" method="post" style="display:<?php echo ( $form_collapse == 'yes' ) ? 'none' : 'block'; ?>;">

				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<p class="form-row form-row-first">
					<label for="username"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="username" autocomplete="username" />
				</p>
				<p class="form-row form-row-last">
					<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input class="input-text" type="password" name="password" id="password" autocomplete="current-password" />
				</p>
				<div class="clear"></div>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<p class="form-row">
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
					</label>
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<input type="hidden" name="redirect" value="<?php get_permalink(); ?>" />
					<button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>"><?php esc_html_e( 'Login', 'woocommerce' ); ?></button>
				</p>
				<p class="lost_password">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
				</p>

				<div class="clear"></div>

				<?php do_action( 'woocommerce_login_form_end' ); ?>

			</form>
		</div>
		
		<?php
		/**
		 * Load Script
		 */
		$this->render_script();

	}

	protected function render_script() {
		?>
		<script type="text/javascript">
			jQuery( function ($) {
				$('.wl-form-collapse').on( 'click', function(){
					$('.woocommerce-form.woocommerce-form-login').slideToggle()
				} )
			} )
		</script>
		<?php
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'form_collapse_label' );
		$this->add_render_attribute( 'form_collapse_label', 'class', 'wl-form-collapse' );
	}
}

