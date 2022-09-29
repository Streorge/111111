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

class Email_Item_Details extends Widget_Base {

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

		/**
         * Heading
         */
        $this->start_controls_section(
            'table_heading_content',
            [
                'label' => __( 'Heading', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'     => __( 'Show Table Title', 'woolementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Show', 'woolementor-pro' ),
                'label_off' => __( 'Hide', 'woolementor-pro' ),
                'return_value' => 'yes',
                'default'   => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Heading
         */
        $this->start_controls_section(
            'section_enable_hooks',
            [
                'label' => __( 'WC Designer', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_hooks',
            [
                'label'     => __( 'Enable Hooks', 'woolementor-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Yes', 'woolementor-pro' ),
                'label_off' => __( 'No', 'woolementor-pro' ),
                'return_value' => 'yes',
                'default'   => '',
                'description' => __( 'Enabling this will allow other plugins to add actions to the available hook tags in email templates.', 'woolementor-pro' )
            ]
        );

        $this->end_controls_section();
        /**
         * Heading
         */
        $this->start_controls_section(
            'email_item_details_Heading',
            [
                'label' => __( 'Heading', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'email_item_details_Heading_size',
			[
				'label' => __( 'Font Size', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size'  => 24
                ],
				'selectors' => [
					'{{WRAPPER}} .wl-email-item-details h2' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'email_item_details_Heading_alignment',
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
                    '{{WRAPPER}} .wl-email-item-details h2' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'email_item_details_Heading_text_color',
            [
                'label'     => __( 'Text Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-details h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'email_item_details_Heading_bg_color',
            [
                'label'     => __( 'Background Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-details h2' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'email_item_details_Heading_padding',
			[
				'label' 	=> __( 'Padding', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-email-item-details h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
			]
		);

		$this->add_control(
			'email_item_details_Heading_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-email-item-details h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

		/**
         * Table
         */
        $this->start_controls_section(
            'email_item_details_table',
            [
                'label' => __( 'Table', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
		
		$this->add_control(
			'email_item_details_table_width',
			[
				'label' => __( 'Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
				'selectors' => [
					'{{WRAPPER}} .wl-email-item-panel table' => 'width: {{SIZE}}%;',
				],
			]
		);

        $this->add_control(
            'email_item_details_table_bg_color',
            [
                'label'     => __( 'Background Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-panel table' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'email_item_details_table_border',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '{{WRAPPER}} .wl-email-item-panel table',                
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
                            'isLinked'  => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#000',
                    ],
                ],
            ]
        );

		$this->add_control(
			'email_item_details_table_margin',
			[
				'label'         => __( 'Margin', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-email-item-panel table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator' => 'before',
			]
		);

        $this->end_controls_section();

		/**
         * Table Header
         */
        $this->start_controls_section(
            'email_item_details_table_header',
            [
                'label' => __( 'Table Header', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'email_item_details_table_header_alignment',
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
                    '{{WRAPPER}} .wl-email-item-panel table thead th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'email_item_details_table_header_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-panel table thead th' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'email_item_details_table_header_bg_color',
            [
                'label'     => __( 'Background Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-panel table thead th' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'email_item_details_table_header_border',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '{{WRAPPER}} .wl-email-item-panel table thead th',
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
                            'isLinked'  => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#000',
                    ],
                ],
            ]
        );

		$this->add_control(
			'email_item_details_table_header_padding',
			[
				'label'         => __( 'Padding', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-email-item-panel table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator' => 'before',
			]
		);

        $this->end_controls_section();

		/**
         * Table Body
         */
        $this->start_controls_section(
            'email_item_details_table_body',
            [
                'label' => __( 'Table Body', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'email_item_details_table_body_alignment',
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
                    '{{WRAPPER}} .wl-email-item-panel table tbody td' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'email_item_details_table_body_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-panel table tbody td' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'email_item_details_table_body_bg_color',
            [
                'label'     => __( 'Background Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-panel table tbody td' => 'background-color: {{VALUE}}',
                ],
                'default'  => 'transparent'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'email_item_details_table_body_border',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '{{WRAPPER}} .wl-email-item-panel table tbody td',                
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
                            'isLinked'  => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#000',
                    ],
                ],
            ]
        );

		$this->add_control(
			'email_item_details_table_body_padding',
			[
				'label'         => __( 'Padding', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-email-item-panel table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator' => 'before',
			]
		);

        $this->end_controls_section();

		/**
         * Table Footer
         */
        $this->start_controls_section(
            'email_item_details_table_footer',
            [
                'label' => __( 'Table Footer', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'email_item_details_table_footer_heading',
			[
				'label' 	=> __( 'Heading', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'email_item_details_table_footer_alignment',
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
                    '{{WRAPPER}} .wl-email-item-panel table tfoot tr th' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'email_item_details_table_footer_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-panel table tfoot tr th' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'email_item_details_table_footer_bg_color',
            [
                'label'     => __( 'Background Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-panel table tfoot tr th' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
			'email_item_details_table_footer_body',
			[
				'label' 	=> __( 'Body', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'email_item_details_table_footer_body_alignment',
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
                    '{{WRAPPER}} .wl-email-item-panel table tfoot tr td' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'email_item_details_table_footer_body_color',
            [
                'label'     => __( 'Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-panel table tfoot tr td' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'email_item_details_table_footer_body_bg_color',
            [
                'label'     => __( 'Background Color', 'woolementor-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-email-item-panel table tfoot tr td' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'email_item_details_table_footer_border',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '{{WRAPPER}} .wl-email-item-panel table tfoot tr th, {{WRAPPER}} .wl-email-item-panel table tfoot tr td',
				'separator' => 'before',
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
                            'isLinked'  => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#000',
                    ],
                ],
            ]
        );

		$this->add_control(
			'email_item_details_table_footer_padding',
			[
				'label'         => __( 'Padding', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-email-item-panel table tfoot tr th,{{WRAPPER}} .wl-email-item-panel table tfoot tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

	}

	protected function render() {
		$settings 		= $this->get_active_settings();
        $order_id       = wcd_is_edit_mode() || wcd_is_preview_mode() ? wcd_get_random_order_id() : wcd_get_current_order_id();
		$order 			= wc_get_order( $order_id );

        if ( ! is_a( $order, 'WC_Order' ) ) return;

		$sent_to_admin 	= false;
		$plain_text 	= false;
		$email 			= $order->get_billing_email();

		$text_align = is_rtl() ? 'right' : 'left';
        if( isset( $settings['enable_hooks'] ) && $settings['enable_hooks'] == 'yes' ){
		  do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email );
        }
        ?>

		<div class="wl-email-item-details">
            <?php if ( $settings['show_title'] == 'yes' ): ?>
			<h2>
				<?php
				if ( $sent_to_admin ) {
					$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
					$after  = '</a>';
				} else {
					$before = '';
					$after  = '';
				}
				/* translators: %s: Order ID. */
				    echo $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) );
				?>
			</h2>
            <?php endif; ?>

			<div class="wl-email-item-panel">
				<table class="td" width="100">
					<thead>
						<tr>
							<th class="td" scope="col"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
							<th class="td" scope="col"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
							<th class="td" scope="col"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							$order,
							array(
								'show_sku'      => $sent_to_admin,
								'show_image'    => false,
								'image_size'    => array( 32, 32 ),
								'plain_text'    => $plain_text,
								'sent_to_admin' => $sent_to_admin,
							)
						);
						?>
					</tbody>
					<tfoot>
						<?php
						$item_totals = $order->get_order_item_totals();

						if ( $item_totals ) {
							$i = 0;
							foreach ( $item_totals as $total ) {
								$i++;
								?>
								<tr>
									<th class="td" scope="row" colspan="2"><?php echo esc_html( $total['label'] ); ?></th>
									<td class="td"><?php echo wp_kses_post( $total['value'] ); ?></td>
								</tr>
								<?php
							}
						}
						?>
					</tfoot>
				</table>
			</div>
		</div>

		<?php 
        if( isset( $settings['enable_hooks'] ) && $settings['enable_hooks'] == 'yes' ){
            do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email );
        }
	}
}