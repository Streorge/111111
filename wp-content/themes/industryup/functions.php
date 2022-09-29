<?php define( 'INDUSTRYUP_THEME_DIR', get_template_directory() . '/' );
	define( 'INDUSTRYUP_THEME_URI', get_template_directory_uri() . '/' );
	define( 'INDUSTRYUP_THEME_SETTINGS', 'industryup-settings' );
	
	
	$industryup_theme_path = get_template_directory() . '/inc/ansar/';

	require( $industryup_theme_path . '/industryup-custom-navwalker.php' );
	require( $industryup_theme_path . '/default_menu_walker.php' );
	require( $industryup_theme_path . '/font/font.php');
	require( $industryup_theme_path . '/customize/industryup_plugin_recommend.php');
	/*-----------------------------------------------------------------------------------*/
	/*	Enqueue scripts and styles.
	/*-----------------------------------------------------------------------------------*/
	require( $industryup_theme_path .'/enqueue.php');
	/* ----------------------------------------------------------------------------------- */
	/* Customizer */
	/* ----------------------------------------------------------------------------------- */
	
	require( $industryup_theme_path  . '/customize/industryup_customize_general.php');
	require( $industryup_theme_path . '/customize/industryup_customize_copyright.php');
	require( $industryup_theme_path  . '/customize/industryup_customize_header.php');
	require( $industryup_theme_path  . '/customize/industryup_customize_archive.php');
	require( $industryup_theme_path  . '/customize/industryup_customize_sections.php');
	require_once( trailingslashit( get_template_directory() ) . 'inc/ansar/customize-pro/class-customize.php' );
	require_once( trailingslashit( get_template_directory() ) . 'inc/ansar/customize/industryup_customize_partials.php' );
	require_once get_template_directory() . '/inc/ansar/industryup-admin-plugin-install.php';

	//Hooks
	require_once get_template_directory().'/inc/ansar/hooks/header/logomenu.php';


	$industryup_theme_start = wp_get_theme();
	if (( 'Industryup' == $industryup_theme_start->name))  {
	if ( is_admin() ) {
		require ($industryup_theme_path . '/admin/getting-started.php');
	}
	}


	// Theme version.
	$industryup_theme = wp_get_theme();
	define( 'INDUSTRYUP_THEME_VERSION', $industryup_theme->get( 'Version' ) );
	define( 'INDUSTRYUP_THEME_NAME', $industryup_theme->get( 'Name' ) );
	
if ( ! function_exists( 'industryup_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function industryup_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on industryup, use a find and replace
	 * to change 'industryup' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'industryup', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary menu', 'industryup' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'industryup_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

    // Set up the woocommerce feature.
    add_theme_support( 'woocommerce');

    // Woocommerce Gallery Support
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

    // Added theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/* Add theme support for gutenberg block */
	add_theme_support( 'align-wide' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );
	
	//Custom logo
	
	//Custom logo
	add_theme_support(
    'custom-logo',
    array(
        'unlink-homepage-logo' => true, // Add Here!
    	)
	);
	
	// custom header Support
			$args = array(
			'default-image'		=>  get_template_directory_uri() .'/images/sub-header.jpg',
			'width'			=> '1600',
			'height'		=> '600',
			'flex-height'		=> false,
			'flex-width'		=> false,
			'header-text'		=> true,
			'default-text-color'	=> 'fff',
			'wp-head-callback' => 'industryup_header_color',
		);
		add_theme_support( 'custom-header', $args );
	

}
endif;
add_action( 'after_setup_theme', 'industryup_setup' );


	function industryup_the_custom_logo() {
	
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}

	}

	add_filter('get_custom_logo','industryup_logo_class');


	function industryup_logo_class($html)
	{
	$html = str_replace('custom-logo-link', 'navbar-brand', $html);
	return $html;
	}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function industryup_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'industryup_content_width', 640 );
}
add_action( 'after_setup_theme', 'industryup_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function industryup_widgets_init() {
	
	$industryup_footer_column_layout = get_theme_mod('industryup_footer_column_layout',3);
	
	$industryup_footer_column_layout = 12 / $industryup_footer_column_layout;
	
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Widget Area', 'industryup' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="bs-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6>',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area', 'industryup' ),
		'id'            => 'footer_widget_area',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="col-md-'.$industryup_footer_column_layout.' col-sm-6 rotateInDownLeft animated bs-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6>',
		'after_title'   => '</h6>',
	) );

}
add_action( 'widgets_init', 'industryup_widgets_init' );

//Editor Styling 
add_editor_style( array( 'css/editor-style.css') );

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 *
	 * @since Twenty Nineteen 1.4
	 */
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 *
		 * @since Twenty Nineteen 1.4
		 */
		do_action( 'wp_body_open' );
	}
endif;

add_filter( 'woocommerce_show_page_title', 'industryup_hide_shop_page_title' );

function industryup_hide_shop_page_title( $title ) {
    if ( is_shop() ) $title = false;
    return $title;
}