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
 * @subpackage Common
 * @author codexpert <hello@codexpert.io>
 */
class Common extends Base {

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

	public function ajax_filter_pre_posts( $query ) {
		if ( defined('DOING_AJAX') && DOING_AJAX ) {
		 	if ( isset( $_POST['action'] ) && $_POST['action'] == 'ajax-filter' ) {
		 		if( !empty( $_POST['filter']['taxonomies'] ) ) {
					$taxonomies = [];
					foreach ( $_POST['filter']['taxonomies'] as $key => $term ) {
				        $taxonomies[] = array(
				          'taxonomy' => sanitize_text_field( $key ),
				          'field'    => 'slug',
				          'terms'    => array_map( 'sanitize_text_field', $term )
				        );
					}
					$query->set( 'tax_query', $taxonomies );
				}

				if ( isset( $_POST['filter']['max_price'] ) && $_POST['filter']['max_price'] != '' && isset( $_POST['filter']['min_price'] ) && $_POST['filter']['min_price'] != '' ) {
					$max_price = codesigner_sanitize_number( $_POST['filter']['max_price'] );
					$min_price = codesigner_sanitize_number( $_POST['filter']['min_price'] );

			       	$meta_query[] = array(
				          'key' 	=> '_price',
			              'value' 	=> [ $min_price, $max_price ],
			              'compare' => 'BETWEEN',
			              'type' 	=> 'NUMERIC'
			        );
			        $default_metaq = $query->meta_query ? $query->meta_query : [];
					$query->set( 'meta_query', array_merge( $default_metaq, $meta_query ) );
				}

				if ( isset( $_POST['filter']['orderby'] ) ) {					
					$orderby = sanitize_text_field( $_POST['filter']['orderby'] );
					$args['orderby']	= $orderby;
					$query->set( 'orderby', $orderby );

				    if( in_array( $orderby, [ '_price', 'total_sales', '_wc_average_rating' ] ) ) {
				    	$args['meta_key']	= $orderby;
				    	$args['orderby'] 	= 'meta_value_num';
						$query->set( 'meta_key', $orderby );
						$query->set( 'orderby', 'meta_value_num' );
				    }
				}

		    	if( isset( $_POST['filter']['order'] ) ) {
			        $order	= sanitize_text_field( $_POST['filter']['order'] );
					$query->set( 'order', $order );
			    }


		    	if( isset( $_POST['paged'] ) ) {
			        $url = parse_url( sanitize_text_field( $_POST['paged'] ), PHP_URL_QUERY );
					parse_str( $url, $paged );
					$current_page = isset( $paged['paged'] ) ? codesigner_sanitize_number( $paged['paged'] ) : 1;
					$query->set( 'paged', $current_page );
			    }

			    if( isset( $_POST['filter']['q'] ) ) {
			        $q		= sanitize_text_field( $_POST['filter']['q'] );
					$query->set( 's', $q );
			    }
		 	}
		}
		return $query;
	}
}