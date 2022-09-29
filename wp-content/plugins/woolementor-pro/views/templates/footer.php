<?php

$template_id = wcd_get_archive_template_id( 'wl-footer' );
if ( !is_null( $template_id ) ) {
	$elementor_instance = \Elementor\Plugin::instance();
	echo $elementor_instance->frontend->get_builder_content_for_display( $template_id );

	/**
	* Override Footer
	*/
	do_action( 'wl-footer' );
	wp_footer();

	echo "</body>
	</html> ";

	$templates   = [];
	$templates[] = 'footer.php';

	// Avoid running wp_footer hooks again.
	remove_all_actions( 'wp_footer' );
	ob_start();
	locate_template( $templates, true );
	ob_get_clean();
}



