<?php
get_header();
$template_id = wcd_get_archive_template_id( 'wl-single' );
if ( !is_null( $template_id ) ) {
	$elementor_instance = \Elementor\Plugin::instance();
	echo $elementor_instance->frontend->get_builder_content_for_display( $template_id );
}
get_footer();
?>