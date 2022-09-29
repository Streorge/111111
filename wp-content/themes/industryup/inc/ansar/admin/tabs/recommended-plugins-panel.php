<?php
/**
 * Recommended Plugins Panel
 *
 * @package Industryup
 */
?>
<div id="recommended-plugins-panel" class="panel-left">
	<?php 
	$industryup_free_plugins = array(
		
		'elementor' => array(
		    'name'     	=> 'Elementor',
			'slug'     	=> 'elementor',
			'filename' 	=> 'elementor.php',
		),

		'ansar-import' => array(
		    'name'     	=> 'Ansar Import',
			'slug'     	=> 'ansar-import',
			'filename' 	=> 'ansar-import.php',
		),

		
	);
	if( !empty( $industryup_free_plugins ) ) { ?>
		<div class="recomended-plugin-wrap">
		<?php
		foreach( $industryup_free_plugins as $industryup_plugin ) {
			$info 		= industryup_call_plugin_api( $industryup_plugin['slug'] ); ?>
			<div class="recom-plugin-wrap w--col">
				<div class="plugin-title-install clearfix">
					<span class="title">
						<?php echo esc_html( $industryup_plugin['name'] ); ?>	
					</span>
					
					
				    <?php if($industryup_plugin['slug'] == 'elementor') : ?>
					<p><?php esc_html_e('To use the Elementor layouts and pages, install the Elementor plugin.', 'industryup'); ?></p>
					<?php endif; ?>	


					 <?php if($industryup_plugin['slug'] == 'ansar-import') : ?>
					<p><?php esc_html_e('To use the Readymade Elementor Template Install and activate Ansar Demo Import plugin then go to appreance menu, click','industryup'); ?>   
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=ansar-demo-import' ) ); ?>" style="text-decoration: none;"><?php echo esc_html__('Ansar Demo Importer','industryup'); ?></a>
					<?php esc_html_e('and Import or Install Elementor Template according to your need.', 'industryup'); ?>
					</p>
					<?php endif; ?>	

					<?php 
					echo '<div class="button-wrap">';
					echo Industryup_Getting_Started_Page_Plugin_Helper::instance()->get_button_html( $industryup_plugin['slug'] );
					echo '</div>';
					?>
				</div>
			</div>
			</br>
			<?php
		} ?>
		</div>
	<?php
	} ?>
</div>