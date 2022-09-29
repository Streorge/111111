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

class Email_Order_Note extends Widget_Base {

	public $id;
	protected $nav_menu_index = 1;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_PRO_DEBUG' ) && WOOLEMENTOR_PRO_DEBUG ? '' : '.min';
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
			'email_order_note_content',
			[
				'label' => __( 'Content', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$placeholders = [ '%%order_id%%', '%%billing_first_name%%', '%%billing_last_name%%', '%%shipping_first_name%%', '%%shipping_last_name%%' ];
		$this->add_control(
			'welcom_text_note',
			[
				'label' => __( 'Important Note', 'plugin-name' ),
				'type' 	=> Controls_Manager::RAW_HTML,
				'raw' 	=> sprintf( __( 'You can use the placeholders. %s. This will replace with actual order data.', 'woolementor-pro' ), "<code>" . implode( '</code> <code>' ,$placeholders ) . "</code>" ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			]
		);

		$this->add_control(
			'intro_message',
			[
				'label' 		=> __( 'Intro Message', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::WYSIWYG,
				'default' 		=> sprintf( __( '<%1$s> Hi %2$s, </%1$s><%1$s> The following note has been added to your order:</%1s>', 'woolementor-pro' ), 'p', '%%billing_first_name%%' ),
				'placeholder' 	=> __( 'Type your description here', 'woolementor-pro' ),
				'label_block' 	=> true
			]
		);

		$this->end_controls_section();

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

		$_order_notes = wc_get_order_notes( [ 'order_id' => $order_id ] );
		$notes = [];
		foreach ($_order_notes as $key => $note ) {
			if ( $note->customer_note ) {
				$notes[ $note->id ] = $note->content;
			}
		}

		$targets    = [ '%%order_id%%', '%%billing_first_name%%', '%%billing_last_name%%', '%%shipping_first_name%%', '%%shipping_last_name%%' ];
		$replace 	= [ $order->get_id(), $order->get_billing_first_name(), $order->get_billing_last_name(), $order->get_shipping_first_name(), $order->get_shipping_last_name() ];
		$intro_message 	= str_replace( $targets, $replace, $settings['intro_message'] );

		echo "<div class='wl-email-customer-note'>".wp_kses_post( wpautop( $intro_message ) );

		if ( !empty( $notes ) ) {
			$latest_note = $notes[ max( array_keys( $notes ) ) ];
			echo "<blockquote>" . esc_html( wpautop( wptexturize( make_clickable( $latest_note ) ) ) ) . "</blockquote>";
		}
		elseif ( wcd_is_edit_mode() || wcd_is_preview_mode() ) {
			echo "<blockquote>" . esc_html( 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fuga, soluta, placeat saepe ab eos vitae accusantium quasi ea asperiores qui dicta maxime sunt quos praesentium at neque nisi, hic, numquam!' ) ."</blockquote>";
		}

		echo "</div>";
	}
}