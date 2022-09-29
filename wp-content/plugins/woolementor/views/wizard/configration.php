<?php 
$add_to_cart 			= WOOLEMENTOR_ASSETS . '/img/Add-to-cart.png';
$cross_domain 			= WOOLEMENTOR_ASSETS . '/img/cross-domain-copy-paste.png';
$redirect_checkout 		= WOOLEMENTOR_ASSETS . '/img/redirect-checkout.png';
?>
<div class="setup-wizard-configration-panel">
	<h4 class="cx-title"><?php _e( 'Configration', 'woolementor' ); ?></h4>
	<div class="setup-wizard-configrations">
		<div class="setup-wizard-configration">
			<div class="setup-wizard-configration-label">
				<label for=""><?php _e( 'Add To Cart Text', 'woolementor' ); ?></label>
			</div>
			<div class="setup-wizard-configration-content">
				<div class="cx-field-wrap">
					<label class="cx-toggle">
						<input type="checkbox" name="enable_add-to-cart" id="woolementor_tools-add-to-cart" class="cx-toggle-checkbox cx-field cx-field-switch" value="on">
						<div class="cx-toggle-switch"></div>
					</label>
					<div class="cx-hide-fields" style="display: none;">
						<input class="cx-input" type="text" name="add-to-cart-text" value="<?php esc_html_e( 'Add to Cart', 'woolementor' ); ?>">
					</div>

					<p class="cx-desc"><?php _e( 'Enable this if you want to replace the text of the \'Add to cart\' button with something else. E.g. \'Buy Now\' or \'Purchase\'.', 'woolementor' ); ?></p>
				</div>
			</div>
			<div class="setup-wizard-configration-img">
				<img src="<?php echo esc_url( $add_to_cart ); ?>">
			</div>
		</div>
		<div class="setup-wizard-configration">
			<div class="setup-wizard-configration-label">
				<label for=""><?php _e( 'Redirect to checkout', 'woolementor' ); ?></label>
			</div>
			<div class="setup-wizard-configration-content">
				<div class="cx-field-wrap ">
					<label class="cx-toggle">
						<input type="checkbox" name="redirect_to_checkout" id="woolementor_tools-redirect_to_checkout" class="cx-toggle-checkbox cx-field cx-field-switch" value="on">
						<div class="cx-toggle-switch"></div>
					</label>
					<p class="cx-desc"><?php _e( 'Enable this if you want to skip the cart page and take customers directly to the checkout page after they add products to the cart.', 'woolementor' ); ?></p>
				</div>
			</div>
			<div class="setup-wizard-configration-img">
				<img src="<?php echo esc_url( $redirect_checkout ); ?>">
			</div>
		</div>
		<div class="setup-wizard-configration">
			<div class="setup-wizard-configration-label">
				<label for=""><?php _e( 'Cross-domain Copy Paste', 'woolementor' ); ?></label>
			</div>
			<div class="setup-wizard-configration-content">
				<div class="cx-field-wrap ">
					<label class="cx-toggle">
						<input type="checkbox" name="cross_domain_copy_paste" id="woolementor_tools-cross_domain_copy_paste" class="cx-toggle-checkbox cx-field cx-field-switch" value="on">
						<div class="cx-toggle-switch"></div>
					</label>
					<p class="cx-desc"><?php _e( 'Enable this if you want to enable cross-domain copy &amp; paste feature. It\'ll help you copy a widget or section that you designed on one of your sites to another one.', 'woolementor' ); ?></p>
				</div>
			</div>
			<div class="setup-wizard-configration-img">
				<img src="<?php echo esc_url( $cross_domain ); ?>">
			</div>
		</div>
	</div>
</div>

<script>
	jQuery(function($){
		$(document).on( 'click', '#woolementor_tools-add-to-cart', function (e) {
			if ( $(this).is(':checked') ) {
				$('.cx-hide-fields').slideDown();
			}
			else {
				$('.cx-hide-fields').slideUp();
			}
		} );
	});
</script>