<?php
$industryup_repeater_path = trailingslashit( INDUSTRYUP_THEME_DIR ) . '/inc/ansar/customizer-repeater/functions.php';
if ( file_exists( $industryup_repeater_path ) ) {
require_once( $industryup_repeater_path );
}
/**
 * Customize for taxonomy with dropdown, extend the WP customizer
 */

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

function industryup_frontpage_section_settings( $wp_customize ){

$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	/* Sections Settings */
	/* Frontpage Section */
	$wp_customize->add_panel( 'homepage_sections', array(
		'priority' => 4,
		'capability' => 'edit_theme_options',
		'title' => __('Homepage section settings', 'industryup'),
	) );
}
add_action( 'customize_register', 'industryup_frontpage_section_settings' );