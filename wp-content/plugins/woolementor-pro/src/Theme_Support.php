<?php
/**
 * All admin facing functions
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
 * @subpackage Theme_Support
 * @author codexpert <hello@codexpert.io>
 */
class Theme_Support extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
		$this->template = get_template();

		self::hooks();
	}

	public function hooks() {

		if ( 'genesis' == $this->template ) {
			do_action( 'woolemntor-theme_support', $this->template, $this );
		}
		elseif ( 'astra' == $this->template ) {
			add_action( 'template_redirect', [ $this, 'astra_setup' ] );
			add_action( 'astra_header', [ $this, 'render_header' ] );
			add_action( 'astra_footer', [ $this, 'render_footer' ] );
		}
		elseif ( 'bb-theme' == $this->template || 'beaver-builder-theme' == $this->template ) {
			$this->template = 'beaver-builder-theme';
			do_action( 'woolemntor-theme_support', $this->template, $this );
		}
		elseif ( 'generatepress' == $this->template ) {
			add_action( 'template_redirect', [ $this, 'generatepress_setup' ] );
			add_action( 'generate_header', [ $this, 'render_header' ] );
			add_action( 'generate_footer', [ $this, 'render_footer' ] );
		}
		elseif ( 'oceanwp' == $this->template ) {
			add_action( 'template_redirect', [ $this, 'ocean_setup' ] );
			add_action( 'ocean_header', [ $this, 'render_header' ] );
			add_action( 'ocean_footer', [ $this, 'render_footer' ] );
		}
		elseif ( 'storefront' == $this->template ) {
			add_action( 'template_redirect', [ $this, 'storefront_setup' ] );
			add_action( 'storefront_before_header', [ $this, 'render_header' ] );
			add_action( 'storefront_after_footer', [ $this, 'render_footer' ] );
		}
		else {
			add_action( 'get_header', [ $this, 'render_header' ] );
			add_action( 'get_footer', [ $this, 'render_footer' ] );
		}
	}

	public function astra_setup() {
		global $post;

		if ( is_null( $post ) ) return;

		if ( in_array( get_post_meta( $post->ID, '_elementor_template_type', true ), [ 'header' ] ) ) return;
		$header_template_id = wcd_get_archive_template_id( 'wl-header' );
		$footer_template_id = wcd_get_archive_template_id( 'wl-footer' );

		if ( $header_template_id ) {
			remove_action( 'astra_header', 'astra_header_markup' );
		}

		if ( $footer_template_id ) {
			remove_action( 'astra_footer', 'astra_footer_markup' );
		}
	}

	public function generatepress_setup() {
		global $post;

		if ( is_null( $post ) ) return;

		if ( in_array( get_post_meta( $post->ID, '_elementor_template_type', true ), [ 'header' ] ) ) return;
		$header_template_id = wcd_get_archive_template_id( 'wl-header' );
		$footer_template_id = wcd_get_archive_template_id( 'wl-footer' );

		if ( $header_template_id ) {
			remove_action( 'generate_header', 'generate_construct_header' );
		}

		if ( $footer_template_id ) {
			remove_action( 'generate_footer', 'generate_construct_footer_widgets', 5 );
			remove_action( 'generate_footer', 'generate_construct_footer' );
		}
	}

	public function ocean_setup() {
		global $post;

		if ( is_null( $post ) ) return;

		if ( in_array( get_post_meta( $post->ID, '_elementor_template_type', true ), [ 'header' ] ) ) return;
		$header_template_id = wcd_get_archive_template_id( 'wl-header' );
		$footer_template_id = wcd_get_archive_template_id( 'wl-footer' );

		if ( $header_template_id ) {
			remove_action( 'ocean_top_bar', 'oceanwp_top_bar_template' );
			remove_action( 'ocean_header', 'oceanwp_header_template' );
			remove_action( 'ocean_page_header', 'oceanwp_page_header_template' );
		}

		if ( $footer_template_id ) {
			remove_action( 'ocean_footer', 'oceanwp_footer_template' );
		}
	}

	public function storefront_setup() {
		global $post;

		if ( is_null( $post ) ) return;

		if ( in_array( get_post_meta( $post->ID, '_elementor_template_type', true ), [ 'header' ] ) ) return;
		$header_template_id = wcd_get_archive_template_id( 'wl-header' );
		$footer_template_id = wcd_get_archive_template_id( 'wl-footer' );

		if ( $header_template_id ) {
			remove_all_actions( 'storefront_header' );
		}

		if ( $footer_template_id ) {
			remove_all_actions( 'storefront_footer' );
		}
	}

	public function render_header() {
		global $post;
		
		if ( is_null( $post ) ) return;

		if ( in_array( get_post_meta( $post->ID, '_elementor_template_type', true ), [ 'header' ] ) ) return;

		$template_id = wcd_get_archive_template_id( 'wl-header' );
		if ( in_array( get_post_meta( $template_id, '_elementor_template_type', true ), [ 'wl-header' ] ) ) {
			echo Helper::get_template( 'header', 'views/templates' );
		}
	}

	public function render_footer() {
		global $post;

		if ( is_null( $post ) ) return;
		
		if ( in_array( get_post_meta( $post->ID, '_elementor_template_type', true ), [ 'footer' ] ) ) return;

		$template_id = wcd_get_archive_template_id( 'wl-footer' );
		if ( in_array( get_post_meta( $template_id, '_elementor_template_type', true ), [ 'wl-footer' ] ) ) {
			echo Helper::get_template( 'footer', 'views/templates' );
		}
	}
}