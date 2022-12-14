<?php
/**
 * Default Header
 */
return array(
	'title'      => esc_html__( 'Default Header', 'catch-fse' ),
	'categories' => array( 'catch-fse', 'header' ),
	'content'    => '<!-- wp:group {"align":"full","layout":{"inherit":true}} -->

					<div class="wp-block-group alignfull"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"bottom":"var(--wp--custom--spacing--extra-small)","top":"var(--wp--custom--spacing--extra-small)"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
					<div class="wp-block-group alignwide" style="padding-top:var(--wp--custom--spacing--extra-small);padding-bottom:var(--wp--custom--spacing--extra-small)"><!-- wp:group {"layout":{"type":"flex"}} -->
					<div class="wp-block-group"><!-- wp:site-logo {"width":64} /-->
					<!-- wp:group -->
					<div class="wp-block-group">
					<!-- wp:site-title /--><!-- wp:site-tagline {"style":{"spacing":{"margin":{"top":"4px"}}}} /--></div>
					<!-- /wp:group -->
					</div>
					<!-- /wp:group -->

					<!-- wp:navigation {"layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"right"}} -->
					<!-- wp:page-list {"isNavigationChild":true,"showSubmenuIcon":true,"openSubmenusOnClick":false} /-->
					<!-- /wp:navigation -->
					</div>
					<!-- /wp:group --></div>
					<!-- /wp:group -->',
);
