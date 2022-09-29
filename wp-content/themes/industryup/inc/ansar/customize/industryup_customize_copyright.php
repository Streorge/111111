<?php // Footer copyright section 
function industryup_footer_copyright( $wp_customize ) {
	$wp_customize->add_panel('industryup_copyright', array(
		'priority' => 5,
		'capability' => 'edit_theme_options',
		'title' => __('Footer Settings', 'industryup'),
	) );

    $wp_customize->add_section('footer_social_icon', array(
        'title' => __('Social Icons','industryup'),
        'priority' => 20,
        'panel' => 'industryup_copyright',
    ) );
	
	
	//Enable and disable social icon
	$wp_customize->add_setting(
	'footer_social_icon_enable'
    ,
    array(
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'industryup_social_sanitize_checkbox',
    )	
	);
	$wp_customize->add_control(
    'footer_social_icon_enable',
    array(
        'label' => __('Hide / Show','industryup'),
        'section' => 'footer_social_icon',
        'type' => 'checkbox',
    )
	);

	// Soical facebook link
	$wp_customize->add_setting(
    'industryup_footer_fb_link',
    array(
		'sanitize_callback' => 'esc_url_raw',
    )
	
	);
	$wp_customize->add_control(
    'industryup_footer_fb_link',
    array(
        'label' => __('Facebook URL','industryup'),
        'section' => 'footer_social_icon',
        'type' => 'text',
    )
	);

	$wp_customize->add_setting(
	'industryup_footer_fb_target',array(
	'sanitize_callback' => 'industryup_social_sanitize_checkbox',
	'default' => 1,
	));

	$wp_customize->add_control(
    'industryup_footer_fb_target',
    array(
        'type' => 'checkbox',
        'label' => __('Open link in a new tab','industryup'),
        'section' => 'footer_social_icon',
    )
	);
	
	
	//Social Twitter link
	$wp_customize->add_setting(
    'industryup_footer_twt_link',
    array(
		'sanitize_callback' => 'esc_url_raw',
    )
	
	);
	$wp_customize->add_control(
    'industryup_footer_twt_link',
    array(
        'label' => __('Twitter URL','industryup'),
        'section' => 'footer_social_icon',
        'type' => 'text',
    )
	);

	$wp_customize->add_setting(
	'industryup_footer_twt_target',array(
	'sanitize_callback' => 'industryup_social_sanitize_checkbox',
	'default' => 1,
	));

	$wp_customize->add_control(
    'industryup_footer_twt_target',
    array(
        'type' => 'checkbox',
        'label' => __('Open link in a new tab','industryup'),
        'section' => 'footer_social_icon',
    )
	);
	
	//Soical Linkedin link
	$wp_customize->add_setting(
    'industryup_footer_lnkd_link',
    array(
		'sanitize_callback' => 'esc_url_raw',
    )
	
	);
	$wp_customize->add_control(
    'industryup_footer_lnkd_link',
    array(
        'label' => __('Linkedin URL','industryup'),
        'section' => 'footer_social_icon',
        'type' => 'text',
    )
	);

	$wp_customize->add_setting(
	'industryup_footer_lnkd_target',array(
	'default' => 1,
	'sanitize_callback' => 'industryup_social_sanitize_checkbox',
	));

	$wp_customize->add_control(
    'industryup_footer_lnkd_target',
    array(
        'type' => 'checkbox',
        'label' => __('Open link in a new tab','industryup'),
        'section' => 'footer_social_icon',
    )
	);
	
	
	//Soical Instagram link
	$wp_customize->add_setting(
    'industryup_footer_insta_link',
    array(
		'sanitize_callback' => 'esc_url_raw',
    )
	
	);
	$wp_customize->add_control(
    'industryup_footer_insta_link',
    array(
        'label' => __('Instagram URL','industryup'),
        'section' => 'footer_social_icon',
        'type' => 'text',
    )
	);

	$wp_customize->add_setting(
	'industryup_footer_indta_target',array(
	'default' => 1,
	'sanitize_callback' => 'industryup_social_sanitize_checkbox',
	));

	$wp_customize->add_control(
    'industryup_footer_indta_target',
    array(
        'type' => 'checkbox',
        'label' => __('Open link in a new tab','industryup'),
        'section' => 'footer_social_icon',
    )
	);

	
	$wp_customize->add_section('footer_widget_back', array(
        'title' => __('Background','industryup'),
        'priority' => 30,
        'panel' => 'industryup_copyright',
    ) );
    
    
    
     //Funfact Background image
    $wp_customize->add_setting( 
        'industryup_footer_widget_background', array(
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'industryup_footer_widget_background', array(
        'label'    => __( 'Background Image', 'industryup' ),
        'section'  => 'footer_widget_back',
        'settings' => 'industryup_footer_widget_background',
    ) ) );

	
	$wp_customize->add_section('footer_widget_column', array(
        'title' => __('Widget column layout','industryup'),
        'priority' => 30,
		'panel' => 'industryup_copyright',
    ) );
	
	
	
	 $wp_customize->add_setting(
                'industryup_footer_column_layout', array(
                'default' => 3,
                'sanitize_callback' => 'industryup_sanitize_select',
            ) );

            $wp_customize->add_control(
                'industryup_footer_column_layout', array(
                'type' => 'select',
                'label' => __('Select Column Layout','industryup'),
                'section' => 'footer_widget_column',
                'choices' => array(1=>1, 2=>2,3=>3,4=>4),
	) );
	
	$wp_customize->add_section('footer social icon', array(
        'title' => __('Footer social icon','industryup'),
        'priority' => 40,
		'panel' => 'industryup_copyright',
    ) );
	
	function industryup_social_sanitize_checkbox( $input ) {
			// Boolean check 
			return ( ( isset( $input ) && true == $input ) ? true : false );
			}



	
	
			
	if ( ! function_exists( 'industryup_sanitize_select' ) ) :

	/**
	 * Sanitize select.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed                $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return mixed Sanitized value.
	 */
	function industryup_sanitize_select( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

	}

endif;		
}
add_action( 'customize_register', 'industryup_footer_copyright' );

function industryup_customize_partial_industryup_footer_fb_link() {
    return get_theme_mod( 'industryup_footer_fb_link' );
}