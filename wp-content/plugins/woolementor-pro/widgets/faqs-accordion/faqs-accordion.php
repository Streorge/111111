<?php
namespace Codexpert\Woolementor_Pro;

use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Faqs_Accordion extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_PRO_DEBUG' ) && WOOLEMENTOR_PRO_DEBUG ? '' : '.min';

	    wp_enqueue_script( 'jquery-ui-accordion' );
		wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}", 'fancybox' ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", 'fancybox' ];
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
			'content_section',
			[
				'label' => __( 'Content', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'open_first_item',
			[
				'label' 		=> __( 'Open First Item by Default', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'On', 'woolementor-pro' ),
				'label_off' 	=> __( 'Off', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'faqs_title', [
				'label' => __( 'Title', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'New FAQ' , 'woolementor-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'faqs_content', [
				'label' => __( 'Content', 'woolementor-pro' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit nim id est laborum.' , 'woolementor-pro' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Repeater List', 'woolementor-pro' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'faqs_title' => __( 'FAQ #1', 'woolementor-pro' ),
						'faqs_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit nim id est laborum.', 'woolementor-pro' ),
					],
					[
						'faqs_title' => __( 'FAQ #2', 'woolementor-pro' ),
						'faqs_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit nim id est laborum.', 'woolementor-pro' ),
					],
					[
						'faqs_title' => __( 'FAQ #3', 'woolementor-pro' ),
						'faqs_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit nim id est laborum.', 'woolementor-pro' ),
					],
					[
						'faqs_title' => __( 'FAQ #4', 'woolementor-pro' ),
						'faqs_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit nim id est laborum.', 'woolementor-pro' ),
					],
				],
				'title_field' => '{{{ faqs_title }}}',
			]
		);

		$this->end_controls_section();

		/**
		 * Accordion
		 */
		$this->start_controls_section(
            'single_accordion',
            [
                'label' => __( 'Accordion', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // start default style
        $this->add_control(
            'faq_accordion__default_styles',
            [
                'label'     => __( 'Display', 'woolementor-pro' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-faqa-single-accordion' => 'position: relative;',
                ],
                'default' => 'traditional',
            ]
        );
        // end default css

        $this->add_responsive_control(
            'single_accordion_height',
            [
                'label'     => __( 'Accordion Height', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-faqa-accordion-title' => 'height: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-faqa-accordion-title span' => 'height: {{SIZE}}{{UNIT}}',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
            ]
        );

		$this->add_control(
			'space',
			[
				'label' => __( 'Space', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-faqa-single-accordion' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-faqa-single-accordion:last-child' => 'margin-bottom: 0{{UNIT}};',
				],
                'default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'single_accordion_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-faqa-single-accordion',
		        'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' 		=> '1',
							'right' 	=> '1',
							'bottom' 	=> '1',
							'left' 		=> '1',
							'isLinked'  => false,
						],
					],
					'color' => [
						'default' => '#ccc',
					],
				],
                'separator' => 'before'
			]
		);

		$this->add_control(
			'single_accordion_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-faqa-single-accordion' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-faqa-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-faqa-accordion-title span' => 'border-radius: 0{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0{{UNIT}};',
					'.wl {{WRAPPER}} .wl-faqa-accordion-content' => 'border-radius: 0{{UNIT}} 0{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'single_accordionboc_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-faqa-single-accordion',
			]
		);

		$this->end_controls_section();

		/*
		*Title style
		*/
		$this->start_controls_section(
			'title_style',
			[
				'label' => __( 'Title', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'woolementor-pro' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '.wl {{WRAPPER}} .wl-faqa-accordion-title h2',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->start_controls_tabs(
			'title_style_separator',
			[
			    'separator' => 'before'
			]
		);

		$this->start_controls_tab(
		    'title_collapse',
		    [
		        'label'     => __( 'Collapse', 'woolementor-pro' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'title_color',
				'selector' 	=> '.wl {{WRAPPER}} .wl-faqa-accordion-title h2',
				'fields_options' => [
					'color' => [ 'default' => '#212121' ], 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'title_background',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wl-faqa-accordion-title',
				// 'fields_options' => [
				// 	'background-color' => [ 'default' => 'var(--wl-black)' ], 
				// ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    'title_open',
		    [
		        'label'     => __( 'Expand', 'woolementor-pro' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'title_color_open',
				'selector' => '.wl {{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title h2',
				'fields_options' => [
					'color' => [ 'default' => 'var(--wl-black)' ], 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'title_background_open',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title',
				'fields_options' => [
					'background-color' => [ 'default' => 'var(--wl-black)' ], 
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/*
		*expand icon area
		*/
		$this->start_controls_section(
			'expand_style',
			[
				'label' => __( 'Icon', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
            'icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-faqa-accordion-title span' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title span:before' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 32,
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'expand_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'selector' => '.wl {{WRAPPER}} .wl-faqa-accordion-title span',
		        'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' 		=> '1',
							'right' 	=> '1',
							'bottom' 	=> '0',
							'left' 		=> '1',
							'isLinked'  => false,
						],
					],
					'color' => [
						'default' => '#ccc',
					],
				],
			]
		);

		$this->start_controls_tabs(
			'expand_style_separator',
			[
			    'separator' => 'before'
			]
		);

		$this->start_controls_tab(
		    'collapse',
		    [
		        'label'     => __( 'Collapse', 'woolementor-pro' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'collapse_color',
				'selector' => '.wl {{WRAPPER}} .wl-faqa-accordion-title span:before',
				'fields_options' => [
					'color' => [ 'default' => '#000' ], 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'collapse_background',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-faqa-accordion-title span',
			]
		);

		$this->add_control(
			'collapse_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-faqa-accordion-title span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    'expand_open',
		    [
		        'label'     => __( 'Expand', 'woolementor-pro' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'expand_color',
				'selector' => '.wl {{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title span:before',
				'fields_options' => [
					'color' => [ 'default' => 'var(--wl-black)' ], 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'expand_background',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title span',
			]
		);

		$this->add_control(
			'expand_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/*
		*Content style
		*/
		$this->start_controls_section(
			'content_style',
			[
				'label' => __( 'Content', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'woolementor-pro' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '.wl {{WRAPPER}} .wl-faqa-accordion-content',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'content_color',
				'selector' => '.wl {{WRAPPER}} .wl-faqa-accordion-content',
				'fields_options' => [
					'color' => [ 'default' => '#212121' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-faqa-accordion-content',
				'fields_options' => [
					'background' => [
						'default' => 'classic'
					],
					'color' => [
						'default' => '#fffbfb'
					]
				]
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label' => __( 'Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-faqa-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => __( 'Border', 'woolementor-pro' ),
				'selector' => '.wl {{WRAPPER}} .wl-faqa-accordion-content',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' 	=> '0',
							'right' => '1',
							'bottom'=> '1',
							'left' 	=> '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#feeff2',
					],
				],
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-faqa-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		extract( $settings );

		$section_id = $this->get_id();
		?>

		<div id="wl-faq-accordion-<?php esc_attr_e( $section_id );?>" class="wl-faq-accordion cx-container">
            <div class="wl-faqa-accordion-area">
               <!-- accordion 1 -->
               <?php $count = 0; foreach ( $list as $faqs_item ):                
               	$open = ($count == 0 && 'yes' == $open_first_item ) ? 'open' : '';
               	$display_block = ($count == 0 && 'yes' == $open_first_item ) ? 'block' : '';
               	?>
	               <div class="wl-faqa-single-accordion <?php esc_attr_e( $open ); ?>">
	                  <div class="wl-faqa-accordion-title item">
	                  <h2><?php echo esc_html( $faqs_item['faqs_title'] ); ?></h2><span></span>
	                  </div>
	                  <div class="wl-faqa-accordion-content item-data" style="display: <?php esc_attr_e( $display_block ) ; ?>;">
                          <?php echo do_shortcode( $faqs_item['faqs_content'] ); ?>
	                  </div>
	               </div>
	           <?php $count++; endforeach; ?>
			   
            </div>
      </div>

      	<?php
		/**
		 * Load Script
		 */
		$this->render_script();
	}

	protected function render_script() {
		$section_id = $this->get_id();
		?>

		<script type="text/javascript">
  			jQuery(function($){
  				var Accordion = function(el, multiple) {
					this.el = el || {};
					this.multiple = multiple || false;

					var links = this.el.find('.item');
					links.on('click', {
							el: this.el,
							multiple: this.multiple
					}, this.dropdown)
				}

				Accordion.prototype.dropdown = function(e) {
					var $el = e.data.el;
					$this = $(this),
					$next = $this.next();

					$next.slideToggle();
					$this.parent().toggleClass('open');

					if (!e.data.multiple) {
							$el.find('.item-data').not($next).slideUp().parent().removeClass('open');
					};
				}
				var accordion = new Accordion($('#wl-faq-accordion-<?php echo $section_id;?> .wl-faqa-single-accordion'), false);
  			})
  		</script>

		<?php
	}
}