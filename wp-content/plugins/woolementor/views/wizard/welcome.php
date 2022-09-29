<?php 
$user 		= wp_get_current_user();
$user_name 	= $user->display_name;

echo '
<div class="setup-wizard-welcome-panel">
	<img src="'. WOOLEMENTOR_ASSETS . '/img/icon-128.png' .'">
	<h1 class="cx-welcome">Welcome to CoDesigner!</h1>
	<p class="cx-wizard-sub">' . sprintf( __( 'Thanks for installing CoDesigner, %s. We\'re so happy to have you with us.', 'woolementor' ), $user_name ) . '</p>

	<p class="cx-wizard-sub">' . __( 'This wizard will help you confiure the basic things needed to get started. It won\'t take more than a minute!', 'woolementor' ) . '
	</p>
</div>';

// set flag
update_option( 'woolementor_setup_done', 1 );