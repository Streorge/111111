<?php

$plugins = [];
$all_plugins = get_plugins();

if( ! array_key_exists( 'image-sizes/image-sizes.php', $all_plugins ) ){
		$plugins['image-sizes']  = [
			'label'	=> __( 'Stop Generating Unnecessary Thumbnails', 'woolementor' ),
			'desc'	=> __( 'WordPress generates these 4 image sizes- Thumbnail, Medium, Medium-large, Large. Disable the ones which you don’t need. ', 'woolementor' ),
		];
	}

if ( array_key_exists( 'woocommerce/woocommerce.php', $all_plugins ) ) {
	if( ! array_key_exists( 'wc-affiliate/wc-affiliate.php', $all_plugins ) ){
		$plugins['wc-affiliate']  = [
			'label'	=> __( 'WC Affiliate - WooCommerce Affiliate Plugin', 'woolementor' ),
			'desc'	=> sprintf( __( 'The most feature-rich yet affordable <a href="%s" target="_blank">WooCommerce Affiliate</a> Plugin.', 'woolementor' ), add_query_arg( [ 'utm_campaign' => 'woolementor_wizard' ], 'https://codexpert.io/wc-affiliate/' ) )
		];
	}
	
}

$congratulations = WOOLEMENTOR_ASSETS . '/img/congratulations.png';

echo '
<div class="setup-wizard-complete-panel">
	<div class="setup-wizard-complete-content">
		<img src="'. esc_url( $congratulations ) .'">
		<p class="cx-wizard-sub">' . __( 'You have successfully installed CoDesigner on your website. 😎', 'woolementor' ) . '</p>';
		if( count( $plugins ) > 0 ) {
			echo '<p class="cx-wizard-sub">'. __( 'Install our top plugins to make your website even better. You can always try them by returning to installation wizard later.', 'woolementor' ) . '</p>
				<h2 class="cx-products">' . __( '🚀 Supercharge your site with-', 'woolementor' ) . '</h2>';
		}

		foreach( $plugins as $plugin => $plugin_array ) {
	  		?>
	  		<p class="cx-suggestion-plugins">
	  			<input type="checkbox" class="cx-suggestion-checkbox" id="<?php esc_attr_e( $plugin ); ?>" name="<?php esc_attr_e( $plugin ); ?>" value="<?php esc_attr_e( $plugin ); ?>" />
	  			<label class="cx-suggestion-label" for="<?php esc_attr_e( $plugin ); ?>"><?php esc_html_e( $plugin_array['label']  ) ?></label>
	  			<sub class="cx-suggestion-sub"><?php _e( $plugin_array['desc'] ); ?> </sub>
	  		</p>
	  		<?php
		}

echo '
	</div>
	<ul class="cx-socal-links">
		<li><a target="_blank" href="https://help.codexpert.io/">Help & Support</a></li>
		<li><a target="_blank" href="https://www.facebook.com/groups/codexpert.io/">Facebook Community</a></li>
	</ul>
</div>

<div id="loader_div" class="loader_div"></div>'; ?>

<script type="text/javascript">
jQuery(document).ready(function($){
	$('#complete-btn').on('click', function(event) {        
		$(".loader_div").show();   
	});
});
</script>