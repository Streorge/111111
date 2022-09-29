<?php
/**
 * All public facing functions
 */
namespace Codexpert\Woolementor_Pro;
use Codexpert\Plugin\Base;
use Elementor\Plugin as Elementor;

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
class Ajax extends Base {

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

	public function afp_form_submission(){

		$default_inputs = [ 'action', 'afp_product_id', 'afp_rep_msg', 'afp_resp_redirect', 'afp_mail_subject', 'afp_mail_body', 'afp_admin_mail_subject', 'afp_mail_name' ];

		$table_row = "";
		$target_string = $replace_values = [];
		foreach ( $_POST as $key => $value ) {
			if( !in_array( $key, $default_inputs ) ){
				$_key 	= str_replace( '_', ' ', $key );
				$_key 	= str_replace( '-', ' ', $_key );
				$_key 	= ucwords( $_key );
				$_value = sanitize_text_field( $value );
				$target_string[] 	= "%%{$key}%%";
				$replace_values[]	= $_value;
				$table_row .= "<tr><th>{$_key}</th><td>{$_value}</td></tr>";
			}
		}


		if ( isset( $_POST['afp_product_id'] ) ) {
			$product_id 	= (int)sanitize_text_field( $_POST['afp_product_id'] );
			$product_title 	= get_the_title( $product_id );
			$product_url 	= get_the_permalink( $product_id );
			$table_row 	   .= "<tr><th>". __( 'Product ID', 'woolementor-pro' ) ."</th><td>{$product_id}</td></tr>";
			$table_row 	   .= "<tr><th>". __( 'Product Name', 'woolementor-pro' ) ."</th><td>{$product_title}</td></tr>";
			$table_row 	   .= "<tr><th>". __( 'Product Url', 'woolementor-pro' ) ."</th><td>{$product_url}</td></tr>";
		}

		$admin_mail = get_bloginfo( 'admin_email' );
		$_subject 	= sanitize_text_field( $_POST['afp_admin_mail_subject'] );
		$subject 	= str_replace( $target_string, $replace_values, $_subject );
		$message 	= "<table>{$table_row}</table>";
		$wc_email 	= new \WC_Emails;
		$_message 	= stripslashes( $message );
		ob_start();
		$wc_email->email_header( $subject );
		echo $_message;
		$wc_email->email_footer();
		$message 	= ob_get_clean();
		$wc_email->send( $admin_mail, $subject, $message );

		if ( isset( $_POST['afp_mail_body'] ) && isset( $_POST['afp_mail_subject'] ) && isset( $_POST['afp_mail_name'] ) ) {
			$subject 		= sanitize_text_field( $_POST['afp_mail_subject'] );
			$subject 		= str_replace( $target_string, $replace_values, $subject );
			$message 		= sanitize_text_field( $_POST['afp_mail_body'] );
			$message 		= str_replace( $target_string, $replace_values, $message );;
			$_message 		= stripslashes( $message );
			$customer_mail 	= sanitize_email( $_POST[ $_POST['afp_mail_name'] ] );

			ob_start();
			$wc_email->email_header( $subject );
			echo $_message;
			$wc_email->email_footer();
			$message 	= ob_get_clean();
			$wc_email->send( $customer_mail, $subject, $message );
		}

		if ( isset( $_POST['afp_resp_redirect'] ) ) {
			$redirect_data 			= json_decode( stripslashes( sanitize_text_field( $_POST['afp_resp_redirect'] ) ) );
			$response['redirect'] 	= $redirect_data;
		}

		if ( isset( $_POST['afp_rep_msg'] ) ) {
			$res_msg 				= sanitize_text_field( $_POST['afp_rep_msg'] );
			$res_msg 				= str_replace( $target_string, $replace_values, $res_msg );
			$response['res_msg'] 	= $res_msg;
		}

		$response['status'] = 1;
		$response['message'] = __( 'Form submitted', 'woolementor-pro' );
		wp_send_json( $response );
	}

	public function test_email() {

		if( ! class_exists( 'Email' ) ) {
			include_once dirname( WC_PLUGIN_FILE ) . '/includes/emails/class-wc-email.php';
		}

		$response = [];

        if( !wp_verify_nonce( $_POST['_wpnonce'], $this->slug ) ) {
            $response['status']		= 0;
            $response['message'] 	= __( 'Unauthorized!', 'woolementor-pro' );
            wp_send_json( $response );
        }

        extract( $_POST );

        $subject 	= __( 'Test Email', 'woolementor-pro' );
        $html 		= Elementor::$instance->frontend->get_builder_content( $template_id );

        $wc_email 	= new \WC_Email();

        $_email 	= new Email( $this->plugin );

        $_REQUEST['template_id'] = $template_id;
        add_filter( 'woocommerce_email_styles', [ $_email, 'test_email_css' ], 11, 2 );

        $wc_email->send( $email, $subject, $html, '', [] );


		$response['status'] 	= 1;
		$response['message'] 	= __( 'Send Email Successfully', 'woolementor-pro' );
		wp_send_json( $response );
	}

