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
 * @subpackage Email
 * @author codexpert <hello@codexpert.io>
 */
class Email extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}
	
	public static function get_active_designers() {
		$_designers = get_option( 'wcd_email_designer' );
		$designers = [];

		if( $_designers && count( $_designers ) > 0 ) {
			foreach ( $_designers as $designer => $template_id ) {
				if( $template_id != '' ) {
					$designers[ $designer ] = $template_id;
				}
			}
		}

		return $designers;
	}

	public function get_designer_template_id( $wc_templace ) {
		$designers = $this->get_active_designers();

		if( isset( $designers[ $wc_templace ] ) ) {
			return $designers[ $wc_templace ];
		}

		return false;
	}

	public function change_content( $template, $template_name, $args, $template_path, $default_path ) {
		
		$template_base_name = str_replace( [ 'emails/', '.php' ], [], $template_name );
		
		if( false !== ( $template_id = $this->get_designer_template_id( $template_base_name ) ) ) {
			
			$_REQUEST['template_id'] = $template_id;

			return trailingslashit( WOOLEMENTOR_PRO_DIR ) . 'views/email.php';
		}

		return $template;
	}

	public function change_styles( $styles, $object ) {

		$template_base_name = str_replace( [ 'emails/', '.php' ], [], $object->template_html );

		if( false === ( $template_id = $this->get_designer_template_id( $template_base_name ) ) ) return $styles;
		ob_start();
		echo wcd_get_template_css( $template_id );
		return ob_get_clean();
	}

	public function test_email_css( $styles, $object ) {
		$template_id = codesigner_sanitize_number( $_REQUEST['template_id'] );
		ob_start();
		echo wcd_get_template_css( $template_id );
		return ob_get_clean();
	}
}