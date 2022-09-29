<?php
/**
 * All public facing functions
 */
namespace Codexpert\Woolementor_Pro;
use Codexpert\Plugin\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Front
 * @author codexpert <hello@codexpert.io>
 */
class Front extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
		$this->license	= $this->plugin['license'];
		$this->assets 	= WOOLEMENTOR_PRO_ASSETS;
	}
	
	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';

		wp_enqueue_style( $this->slug, "{$this->assets}/css/front{$min}.css", '', $this->version, 'all' );
		wp_enqueue_script( $this->slug, "{$this->assets}/js/front{$min}.js", [ 'jquery' ], $this->version, true );

		// define localized scripts
		$localized = array(
			'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
			'_nonce'		=> wp_create_nonce( $this->slug ),
		);

		wp_localize_script( $this->slug, 'WOOLEMENTOR_PRO', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	/**
	 * Add some script to head
	 *
	 * @since 1.0
	 */
	public function head() {}

	public function set_cookie() {
		if ( isset( $_GET['products'] ) && $_GET['products'] != '' ) {			
	        $products 			= isset( $_GET['products'] ) ? $_GET['products'] : [];
			wcd_add_to_compare( $products );
		}
	}

	public function filter_content( $content ) {
		
		if ( 'elementor_canvas' !== get_page_template_slug() ) {
			return $content;
		}

		$header = $footer = '';

		$template_id = wcd_get_archive_template_id( 'wl-header' );
		if ( !is_null( $template_id ) ) {
			$elementor_instance = \Elementor\Plugin::instance();
			$header = $elementor_instance->frontend->get_builder_content_for_display( $template_id );
		}

		$template_id = wcd_get_archive_template_id( 'wl-footer' );
		if ( !is_null( $template_id ) ) {
			$elementor_instance = \Elementor\Plugin::instance();
			$footer = $elementor_instance->frontend->get_builder_content_for_display( $template_id );
		}

		return $header . $content . $footer;
	}

	public function override_loader_files( $templates, $template ) {
		$basename 		= basename( $template );
		$template_type 	= $basename == 'single-product.php' ? 'wl-single' : 'wl-archive';
		$template_id 	= wcd_get_archive_template_id( $template_type );
		if ( !is_null( $template_id ) ) {	
	    	wp_cache_set( "woolementor-template_{$basename}", $template );
		}
	    return $templates;
	}

	public function override_product_templates( $template ) {
		$object = get_queried_object();
		
		if ( is_null( $object ) && ( !is_home() || !is_front_page() ) ) return $template;

		if ( is_home() || is_front_page() ) {
			$screen = 'page';
		}
		elseif ( function_exists( 'is_shop' ) && is_shop() ) {
			$screen = 'page';
		}
		elseif ( is_tax() ) {
			$screen = 'tax';
		}
		elseif ( is_singular() ) {
			$screen = $object->post_type;
		}
		else{
			$screen = $object->post_type;
		}

		$basename 		= basename( $template );
		$template_type  = $basename == 'single-product.php' ? 'wl-single' : 'wl-archive';
		$template_id 	= wcd_get_archive_template_id( $template_type );

		$template_meta 	= get_post_meta( $template_id, "wl_{$screen}_includes", true );

		if( !is_array( $template_meta ) || count( $template_meta ) <= 0 ) return $template;

		if ( is_shop() || is_tax() ) {
			return trailingslashit( WOOLEMENTOR_PRO_DIR ) . "views/templates/archive.php";
		}
		elseif ( is_singular() ) {
			return trailingslashit( WOOLEMENTOR_PRO_DIR ) . "views/templates/single-product.php";
		}
	}

	public function filter_checkout_fields( $fields ) {

		global $post;

		if ( wcd_is_edit_mode() || wcd_is_preview_mode() || ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'woocommerce_checkout' ) ) ) return $fields;

		$_wl_fields = get_option( '_wcd_checkout_fields', [] );

		if( count( $_wl_fields ) <= 0 ) return $fields;

		$wl_ids 		 = [];
		$checkout_fields = [];
		foreach ( $_wl_fields as $section => $checkout_section_fields ) {
			if ( in_array( $section, [ 'billing', 'shipping', 'order' ] ) && ! empty( $checkout_section_fields ) ) {
				foreach( $checkout_section_fields as $item ) {	
					$wl_ids[] = $item[ "{$section}_input_name" ];
					$checkout_fields[$section][ sanitize_text_field( $item["{$section}_input_name"] ) ] = 
				        [
				            'label'			=> sanitize_text_field( $item["{$section}_input_label"] ),
				            'type'			=> esc_attr( $item["{$section}_input_type"] ),
				            'required'		=> $item["{$section}_input_required"] == 'true' ? true : false,
				            'class'			=> is_array( $item["{$section}_input_class"] ) ? $item["{$section}_input_class"] : explode( ' ', $item["{$section}_input_class"] ),
				            'autocomplete'	=> sanitize_text_field( $item["{$section}_input_autocomplete"] ), 
				            'placeholder'	=> sanitize_text_field( $item["{$section}_input_placeholder"] ),
				            'priority'		=> 10,
				        ];
				}
			}
		}

		$fields = $checkout_fields + $fields;		

		foreach ( $fields as $section => $section_fields ) {
			foreach ( $section_fields as $key => $value ) {
				if ( !in_array( $key, $wl_ids ) ) {
					unset( $fields[ $section ][ $key ] );
				}
			
			}
		}

		return $fields;
	}
	
	public function wishlist_button() {
		global $product;
		if( is_null( $product ) ) return;
		$user_id  	 = get_current_user_id();
		$wishlist 	 = wcd_get_wishlist( $user_id );
		$fav_product = in_array( $product->get_ID(), $wishlist );

		if ( !empty( $fav_product ) ) {
		    $fav_item = 'fav-item';
		}
		else {
		    $fav_item = '';
		}

		if( ! apply_filters( 'woolementor-pro_default_wishlist_icon', true, $product ) ) return;

		$title = __( "Add to Wishlist", "woolementor-pro" );
		echo '<button class="ajax_add_to_wish wl-wish-button button ' . esc_attr( $fav_item  ) . '" type="button" title="' . esc_attr( $title ) . '" data-product_id="' . $product->get_ID() . '">
                <i aria-hidden="true" class="fas fa-heart"></i>
            </button>';
	}

	public function footer() {
		?>
		<div class="wcd-quick-view-modal" style="display: none;">
			<div class="wcd-quick-view-modal-overlay wcd-quick-view-wrap"></div>
			<div class="wcd-quick-view-loader" style="display: none;"></div>
			<div class="wcd-quick-view-modal-wrapper wcd-quick-view-modal-transition">
				<div class="wcd-quick-view-modal-inner">
					<div class="wcd-quick-view-modal-header">
						<button class="wcd-quick-view-modal-close wcd-quick-view-wrap">x</button>
						<h2 class="wcd-quick-view-modal-heading"><?php _e( 'Product title goes here', 'woolementor-pro' ); ?></h2>
					</div>

					<div class="wcd-quick-view-modal-body">
						<div class="wcd-quick-view-modal-content">
							<p><?php _e( 'Please select a template first', 'woolementor-pro' ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="wcd-loader-wrapper" style="display: none;">
			<div class="wcd-loader"></div>
		</div>
		<?php
	}

	public function is_checkout_render() {
		global $post;

		if ( is_singular() ) {
			$post_id = $post->ID;
			if ( get_post_meta( $post_id, 'codesigner_quick_checkout', true ) ) {
				return true;
			}
		}
		
		return false;
	}

	public function empty_cart_render() {
		global $post;

		$post_id = $post->ID;
		if ( get_post_meta( $post_id, 'codesigner_quick_checkout', true ) ) {
			return false;
		}
		return true;
	}
}