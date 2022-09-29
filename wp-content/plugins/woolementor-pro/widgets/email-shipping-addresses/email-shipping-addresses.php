<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Responsive\Responsive;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Email_Shipping_Addresses extends Widget_Base {

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
			'email_shipping_title',
			[
				'label' => __( 'Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'email_shipping_title_show',
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
		    'email_shipping_title_text',
		    [
		        'label' 		=> __( 'Text', 'woolementor-pro' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Shipping Address', 'woolementor-pro' ) ,
                'condition' 	=> [
                    'email_shipping_title_show' => 'yes'
                ],
		        'dynamic' 		=> [
		            'active' 		=> true,
		        ]
		    ]
		);

		$this->add_control(
			'email_shipping_title_tag',
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
                    'email_shipping_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'email_shipping_title_alignment',
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
                    'email_shipping_title_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-email-shipping-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'email_shipping_address',
			[
				'label' => __( 'Address', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'email_shipping_address_alignment',
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
                'selectors' => [
                    '{{WRAPPER}} .wl-email-shipping-address-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'email_shipping_title_style',
			[
				'label' => __( 'Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'email_shipping_title_show' => 'yes'
                ],
			]
		);
		$this->add_control(
			'email_shipping_title_size',
			[
				'label' => __( 'Font Size', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wl-email-shipping-title' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'email_shipping_title_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-email-shipping-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'email_shipping_title_background',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-email-shipping-title' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'email_shipping_title_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-email-shipping-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
			]
		);

		$this->add_control(
			'email_shipping_title_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-email-shipping-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'email_shipping_address_style',
			[
				'label' => __( 'Address', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'email_shipping_address_size',
			[
				'label' => __( 'Font Size', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wl-email-shipping-address-content' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'email_shipping_address_color',
			[
				'label'     => __( 'Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '#000',
				'selectors' => [
					'{{WRAPPER}} .wl-email-shipping-address-content' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-email-shipping-address-content a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'email_shipping_address_background',
			[
				'label'     => __( 'Background Color', 'woolementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-email-shipping-address-content' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'email_shipping_address_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-email-shipping-address-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
			]
		);

		$this->add_control(
			'email_shipping_address_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-email-shipping-address-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings 	= $this->get_active_settings();
		$order_id 	= wcd_is_edit_mode() || wcd_is_preview_mode() ? wcd_get_random_order_id() : wcd_get_current_order_id();
		$order 		= wc_get_order( $order_id );

		if ( ! is_a( $order, 'WC_Order' ) ) return;

		extract( $settings );

		$shipping   = $order->get_formatted_shipping_address();

		if ( !$shipping && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
			$shipping = $order->get_formatted_billing_address();
		}

        $this->add_render_attribute( 'email_shipping_title_text', 'class', 'wl-email-shipping-title' );
        $this->add_render_attribute( 'email_shipping_address_style', 'class', 'address wl-email-shipping-address-content' );

		if ( ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && $shipping ) || wcd_is_edit_mode() || wcd_is_preview_mode() ) :
			?>
			<div class="wl-email-shipping-address">
				<?php 
					if( 'yes' == $email_shipping_title_show ): 

					printf( '<%1$s %2$s>%3$s</%1$s>',
						esc_attr( $email_shipping_title_tag ),
						$this->get_render_attribute_string( 'email_shipping_title_text' ),
						esc_html( $email_shipping_title_text )
					);
					
				endif;
				?>
				<address <?php echo $this->get_render_attribute_string( 'email_shipping_address_style' ); ?>>
					<?php echo wp_kses_post( $shipping ); ?>
				<?php if ( $order->get_shipping_phone() ) : ?>
					<br /><?php echo esc_html( wc_make_phone_clickable( $order->get_shipping_phone() ) ); ?>
				<?php endif; ?>
				</address>
			</div>
		<?php 
		endif;
	}
}