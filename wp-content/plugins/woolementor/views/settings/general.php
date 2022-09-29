<?php 
$banner 		= WOOLEMENTOR_ASSETS . '/img/settings-header-banner.png';
$footer_banner 	= WOOLEMENTOR_ASSETS . '/img/settings-footer-banner.png';
$support 		= WOOLEMENTOR_ASSETS . '/img/customer-support.png';
$documentation 	= WOOLEMENTOR_ASSETS . '/img/documentation.png';
$love 			= WOOLEMENTOR_ASSETS . '/img/love.png';
$logo 			= WOOLEMENTOR_ASSETS . '/img/codesigner-logo.png';
$contribute 	= WOOLEMENTOR_ASSETS . '/img/contribute.png';
$video 			= WOOLEMENTOR_ASSETS . '/img/codesigner_video.png';

$utm			= [ 'utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'pro-tab' ];
$pro_link		= add_query_arg( $utm, 'https://codexpert.io/codesigner/#pricing' );
?>
<div class="wl-content-panel">
	<div class="wl-header-banner">
		<img src="<?php echo esc_url( $banner ); ?>" alt="">
		<?php if ( ! wcd_is_pro_activated() ):
			echo "<a class='wl-upgrade-btn' href='{$pro_link}'>". __( 'Upgrade to Pro', 'woolementor' ) ."</a>";
		endif; ?>
	</div>
	<div class="wl-services-panel">
		<div class="wl-services-content">
			<div class="wl-single-service">
				<div class="wl-single-service-logo">
					<img src="<?php echo esc_url( $love ); ?>" alt="">
				</div>
				<div class="wl-single-service-content red">
					<h4><?php _e( 'Show your Love', 'woolementor' ); ?></h4>
					<p><?php _e( 'Your reviews highly motivate us to improve and add exciting features on CoDeisgner.', 'woocommerce' ); ?></p>
					<a target="_blank" href="https://wordpress.org/support/plugin/woolementor/reviews/?filter=5"><?php _e( 'Leave a review', 'woolementor' ); ?></a>
				</div>
			</div>
			<div class="wl-single-service">
				<div class="wl-single-service-logo">
					<img src="<?php echo esc_url( $documentation ); ?>" alt="">
				</div>
				<div class="wl-single-service-content pink">
					<h4><?php _e( 'Documentation', 'woolementor' ); ?></h4>
					<p><?php _e( 'Stuck with an issue? Our documentations will guide you through the solution.', 'woocommerce' ); ?></p>
					<a target="_blank" href="https://help.codexpert.io/docs/codesigner/"><?php _e( 'Documentation', 'woolementor' ); ?></a>
				</div>
			</div>
			<div class="wl-single-service">
				<div class="wl-single-service-logo">
					<img src="<?php echo esc_url( $support ); ?>" alt="">
				</div>
				<div class="wl-single-service-content yellow">
					<h4><?php _e( 'Customer Support', 'woocommerce' ); ?></h4>
					<p><?php _e( 'We have a super friendly support team to provide you with technical assistance and answers.', 'woolementor' )	; ?></p>
					<a target="_blank" href="https://help.codexpert.io/tickets/"><?php _e( 'Support', 'woolementor' ); ?></a>
				</div>
			</div>
			<div class="wl-single-service">
				<div class="wl-single-service-logo">
					<img src="<?php echo esc_url( $contribute ); ?>" alt="">
				</div>
				<div class="wl-single-service-content blue">
					<h4><?php _e( 'Blog', 'woolementor' ); ?></h4>
					<p><?php _e( 'Get to know more about CoDesigner from our blog posts. You will also get informative tutorials on customizations and tricks.', 'woocommerce' ); ?></p>
					<a target="_blank" href="https://codexpert.io/co-designer/"><?php _e( 'Visit', 'woolementor' ); ?></a>
				</div>
			</div>
		</div>
		<div class="wl-services-video">
			<a href="https://codexpert.io/codesigner/?utm_source=dashboard&utm_medium=settings&utm_campaign=pro-tab#pricing" target="_blank">
				<img src="<?php echo esc_url( $video ); ?>" alt="">
			</a>
		</div>
	</div>
	<div class="wl-bottom-panel">
		<div class="wl-footer-banner" style="background-image: url(<?php echo esc_url( $footer_banner ); ?>);">
			<div class="wl-footer-banner-left">
				<img src="<?php echo esc_url( $logo ); ?>" alt="">
				<p><?php _e( 'Customize your WooCommerce store with Elementor.', 'woolementor' ); ?></p>
			</div>
			<?php if ( ! wcd_is_pro_activated() ):
				echo "<a target='_blank' class='wl-upgrade-btn' href='{$pro_link}'>". __( 'Upgrade to Pro', 'woolementor' ) ."</a>";
			else:
				echo "<a target='_blank' class='wl-upgrade-btn' href='https://codexpert.io/codesigner/'>". __( 'Visit CoDesigner', 'woolementor' ) ."</a>";
			endif; ?>
		</div>
	</div>
</div>

<div class="wl-modal-panel" style="display: none;">
	<div class="wl-modal-content">
		<div class="wl-modal-video">
			<iframe class="popuptext" id="myPopup" width="746" height="420"
				src="https://www.youtube.com/embed/IPc584PRR-A?autoplay=1&mute=1">
			</iframe>
		</div>
	</div>
</div>