<?php
/**
 * Override Header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php 
do_action( 'wp_body_open' );
do_action( 'wl-header' ); 

$template_id = wcd_get_archive_template_id( 'wl-header' );
if ( !is_null( $template_id ) ) {
	$elementor_instance = \Elementor\Plugin::instance();
	echo $elementor_instance->frontend->get_builder_content_for_display( $template_id );

	// global $post;
	// if( get_post_meta( $post->ID, '_elementor_template_type', true ) == 'wl-header' ) {
		$templates   = [];
		$templates[] = 'header.php';

		// Avoid running wp_head hooks again.
		remove_all_actions( 'wp_head' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	// }
}