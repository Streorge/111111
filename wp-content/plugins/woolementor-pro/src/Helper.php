<?php
/**
 * All helpers functions
 */
namespace Codexpert\Woolementor_Pro;
use Codexpert\Woolementor\Helper as Wlf_Helper;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\License;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Helper
 * @author Codexpert <hi@codexpert.io>
 */
class Helper extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->server	= $this->plugin['server'];
		$this->version	= $this->plugin['Version'];
	}

	public static function license() {
		global $woolementor_pro;
		
		$license = new License( $woolementor_pro );
		return $license;
	}

	public static function pri( $data ) {
		echo '<pre>';
		if( is_object( $data ) || is_array( $data ) ) {
			print_r( $data );
		}
		else {
			var_dump( $data );
		}
		echo '</pre>';
	}

	/**
	 * @param bool $show_cached either to use a cached list of posts or not. If enabled, make sure to wp_cache_delete() with the `save_post` hook
	 */
	public static function get_posts( $args = [], $show_heading = false, $show_cached = false ) {

		$defaults = [
			'post_type'         => 'post',
			'posts_per_page'    => -1,
			'post_status'		=> 'publish'
		];

		$_args = wp_parse_args( $args, $defaults );

		// use cache
		if( true === $show_cached && ( $cached_posts = wp_cache_get( "wcd_pro_{$_args['post_type']}", 'wcd_pro' ) ) ) {
			$posts = $cached_posts;
		}

		// don't use cache
		else {
			$queried = new \WP_Query( $_args );

			$posts = [];
			foreach( $queried->posts as $post ) :
				$posts[ $post->ID ] = $post->post_title;
			endforeach;
			
			wp_cache_add( "wcd_pro_{$_args['post_type']}", $posts, 'wcd_pro', 3600 );
		}

		$posts = $show_heading ? [ '' => sprintf( __( '- Choose a %s -', 'wcd_pro' ), $_args['post_type'] ) ] + $posts : $posts;

		return apply_filters( 'wcd_pro_get_posts', $posts, $_args );
	}

	public static function get_option( $key, $section, $default = '' ) {

		$options = get_option( $key );

		if ( isset( $options[ $section ] ) ) {
			return $options[ $section ];
		}

		return $default;
	}

	/**
	 * Includes a template file resides in /views diretory
	 *
	 * It'll look into /woolementor-pro directory of your active theme
	 * first. if not found, default template will be used.
	 * can be overwriten with woolementor-pro_template_overwrite_dir hook
	 *
	 * @param string $slug slug of template. Ex: template-slug.php
	 * @param string $sub_dir sub-directory under base directory
	 * @param array $fields fields of the form
	 */
	public static function get_template( $slug, $base = 'views', $args = null ) {

		// templates can be placed in this directory
		$overwrite_template_dir = apply_filters( 'wcd_pro_template_overwrite_dir', get_stylesheet_directory() . '/woolementor-pro/', $slug, $base, $args );
		
		// default template directory
		$plugin_template_dir = dirname( WOOLEMENTOR_PRO ) . "/{$base}/";

		// full path of a template file in plugin directory
		$plugin_template_path =  $plugin_template_dir . $slug . '.php';
		
		// full path of a template file in overwrite directory
		$overwrite_template_path =  $overwrite_template_dir . $slug . '.php';

		// if template is found in overwrite directory
		if( file_exists( $overwrite_template_path ) ) {
			ob_start();
			include $overwrite_template_path;
			return ob_get_clean();
		}
		// otherwise use default one
		elseif ( file_exists( $plugin_template_path ) ) {
			ob_start();
			include $plugin_template_path;
			return ob_get_clean();
		}
		else {
			return __( 'Template not found!', 'woolementor-pro' );
		}
	}

	public static function license_activated() {
		$_plugin				= get_plugin_data( WOOLEMENTOR_PRO );
		$_plugin['file']		= WOOLEMENTOR_PRO;
		$_plugin['basename']	= plugin_basename( WOOLEMENTOR_PRO );
		$_plugin['server']		= apply_filters( 'woolementor-pro_server', 'https://my.codexpert.io' );
		$_plugin['item_id']		= 8088;
		$_plugin['updatable']	= true;
		$_plugin['license_page']= admin_url( 'admin.php?page=woolementor' );
		
		$plugin = new \Codexpert\Plugin\License( $_plugin );
		return $plugin->_is_active();
	}

	public static function action_link( $plugin, $action = '' ) {

		$exploded	= explode( '/', $plugin );
		$slug		= $exploded[0];

		$links = [
			'install'		=> wp_nonce_url( admin_url( "update.php?action=install-plugin&plugin={$slug}" ), "install-plugin_{$slug}" ),
			'update'		=> wp_nonce_url( admin_url( "update.php?action=upgrade-plugin&plugin={$plugin}" ), "upgrade-plugin_{$plugin}" ),
			'activate'		=> wp_nonce_url( admin_url( "plugins.php?action=activate&plugin={$plugin}&plugin_status=all&paged=1&s" ), "activate-plugin_{$plugin}" ),
			'deactivate'	=> wp_nonce_url( admin_url( "plugins.php?action=deactivate&plugin={$plugin}&plugin_status=all&paged=1&s" ), "deactivate-plugin_{$plugin}" ),
		];

		if( $action != '' && array_key_exists( $action, $links ) ) return $links[ $action ];

		return $links;
	}
}