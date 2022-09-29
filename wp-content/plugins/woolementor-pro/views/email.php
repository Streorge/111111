<?php
use Elementor\Plugin as Elementor;

// store the order to be used in the widget
$_REQUEST['order'] = $order;

// get the template ID from global var
$template_id = codesigner_sanitize_number( $_REQUEST['template_id'] );

$html = Elementor::$instance->frontend->get_builder_content( $template_id );

echo "<div id='wl-mail-container'>{$html}</div>";