	public function add_to_compare(){
		$response = [
			 'status'	=> 0,
			 'message'	=>__( 'Unauthorized!', 'woolementor' )
		];

		global $woolementor;
		if( !wp_verify_nonce( $_POST['_wpnonce'], $woolementor['TextDomain'] ) ) {
		    wp_send_json( $response );
		}

		if( !isset( $_POST['product_id'] ) ) {
			$response['message'] = __( 'No product selected!', 'woolementor' );
		    wp_send_json( $response );
		}

		$product_id = codesigner_sanitize_number( $_POST['product_id'] );
		wcd_add_to_compare( $product_id );

		$response['status'] 	= 1;
		$response['btn_text'] 	= __( 'View Table', 'woolementor' );
		$response['message'] 	= __( 'Product Added', 'woolementor' );

		wp_send_json( $response );
	}
	
	public function remove_from_compare(){
		$response = [
			 'status'	=> 0,
			 'message'	=>__( 'Unauthorized!', 'woolementor' )
		];
		global $woolementor;
		if( !wp_verify_nonce( $_POST['_wpnonce'], $woolementor['TextDomain'] ) ) {
		    wp_send_json( $response );
		}

		if( !isset( $_POST['product_id'] ) ) {
			$response['message'] = __( 'No product selected!', 'woolementor' );
		    wp_send_json( $response );
		}

		$compare_key 	= wcd_compare_cookie_key();
		if ( isset( $_COOKIE[ $compare_key ] ) ) {
		    $_products 		= sanitize_key( $_COOKIE[ $compare_key ] );
		    $products		= $_products ? unserialize( $_products ) : [];
		    $products		= array_unique( $products );
			$product_id 	= codesigner_sanitize_number( $_POST['product_id'] );
			$_key 			= array_search($product_id, $products);

			if( isset( $products[ $_key ] ) ){
				unset( $products[ $_key ] );
			}
			if ( count( $products ) > 0 ) {		    	
				$products 	= array_values( $products );
			}
			$compare_key 	= wcd_compare_cookie_key();
			setcookie(  $compare_key , serialize( $products ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
			$response['status'] 	= 1;
			$response['product_id'] = $product_id;
			$response['products'] 	= $products;
			$response['message'] 	= __( 'Product removed', 'woolementor' );
		}

		wp_send_json( $response );
	}

	public function quick_view() {
		$response = [];

        if( !wp_verify_nonce( $_POST['_nonce'], $this->slug ) ) {
            $response['status']		= 0;
            $response['message'] 	= __( 'Unauthorized!', 'woolementor-pro' );
            wp_send_json( $response );
        }

		$product_id 	= codesigner_sanitize_number( $_POST['product_id'] );
		$template_id 	= codesigner_sanitize_number( $_POST['template_id'] );
		$html 			= Elementor::$instance->frontend->get_builder_content( $template_id );

		$response['status'] 	= 1;
		$response['html'] 		= $html;
		$response['title'] 		= get_the_title( $product_id );
		$response['message']    = __( 'Quick view', 'woolementor-pro' );
		wp_send_json( $response );
	}

	public function quick_checkout() {
		$response = [];

        if( !wp_verify_nonce( $_POST['_nonce'], $this->slug ) ) {
            $response['status']		= 0;
            $response['message'] 	= __( 'Unauthorized!', 'woolementor-pro' );
            wp_send_json( $response );
        }

		// $template_id 	= codesigner_sanitize_number( $_POST['template_id'] );
		
		$product_id 	= codesigner_sanitize_number( $_POST['product_id'] );

		WC()->cart->add_to_cart( $product_id );

		$response['status'] 	= 1;
		// $response['html'] 		= $html;
		$response['message']    = __( 'Quick Checkout', 'woolementor-pro' );
		wp_send_json( $response );
	}

	public function ajax_filter() {
		$response = [];

        if( !wp_verify_nonce( $_POST['_wpnonce'], 'woolementor-shop' ) ) {
            $response['status']		= 0;
            $response['message'] 	= __( 'Unauthorized!', 'woolementor-pro' );
            wp_send_json( $response );
        }

        $_settings 	= isset( $_POST['settings'] ) ? sanitize_text_field( $_POST['settings'] ) : '';
        $settings 	= unserialize( stripslashes( $_settings ) );

        $widget_id 	= isset( $_POST['widget_id'] ) ? sanitize_text_field( $_POST['widget_id'] ) : '';

		if ( wcd_is_pro_feature( $widget_id ) ) {
		    $html = Helper::get_template( 'template', "widgets/{$widget_id}", [ 'widget_id' => $widget_id, 'settings' => $settings ] );
		}
		else {
		    $html = \Codexpert\Woolementor\Helper::get_template( 'template', "widgets/{$widget_id}", [ 'widget_id' => $widget_id, 'settings' => $settings ] );
		}

		$response['status'] 	= 1;
		$response['html'] 		= $html;
		$response['message']    = __( 'Filter', 'woolementor-pro' );
		wp_send_json( $response );
	}
}