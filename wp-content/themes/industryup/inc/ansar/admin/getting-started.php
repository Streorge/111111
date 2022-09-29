<?php
/**
 * Getting Started Page. 
 *
 * @package Industryup
 */
require get_template_directory() . '/inc/ansar/admin/class-getting-start-plugin-helper.php';


// Adding Getting Started Page in admin menu

if( ! function_exists( 'industryup_getting_started_menu' ) ) :
function industryup_getting_started_menu() {	
		$plugin_count = null;
		if ( !is_plugin_active( 'shortbuild/shortbuild.php' ) ):	
			$plugin_count =	'<span class="awaiting-mod action-count">1</span>';
		endif;
	    /* translators: %1$s %2$s: about */		
		$title = sprintf(esc_html__('About %1$s %2$s', 'industryup'), esc_html( INDUSTRYUP_THEME_NAME ), $plugin_count);
		/* translators: %1$s: welcome page */	
		add_theme_page(sprintf(esc_html__('Welcome to %1$s', 'industryup'), esc_html( INDUSTRYUP_THEME_NAME ), esc_html(INDUSTRYUP_THEME_VERSION)), $title, 'edit_theme_options', 'industryup-getting-started', 'industryup_getting_started_page');
}
endif;
add_action( 'admin_menu', 'industryup_getting_started_menu' );

// Load Getting Started styles in the admin
if( ! function_exists( 'industryup_getting_started_admin_scripts' ) ) :
function industryup_getting_started_admin_scripts( $hook ){
	// Load styles only on our page
	if( 'appearance_page_industryup-getting-started' != $hook ) return;

    wp_enqueue_style( 'industryup-getting-started', get_template_directory_uri() . '/inc/ansar/admin/css/getting-started.css', false, INDUSTRYUP_THEME_VERSION );
    wp_enqueue_script( 'plugin-install' );
    wp_enqueue_script( 'updates' );
    wp_enqueue_script( 'industryup-getting-started', get_template_directory_uri() . '/inc/ansar/admin/js/getting-started.js', array( 'jquery' ), INDUSTRYUP_THEME_VERSION, true );
    wp_enqueue_script( 'industryup-recommended-plugin-install', get_template_directory_uri() . '/inc/ansar/admin/js/recommended-plugin-install.js', array( 'jquery' ), INDUSTRYUP_THEME_VERSION, true );    
    wp_localize_script( 'industryup-recommended-plugin-install', 'industryup_start_page', array( 'activating' => __( 'Activating ', 'industryup' ) ) );
}
endif;
add_action( 'admin_enqueue_scripts', 'industryup_getting_started_admin_scripts' );


// Plugin API
if( ! function_exists( 'industryup_call_plugin_api' ) ) :
function industryup_call_plugin_api( $slug ) {
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		$call_api = get_transient( 'industryup_about_plugin_info_' . $slug );

		if ( false === $call_api ) {
				$call_api = plugins_api(
					'plugin_information', array(
						'slug'   => $slug,
						'fields' => array(
							'downloaded'        => false,
							'rating'            => false,
							'description'       => false,
							'short_description' => true,
							'donate_link'       => false,
							'tags'              => false,
							'sections'          => true,
							'homepage'          => true,
							'added'             => false,
							'last_updated'      => false,
							'compatibility'     => false,
							'tested'            => false,
							'requires'          => false,
							'downloadlink'      => false,
							'icons'             => true,
						),
					)
				);
				set_transient( 'industryup_about_plugin_info_' . $slug, $call_api, 30 * MINUTE_IN_SECONDS );
			}

			return $call_api;
		}
endif;

// Callback function for admin page.
if( ! function_exists( 'industryup_getting_started_page' ) ) :
function industryup_getting_started_page() { ?>
	<div class="wrap getting-started">
		<h2 class="notices"></h2>
		<div class="intro-wrap">
			<div class="intro">
				<h3>
				<?php 
				/* translators: %1$s %2$s: welcome message */	
				printf( esc_html__( 'Welcome to %1$s - Version %2$s', 'industryup' ), esc_html( INDUSTRYUP_THEME_NAME ), esc_html( INDUSTRYUP_THEME_VERSION ) ); ?></h3>
			</div>
			<div class="intro right">
				<a target="_blank" href="https://themeansar.com/"><img src="<?php echo esc_url(get_template_directory_uri());  ?>/inc/ansar/admin/images/logo.png"></a>
			</div>
		</div>
		<div class="panels">
			<ul class="inline-list">
			    <li class="current">
					<a id="getting-started-panel" href="#">
						<?php esc_html_e( 'Getting Started', 'industryup' ); ?>
					</a>
				</li>
				<li class="recommended-plugins-active">
					<a id="plugins" href="#">
						<?php esc_html_e( 'Elementor Demo', 'industryup' ); 
						if ( !is_plugin_active( 'shortbuild/shortbuild.php' ) ):  ?>
							<span class="plugin-not-active">1</span>
						<?php endif; ?>
					</a>
				</li>
			</ul>
			<div id="panel" class="panel">
				<?php require get_template_directory() . '/inc/ansar/admin/tabs/getting-started-panel.php'; ?>
				<?php require get_template_directory() . '/inc/ansar/admin/tabs/recommended-plugins-panel.php'; ?>
			</div>
		</div>
	</div>
	<?php
}
endif;