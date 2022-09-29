<?php
namespace Codexpert\Woolementor_Pro;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Common\EccLevel;
use Picqer\Barcode\BarcodeGeneratorJPG;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Codexpert\Woolementor\Helper as WCDH;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Product_Barcode extends Widget_Base {

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

		/**
		 * Barcode Options
		 */
		$this->start_controls_section(
			'barcode_typs_section',
			[
				'label' => __( 'Barcode Types', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'barcode_type',
            [
                'label'     => __( 'Type', 'woolementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'qrcode' 	=> __( 'QRCode', 'woolementor-pro' ),
                    'barcode' 	=> __( 'Barcode', 'woolementor-pro' ),
                ],
                'default'   => 'qrcode',
            ]
        );

		$this->end_controls_section();

		/**
		 * Settings controls
		 */
		$this->start_controls_section(
			'barcode_content_section',
			[
				'label' => __( 'Content', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'barcode_content_source',
            [
                'label' => __( 'Content Source', 'woolementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'current_product'   => __( 'Current Product', 'woolementor' ),
                    'different_product' => __( 'Custom', 'woolementor' ),
                ],
                'default' => 'current_product' ,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'barcode_product_id',
            [
                'label'     => __( 'Product ID', 'woolementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => get_post_type( get_the_ID() ) == 'product' ? get_the_ID() : '',
                'description'  => __( 'Input the base product ID', 'woolementor' ),
                'condition'     => [
                    'barcode_content_source' => 'different_product'
                ],
            ]
        );

        $this->add_control(
			'barcode_product_content',
			[
				'label' 		=> __( 'Product Content', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'multiple' 		=> true,
				'options'		=> wcd_product_options(),
				'default' 		=> [ 'name', 'price', 'link' ],
				'label_block' 	=> true,
			]
		);

		$this->end_controls_section();

		/**
		 * Configuration
		 */
		$this->start_controls_section(
			'qrcode_configuration',
			[
				'label' => __( 'Configuration', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'barcode_type' => 'qrcode'
                ]
			]
		);

		$this->add_control(
			'qrcode_logo',
			[
				'type' 		=> Controls_Manager::MEDIA,
				'label' 	=> esc_html__( 'Logo', 'woolementor-pro' ),
				'default' 	=> [
					'url' 	=> Utils::get_placeholder_image_src(),
				]
			]
		);

		$this->add_control(
            'qrcode_ecc',
            [
                'label'     => __( 'ECC', 'woolementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'ECC_L' => __( 'L', 'woolementor-pro' ),
                    'ECC_M' => __( 'M', 'woolementor-pro' ),
                    'ECC_Q' => __( 'Q', 'woolementor-pro' ),
                    'ECC_H' => __( 'H', 'woolementor-pro' ),
                ],
                'default'   => 'ECC_L',
            ]
        );

		$this->add_control(
            'qrcode_type',
            [
                'label'     => __( 'Type', 'woolementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'png' 	=> __( 'PNG', 'woolementor-pro' ),
                    'svg' 	=> __( 'SVG', 'woolementor-pro' ),
                    'jpg' 	=> __( 'JPG', 'woolementor-pro' ),
                    'gif' 	=> __( 'GIF', 'woolementor-pro' ),
                    'fpdf' 	=> __( 'PDF', 'woolementor-pro' ),
                ],
                'default'   => 'png',
            ]
        );

        $this->add_control(
            'qrcode_file_size',
            [
                'label' 	=> __( 'Size', 'woolementor' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-img img' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 3480
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
            ]
        );

		$this->end_controls_section();

		/**
		 * Configuration
		 */
		$this->start_controls_section(
			'barcode_configuration',
			[
				'label' => __( 'Configuration', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'barcode_type' => 'barcode'
                ]
			]
		);

        $this->add_control(
            'barcode_width',
            [
                'label' 	=> __( 'Factor Width', 'woolementor' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
            ]
        );

        $this->add_control(
            'barcode_height',
            [
                'label' 	=> __( 'Height', 'woolementor' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
            ]
        );

        $this->add_control(
            'barcode_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'default' 	=> '#000000'
            ]
        );

		$this->end_controls_section();

		/**
		 * Product Style controls
		 */
		$this->start_controls_section(
			'barcode_style',
			[
				'label' => __( 'Configuration', 'woolementor-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
        $widget_id  = $this->id;
		extract( $settings );

		if ( ! is_woocommerce_activated() ) return;
		if ( ! is_product() ) return;

        $product_id = $barcode_product_id;
        if ( 'current_product' == $barcode_content_source ) {
        	$product_id = get_the_ID();
        }

        $product 		= wc_get_product( $product_id );

        $_data = [
        	'name' 				=> $product->get_name(),
	        'price' 			=> $product->get_price(),
	        'description' 		=> $product->get_description(),
	        'short_desc' 		=> $product->get_short_description(),
	        // 'dimensions' 		=> $product->get_dimensions(),
	        'rating' 			=> $product->get_average_rating(),
	        'review_count' 		=> $product->get_review_count(),
	        'link' 				=> get_permalink( $product->get_id() ),
        ];

        $data = '';
        foreach ( $_data as $key => $value ) {
        	if ( in_array( $key, $barcode_product_content ) ) {
        		$data .= ucwords( $key ) . ': ' . $value . PHP_EOL;
        	}
        }

		if ( 'qrcode' == $barcode_type ) {
			$options = new QROptions(
				[
					'eccLevel' 		=> QRCode::ECC_L,
					'outputType' 	=> QRCode::OUTPUT_IMAGE_PNG,
					'version' 		=> QRCode::VERSION_AUTO,
					'cssClass'     	=> 'qrcode',
					'moduleValues' 	=> [
						// finder
						QRMatrix::M_FINDER     => '#A71111', // dark (true)
						QRMatrix::M_FINDER                         => '#FFBFBF', // light (false)
						QRMatrix::M_FINDER_DOT => '#A71111', // finder dot, dark (true)
						// alignment
						QRMatrix::M_ALIGNMENT  => '#A70364',
						QRMatrix::M_ALIGNMENT                      => '#FFC9C9',
						// timing
						QRMatrix::M_TIMING     => '#98005D',
						QRMatrix::M_TIMING                         => '#FFB8E9',
						// format
						QRMatrix::M_FORMAT     => '#003804',
						QRMatrix::M_FORMAT                         => '#00FB12',
						// version
						QRMatrix::M_VERSION    => '#650098',
						QRMatrix::M_VERSION                        => '#E0B8FF',
						// data
						QRMatrix::M_DATA       => '#4A6000',
						QRMatrix::M_DATA                           => '#ECF9BE',
						// darkmodule
						QRMatrix::M_DARKMODULE => '#080063',
						// separator
						QRMatrix::M_SEPARATOR                      => '#AFBFBF',
						// quietzone
						QRMatrix::M_QUIETZONE                      => '#DDDDDD',
					],
				]
			);

			$qrcode = (new QRCode($options))->render( $data );

			echo "<img src='" . $qrcode . "'>";
		}
		else {
			$generator 	= new \Picqer\Barcode\BarcodeGeneratorJPG();

			$type 		= $generator::TYPE_CODE_128;
			$width 		= $barcode_width['size'];
			$height 	= $barcode_height['size'];

			$color 		= explode( ',', wcd_hextorgb( $barcode_color ) );
			echo '<img src="data:image/jpg;base64,' . base64_encode( $generator->getBarcode( $data, $type, $width, $height, $color ) ) . '">';
		}
	}
}