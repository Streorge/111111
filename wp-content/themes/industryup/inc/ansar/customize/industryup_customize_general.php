<?php
function industryup_general_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

    /* General Section */
    $wp_customize->add_panel( 'general_options', array(
        'priority' => 3,
        'capability' => 'edit_theme_options',
        'title' => __('General Settings', 'industryup'),
    ) );

    //Logo and Background color settings
    $wp_customize->add_section(
        'colors',
        array(
            'priority'      => 1,
            'title'         => __('Colors','industryup'),
            'panel'         => 'general_options',
        )
    );

    $wp_customize->add_section(
        'header_image',
        array(
            'priority'      => 2,
            'title'         => __('Breadcrumb','industryup'),
            'panel'         => 'general_options',
        )
    );

    $wp_customize->add_setting( 
        'breadcrumb_display' , 
            array(
            'default' => '1',
            'sanitize_callback' => 'industryup_general_sanitize_checkbox',
            'capability' => 'edit_theme_options',
            'priority' => 1,
        ) 
    );
    
    $wp_customize->add_control(
    'breadcrumb_display', 
        array(
            'label'       => esc_html__( 'Hide / Show', 'industryup' ),
            'section'     => 'header_image',
            'type'        => 'checkbox'
        ) 
    );

    $wp_customize->add_setting( 
        'breadcrumb_img_type_display' , 
            array(
            'default' => 'scroll',
            'capability'     => 'edit_theme_options',
            'sanitize_callback' => 'industryup_sanitize_select',
            'priority'  => 10,
        ) 
    );
    
    $wp_customize->add_control(
    'breadcrumb_img_type_display' , 
        array(
            'label'          => __( 'Background Attachment', 'industryup' ),
            'section'        => 'header_image',
            'type'           => 'select',
            'choices'        => 
            array(
                'inherit' => __( 'Inherit', 'industryup' ),
                'scroll' => __( 'Scroll', 'industryup' ),
                'fixed'   => __( 'Fixed', 'industryup' )
            ) 
        ) 
    );

    $wp_customize->add_setting('industryup_title_font_size',
        array(
            'default'           => 34,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control('industryup_title_font_size',
        array(
            'label'    => esc_html__('Site Title Size', 'industryup'),
            'section'  => 'title_tagline',
            'type'     => 'number',
            'priority' => 50,
        )
    );

    }
add_action( 'customize_register', 'industryup_general_setting' );



function industryup_general_sanitize_checkbox( $input ) {
            // Boolean check 
    return ( ( isset( $input ) && true == $input ) ? true : false );
    
    }
add_action( 'customize_register', 'industryup_general_sanitize_checkbox' );


function industryup_sanitize_select( $input, $setting ) {
    
    // Ensure input is a slug.
    $input = sanitize_key( $input );
    
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;
    
    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}