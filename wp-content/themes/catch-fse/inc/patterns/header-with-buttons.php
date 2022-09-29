<?php
/**
 * Header with Buttons
 */
return array(
	'title'      => esc_html__( 'Header With Buttons', 'catch-fse' ),
	'categories' => array( 'catch-fse', 'featured' ),
	'content'    => '<!-- wp:group {"align":"full","layout":{"inherit":true}} -->

					<div class="wp-block-group alignfull">
						<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"bottom":"var(--wp--custom--spacing--extra-small)","top":"var(--wp--custom--spacing--extra-small)"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
						<div class="wp-block-group alignwide"
							style="padding-top:var(--wp--custom--spacing--extra-small);padding-bottom:var(--wp--custom--spacing--extra-small)">
							<!-- wp:group {"layout":{"type":"flex"}} -->
							<div class="wp-block-group">
								<!-- wp:site-logo {"width":64} /-->
								<!-- wp:group -->
								<div class="wp-block-group"><!-- wp:site-title /-->

								<!-- wp:site-tagline {"style":{"spacing":{"margin":{"top":"4px"}}}} /--></div>
								<!-- /wp:group -->

							</div>
							<!-- /wp:group -->

							<!-- wp:navigation {"layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"right"}} -->
							<!-- wp:page-list {"isNavigationChild":true,"showSubmenuIcon":true,"openSubmenusOnClick":false} /-->
							<!-- /wp:navigation -->

							<!-- wp:group {"layout":{"type":"flex","allowOrientation":false}} -->
							<div class="wp-block-group">
								<!-- wp:buttons -->
								<div class="wp-block-buttons">
									<!-- wp:button {"className":"is-style-catch-fse-button"} -->
									<div class="wp-block-button is-style-catch-fse-button"><a class="wp-block-button__link">Log in</a></div>
									<!-- /wp:button -->

									<!-- wp:button {"className":"is-style-outline"} -->
									<div class="wp-block-button is-style-outline"><a class="wp-block-button__link">get started</a></div>
									<!-- /wp:button -->
								</div>
								<!-- /wp:buttons -->
							</div>
							<!-- /wp:group -->
						</div>
						<!-- /wp:group -->
					</div>
					<!-- /wp:group -->',
);
