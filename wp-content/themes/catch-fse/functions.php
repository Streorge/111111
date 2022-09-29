<?php
/**
 * Catch FSE functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Catch_FSE
 * @since 1.0
 */

if ( ! function_exists( 'catch_fse_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function catch_fse_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'catch_fse_support' );

if ( ! function_exists( 'catch_fse_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function catch_fse_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_enqueue_style(
			'catch-fse-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Add styles inline.
		wp_add_inline_style( 'catch-fse-style', catch_fse_get_font_face_styles() );
	}

endif;

add_action( 'wp_enqueue_scripts', 'catch_fse_styles' );

if ( ! function_exists( 'catch_fse_editor_styles' ) ) :

	/**
	 * Enqueue editor styles.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function catch_fse_editor_styles() {

		// Add styles inline.
		wp_add_inline_style( 'wp-block-library', catch_fse_get_font_face_styles() );

	}

endif;

add_action( 'admin_init', 'catch_fse_editor_styles' );


if ( ! function_exists( 'catch_fse_get_font_face_styles' ) ) :

	/**
	 * Get font face styles.
	 * Called by functions catch_fse_styles() and catch_fse_editor_styles() above.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	function catch_fse_get_font_face_styles() {

		return "
		@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
		";

	}

endif;

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

// Add block styles
require get_template_directory() . '/inc/block-styles.php';

// Block Filters
require get_template_directory() . '/inc/block-filters.php';

// Svg icons
require get_template_directory() . '/inc/icon-function.php';

// Theme About Page
require get_template_directory() . '/inc/about.php';

// Include Upgrade Button
require get_template_directory() . '/inc/upgrade-button/class-customize.php';
