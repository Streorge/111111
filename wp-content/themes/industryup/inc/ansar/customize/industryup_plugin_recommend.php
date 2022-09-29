<?php
/* Notify in customizer */
require get_template_directory() . '/inc/ansar/customizer-notice/industryup-customizer-notify.php';

$config_customizer = array(
	'recommended_plugins'       => array(
		'icyclub' => array(
			'recommended' => true,
			'description' => sprintf('Activate by installing <strong>ICYCLUB</strong> plugin to use front page and all theme features %s.', 'industryup'),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'industryup' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'industryup' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'industryup' ),
	'activate_button_label'     => esc_html__( 'Activate', 'industryup' ),
	'deactivate_button_label'   => esc_html__( 'Deactivate', 'industryup' ),
);
Industryup_Customizer_Notify::init( apply_filters( 'industryup_customizer_notify_array', $config_customizer ) );