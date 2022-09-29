<?php
use Codexpert\Woolementor_Pro\Helper;

if( !function_exists( 'get_plugin_data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if( ! function_exists( 'wcd_pro_site_url' ) ) :
function wcd_pro_site_url() {
	return get_bloginfo( 'url' );
}
endif;

if( !function_exists( 'wcd_get_archive_template_id' ) ) :
function wcd_get_archive_template_id( $template_type ){

	$object = get_queried_object();

	if ( is_null( $object ) && ( !is_home() || !is_front_page() ) ) return;
	
	if ( is_home() || is_front_page() ) {
		$id 	= 'home';
		$screen = 'page';
	}
	elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$id 	= wc_get_page_id( 'shop' );
		$screen = 'page';
	}
	elseif ( is_tax() ) {
		$id 	= $object->term_id;
		$screen = 'tax';
	}
	elseif ( is_singular() ) {
		$screen = $object->post_type;
		$id 	= $object->ID;
	}
	else{
		$id 	= $object->ID;
		$screen = $object->post_type;
	}


	$args = [  
	    'post_type' 	 	=> 'elementor_library',
	    'post_status' 	 	=> 'publish',
	    'posts_per_page' 	=> 1, 
	    'orderby'     		=> 'modified',
	    'order' 		 	=> 'DESC',
	    'meta_query' 	 	=> [
	    	'relation' 	 	=> 'AND',
			[
				'key' 		=> '_elementor_template_type',
				'value' 	=> $template_type,
			],
	    	[
	    		'relation' 	=> 'or',
	    		[
	        	    'key'		=> "wl_{$screen}_includes",
	        	    'value'		=> '"' . $id . '"',
	        	    'compare'	=> 'LIKE'
	        	],
	    		[
	        	    'key'		=> "wl_{$screen}_includes",
	        	    'value'		=> '"0"',
	        	    'compare'	=> 'LIKE'
	        	],
	    	]
	    ]
	];
	
	$result 	= new \WP_Query( $args ); 
	$template 	= $result->post;

	if ( empty( $template ) ) return;

	return $template->ID;
}
endif;

if( !function_exists( 'wcd_is_order_pay_page' ) ):
	function wcd_is_order_pay_page(){
		global $wp;
		$wcd_is_order_pay_page = ( !empty( $wp->query_vars['order-pay'] ) || isset( $_GET['pay_for_order'], $_GET['key'] ) );

		return $wcd_is_order_pay_page == 1 ? $wcd_is_order_pay_page : 0;
	}
endif;

if( !function_exists( 'wcd_woocommerce_checkout_payment' ) ):
	function wcd_woocommerce_checkout_payment() {
		echo wcd_pro_get_template( 'review-order-2', 'widgets/order-review/template-parts' );
	}
endif;

/**
 * Determines if the pro version is activated
 *
 * @since 1.0
 */
if( !function_exists( 'wcd_is_pro_activated' ) ) :
function wcd_is_pro_activated() {
	return Helper::license()->_is_activated();
}
endif;


/**
 * Return the template types
 *
 * @since 3.0
 * @author Jakaria Istauk <jakariamd35@gmail.com>
 */
if( !function_exists( 'wcd_get_template_types' ) ) :
function wcd_get_template_types(){

	$types['wl-header']	= [
		'class' => 'Header',
		'label' => __( 'WCD Header', 'woolementor-pro' )
	];
	$types['wl-footer']	= [
		'class' => 'Footer',
		'label' => __( 'WCD Footer', 'woolementor-pro' )
	];
	$types['wl-archive'] = [
		'class' => 'Archive',
		'label' => __( 'WCD Product Archive', 'woolementor-pro' )
	];
	$types['wl-single']	= [
		'class' => 'Single',
		'label' => __( 'WCD Single Product', 'woolementor-pro' )
	];
	$types['wl-tab'] = [
		'class' => 'Tab',
		'label' => __( 'WCD Tab', 'woolementor-pro' )
	];
	$types['wl-email'] = [
		'class' => 'Email',
		'label' => __( 'WCD Email', 'woolementor-pro' )
	];

	return apply_filters( 'woolementor-pro_template_types', $types );
}
endif;

/**
 * Return the template types
 *
 * @since 3.0
 * @param $args, give array value. unset field
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
if( !function_exists( 'wcd_get_meta_fields' ) ) :
function wcd_get_meta_fields( $args = [] ) {
	global $wpdb;

	$all_ids = get_posts( array(
		'post_type'		=> 'product',
		'numberposts' 	=> -1,
		'post_status' 	=> 'publish',
		'fields' 		=> 'ids',
	) );

	$table_name	= $wpdb->prefix . 'postmeta';

	$ids = implode( ',', $all_ids );
	
	$sql = "SELECT DISTINCT `meta_key` FROM `wp_postmeta` WHERE `post_id` IN( {$ids} )";

	$results = $wpdb->get_results( $sql );

	$meta_fields = [];
	foreach ( $results as $result ) {
		if ( !in_array( $result->meta_key, $args ) ) {
			$meta_fields[ $result->meta_key ] = ucwords( str_replace( '_', ' ', $result->meta_key ) );
		}
	}
	
	return $meta_fields;
}
endif;

/**
 * Return list of woocommerce email hooks
 *
 * @since 3.0
 * @author Jakaria Istauk<jakariamd35@gmail.com>
 */
if( !function_exists( 'wcd_get_wc_email_hooks' ) ) :
function wcd_get_wc_email_hooks() {
	
	$hooks = [
		'woocommerce_email_order_details' 		=> __( 'In order details', 'woolementor-pro' ),
		'woocommerce_email_before_order_table' 	=> __( 'Before order table', 'woolementor-pro' ),
		'woocommerce_email_after_order_table' 	=> __( 'After order table', 'woolementor-pro' ),
		'woocommerce_email_order_meta' 			=> __( 'In order meta', 'woolementor-pro' ),
		'woocommerce_email_customer_details' 	=> __( 'In customer details', 'woolementor-pro' ),
	];
	
	return $hooks;
}
endif;

/**
 * Return list of woocommerce thankyou page hooks
 *
 * @since 3.0
 * @author Jakaria Istauk<jakariamd35@gmail.com>
 */
if( !function_exists( 'wcd_get_wc_thankyou_hooks' ) ) :
function wcd_get_wc_thankyou_hooks() {
	
	$hooks = [
		'woocommerce_before_thankyou' 	=> __( 'Before Thankyou', 'woolementor-pro' ),
		'woocommerce_thankyou' 			=> __( 'After/Bottom of Thankyou', 'woolementor-pro' )
	];
	
	return $hooks;
}
endif;

/**
 * Return list of woocommerce order edit page hooks
 *
 * @since 3.0
 * @author Jakaria Istauk<jakariamd35@gmail.com>
 */
if( !function_exists( 'wcd_get_wc_edit_order_hooks' ) ) :
function wcd_get_wc_edit_order_hooks() {
	
	$hooks = [		
		'woocommerce_admin_order_data_after_order_details' 		=> __( 'After order details', 'woolementor-pro' ),
		'woocommerce_admin_order_data_after_billing_address' 	=> __( 'After billing address', 'woolementor-pro' ),
		'woocommerce_admin_order_data_after_shipping_address' 	=> __( 'After shipping address', 'woolementor-pro' ),
		'woocommerce_admin_order_item_headers' 					=> __( 'Order item headers', 'woolementor-pro' ),
		'woocommerce_admin_order_totals_after_shipping' 		=> __( 'After shipping totals', 'woolementor-pro' ),
		'woocommerce_order_actions_start' 						=> __( 'Before order action', 'woolementor-pro' ),
		'woocommerce_order_actions_end' 						=> __( 'After order action', 'woolementor-pro' ),
	];
	
	return $hooks;
}
endif;

/**
 * Return list of woocommerce order edit page hooks
 *
 * @since 3.0
 * @author Jakaria Istauk<jakariamd35@gmail.com>
 */
if( !function_exists( 'wcd_get_current_order_id' ) ) :
function wcd_get_current_order_id() {

	global $wp_query;

	$post_id = get_the_ID();

	if ( get_post_type( $post_id ) == 'shop_order' ) {    	
    	return $post_id;		
	}


	elseif ( isset( $wp_query->query ) && isset( $wp_query->query['order-received'] ) ) {
		return $wp_query->query['order-received'];
	}

	/**
	 * The last hope
	 * @author Nazmul Ahsan
	 */
	elseif( is_user_logged_in() ) {
		$customer 	= new \WC_Customer( get_current_user_id() );
		$last_order = $customer->get_last_order();

		if ( is_a( $last_order, 'WC_Order' ) ) {
			return $last_order->get_id();
		}
		return false;
	}
	
	return false;
}
endif;

/**
 * Return list of woocommerce order edit page hooks
 *
 * @since 3.0
 * @author al imran akash <alimranakash@gmail.com>
 */
if( !function_exists( 'wcd_get_template_css' ) ) :
function wcd_get_template_css( $template_id ) {
	$css_files = [];
	$css_files[] = trailingslashit( ELEMENTOR_ASSETS_URL ) . 'css/frontend.min.css';
	$css_files[] = trailingslashit( ELEMENTOR_ASSETS_URL ) . 'css/common.min.css';
	$css_files[] = trailingslashit( ELEMENTOR_ASSETS_URL ) . 'lib/font-awesome/css/font-awesome.min.css';
	$css_files[] = trailingslashit( ELEMENTOR_ASSETS_URL ) . 'lib/eicons/css/elementor-icons.min.css';
	$css_files[] = trailingslashit( ELEMENTOR_ASSETS_URL ) . 'lib/font-awesome/css/solid.min.css';
	$css_files[] = trailingslashit( ELEMENTOR_ASSETS_URL ) . 'lib/font-awesome/css/brands.min.css';
	$css_files[] = trailingslashit( WOOLEMENTOR_ASSETS ) . 'css/front.css';
	$css_files[] = trailingslashit( WOOLEMENTOR_ASSETS ) . 'css/cx-grid.css';

	global $wp_styles;
	foreach( $wp_styles->queue as $_style ) :
		$css_files[] = $wp_styles->registered[ $_style ]->src;
	endforeach;

	$css = '';
	foreach ( $css_files as $css_file ) {
		if( strpos( $css_file, 'admin-bar.min.css' ) == false ) {
			$css .= file_get_contents( $css_file );
		}
	}

	$css .= str_replace( 'display:flex', 'display:flex; width:100%', $css );

	// some common error fix
	$css .= ".elementor-widget-container{width:100%;}table {border-spacing: 0;border-collapse: collapse;width:100%}table td{width:200px;padding:10px; border: 1px solid #000}";

	// rewrite post css stuff
	$upload_dir = wp_get_upload_dir();
	$post_css = file_get_contents( "{$upload_dir['basedir']}/elementor/css/post-{$template_id}.css" );
	$post_css = preg_replace( '/@media\(min-width:\d+px\)\{/', '', $post_css );
	$post_css = str_replace( '}}', '}', $post_css );
	$css .= $post_css;

	return $css;
}
endif;

/**
 * Order options used for product query
 *
 * @since 3.0
 * @author al imran akash <alimranakash@gmail.com>
 *
 * @return pages
 */
if( !function_exists( 'wcd_get_pages' ) ) :
function wcd_get_pages() {

	$_pages = get_pages();

	$pages 	= [ '0' => __( '- Choose a page -', 'woolementor-pro' ) ];
	foreach( $_pages as $page ) :
		$pages[ $page->ID ] = $page->post_title;
	endforeach;

	return apply_filters( 'wcd_get_pages', $pages );
}
endif;

/**
 * List of conditions
 *
 * @since 1.0
 *
 * @return []
 */
if( !function_exists( 'wcd_show_content_to' ) ) :
function wcd_show_content_to() {

	$rules = [
		'user'  		=> __( 'User Status', 'woolementor-pro' ),
		'user_id' 		=> __( 'User ID', 'woolementor-pro' ),
		'user_role' 	=> __( 'User Role', 'woolementor-pro' ),
		'date_time' 	=> __( 'Date Time', 'woolementor-pro' ),
		'query_string' 	=> __( 'Query String', 'woolementor-pro' ),
		'customer_purchased' => __( 'Customer\'s Product', 'woolementor-pro' ),
		'customer_order' => __( 'Customer\'s Order', 'woolementor-pro' ),
	];

	return apply_filters( 'wcd_show_content_to', $rules );
}
endif;

/**
 * List of user roles
 *
 * @since 1.0
 *
 * @return []
 */
if( !function_exists( 'wcd_show_content_to_roles' ) ) :
function wcd_show_content_to_roles() {

	global $wp_roles;

	if( empty( $wp_roles ) ) return [];
	$all_roles = $wp_roles->roles;
	$roles = [];

	foreach ( $all_roles as $key => $role ) {
		$roles[ $key ] = $role['name'];
	}

	return $roles;

	return apply_filters( 'wcd_user_roles_to_show_content', $roles );
}
endif;

/**
 * Renders the output based on settings
 *
 * @since 1.0
 *
 * @return string
 */
if( !function_exists( 'wcd_render_message' ) ) :
function wcd_render_message( $settings, $echo = true ) {

	$message = '';

	if( !isset( $settings['show_message'] ) || $settings['show_message'] == 'text' ) {;

		$message = isset( $settings['message_text'] ) ? $settings['message_text'] : '';

	}

	if( !isset( $settings['show_message'] ) || $settings['show_message'] == 'template' ) {
		if ( isset( $settings['message_template'] ) && $settings['message_template'] != '' ) {
			$elementor_instance = \Elementor\Plugin::instance();
			$message = $elementor_instance->frontend->get_builder_content_for_display( $settings['message_template']  );
		}
	}

	if ( $echo ) {
		echo $message;
		return;
	}

	return $message;
}
endif;

/**
 * Get All orders IDs for a given product ID.
 *
 * @param  array  $product_ids (required)
 * @param  array    $order_status (optional) Default is 'wc-completed'
 * 
 * @since 3.0.0
 * 
 * @author Jakaria Istauk <jakariamd35@gmail.com>
 * @source https://stackoverflow.com/questions/45848249/woocommerce-get-all-orders-for-a-product
 * 
 * @return array
 */
function wcd_get_product_orders( $product_ids, $order_status = array( 'wc-completed' ), $user_id = 0 ){
    global $wpdb;

    $left_join = $sql_extention = '';

    if ( $user_id && $user_id != 0 ) {
    	$user_id = codesigner_sanitize_number( $user_id );
    	$left_join .= "LEFT JOIN {$wpdb->postmeta} AS meta ON order_items.order_id = meta.post_id";
    	$sql_extention .= "AND meta.meta_key = '_customer_user' AND meta.meta_value = {$user_id}";

    }

    $sql = "
        SELECT order_items.order_id
        FROM {$wpdb->prefix}woocommerce_order_items as order_items
        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
        LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
        {$left_join}
        WHERE posts.post_type = 'shop_order' 
        {$sql_extention}
        AND posts.post_status IN ( '" . implode( "','", $order_status ) . "' )
        AND order_items.order_item_type = 'line_item'
        AND order_item_meta.meta_key = '_product_id'
        AND order_item_meta.meta_value IN ( '" . implode( "','", $product_ids ) . "' )
    ";

    $results = $wpdb->get_col( $sql );

    return $results;
}

/**
 * Renders the output based on settings
 *
 * @since 3.0
 * 
 * @author Jakaria Istauk <jakariamd35@gmail.com>
 *
 * @return string
 */
if( !function_exists( 'wcd_is_eligible' ) ) :
function wcd_is_eligible( $settings ) {

	$should_render 	= false;
	$order_status 	= function_exists( 'wc_get_order_statuses' ) ? wc_get_order_statuses() : [];
	$condition_list = $settings['woolementor_condition_list'];
	$current_user_id = get_current_user_id();
	$condition_count = 0;
	foreach ( $condition_list as $key => $condition_set ) {
		$this_condition = false;
		if ( $condition_set['condition_base'] == 'user' && $condition_set['is_user'] == 'loggedin' && is_user_logged_in() ) {
			$this_condition = true;
		}
		else if ( $condition_set['condition_base'] == 'user' && $condition_set['is_user'] == 'loggedout' && !is_user_logged_in() ) {
			$this_condition = true;
		}
		else if ( $condition_set['condition_base'] == 'user_id' && is_user_logged_in() && $condition_set['is_user_id'] == $current_user_id ) {
			$this_condition = true;
		}
		else if ( $condition_set['condition_base'] == 'user_role' && is_user_logged_in() ) {
			$user = wp_get_current_user();
			$roles = ( array ) $user->roles;
			if ( in_array( $condition_set['is_user_role'], $roles ) ) {
				$this_condition = true;
			}

		}
		else if ( $condition_set['condition_base'] == 'date_time' ) {
			$given_date = $condition_set['date'];
			$given_date = strtotime( $given_date );
			$relation   = $condition_set['date_condition'];
			$now 		= time();

			$this_condition = ( $relation == 'greater_than' && $now > $given_date ) || ( $relation == 'less_than' && $now < $given_date );
		}
		else if ( $condition_set['condition_base'] == 'query_string' ) {
			global $wp_query;
			$query_string 	= $wp_query->query_vars + $_GET;
			$query_key 	 	= $condition_set['query_key'];
			$query_value 	= $condition_set['query_value'];
			$relation   	= $condition_set['query_relation'];
			
			$this_condition = ( $relation == 'equal' && array_key_exists( $query_key, $query_string ) && $query_string[ $query_key ] == $query_value ) || ( $relation == 'not_equal' && array_key_exists( $query_key, $query_string ) && $query_string[ $query_key ] != $query_value ) || ( $relation == 'greater_than' && array_key_exists( $query_key, $query_string ) && $query_string[ $query_key ] > $query_value ) || ( $relation == 'less_than' && array_key_exists( $query_key, $query_string ) && $query_string[ $query_key ] < $query_value );
		}
		else if ( $condition_set['condition_base'] == 'customer_purchased' ) {
			$product_ids = $condition_set['product_ids'];
			if ( $product_ids ) {
				$_product_ids = explode(',', $product_ids);
				$product_ids  = [];
				foreach ( $_product_ids as $key => $id ) {
					$product_ids[] = codesigner_sanitize_number( $id );
				}
				$orders 		= wcd_get_product_orders( $product_ids, array_keys( $order_status ), $current_user_id );
				$is_user_logged_in = is_user_logged_in();
				$this_condition = ( $condition_set['purchased'] == 'purchased' && !empty( $orders ) && $is_user_logged_in ) || ( $condition_set['purchased'] == 'not_purchased' && ( empty( $orders ) || !$is_user_logged_in ) );
			}
		}
		else if ( $condition_set['condition_base'] == 'customer_order' ) {
			$statuses 	= $condition_set['order_status'];
			$orders 	= wc_get_orders(array(
			    'customer_id' => $current_user_id,
			    'return' => 'ids',
			    'status' => $statuses,
			) );

			if( !empty( $orders ) ) $this_condition = true;
		}

		if( $condition_count == 0 && $this_condition ){
			$should_render = true;
		}

		if ( $condition_count > 0 ) {
			if ( $condition_set['conditions_relation'] == 'and' ) {
				$should_render = $should_render && $this_condition;
			}
			else{
				$should_render = $should_render || $this_condition;
			}
		}
		$condition_count++;
	}

	return $should_render;
}
endif;


/**
 * Order options used for product query
 *
 * @since 1.0
 *
 * @return []
 */
if( !function_exists( 'wcd_product_options' ) ) :
function wcd_product_options() {
	$options = [
        'name' 				=> __( 'Name', 'woolementor' ),
        'price' 			=> __( 'Price', 'woolementor' ),
        'description' 		=> __( 'Description', 'woolementor' ),
        'short_desc' 		=> __( 'Short Description', 'woolementor' ),
        'rating' 			=> __( 'Rating', 'woolementor' ),
        'review_count' 		=> __( 'Review Count', 'woolementor' ),
        'link' 				=> __( 'Link', 'woolementor' ),
    ];

    return apply_filters( 'woolementor-product_options', $options );
}
endif;