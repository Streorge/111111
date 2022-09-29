<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Responsive\Responsive;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Email_Customer_Note extends Widget_Base {

	public $id;
	protected $nav_menu_index = 1;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_PRO_DEBUG' ) && WOOLEMENTOR_PRO_DEBUG ? '' : '.min';
		// wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
		// wp_register_script( "woolementor-{$this->id}", plugins_url( "assets/js/script{$min}.js", __FILE__ ), ['jquery'], '1.1', true );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}", "woolementor-{$this->id}-smartmenus" ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", "woolementor-{$this->id}-sm-blue" ];
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

	protected function get_nav_menu_index() {
		return $this->nav_menu_index++;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'email_customer_note_style',
			[
				'label' => __( 'Content', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'email_customer_note_size',
			[
				'label' => __( 'Font Size', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wl-email-customer-note p' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'email_customer_note_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-email-customer-note p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'email_customer_note_background',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-email-customer-note p' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'email_customer_note_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-email-customer-note p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
			]
		);

		$this->add_control(
			'email_customer_note_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-email-customer-note p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings 		= $this->get_active_settings();
		$order_id 		= wcd_is_edit_mode() || wcd_is_preview_mode() ? wcd_get_random_order_id() : wcd_get_current_order_id();
		$order 			= wc_get_order( $order_id );

		if ( ! is_a( $order, 'WC_Order' ) ) return;

		$text_align = is_rtl() ? 'right' : 'left';

		if ( $order->get_customer_note() ) {
			?>
			<div class="wl-email-customer-note">
				<p>
					<?php 
					echo '<span>'. __( 'Note:', 'woocommerce' ) .'</span>';
					echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) );
					?>
				</p>
			</div>
			<?php
		}
		elseif ( wcd_is_edit_mode() || wcd_is_preview_mode() ) {
			?>
			<div class="wl-email-customer-note">
				<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fuga, soluta, placeat saepe ab eos vitae accusantium quasi ea asperiores qui dicta maxime sunt quos praesentium at neque nisi, hic, numquam!</p>
			</div>
			<?php
		}
	}
}