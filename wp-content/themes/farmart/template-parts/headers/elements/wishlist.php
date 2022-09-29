<?php
/**
 * Header Wishlish Template
 */

if ( ! function_exists( 'YITH_WCWL' ) ) {
	return;
}

$count = YITH_WCWL()->count_products();
$url = get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) );
?>
<div class="header-element header-element--wishlist">
	<a href="<?php echo esc_url( $url ) ?>">
		<?php if ( farmart_get_option('header_wishlist_counter') ) : ?>
			<span class="mini-item-counter"><?php echo intval( $count ) ?></span>
		<?php endif; ?>
		<?php echo Farmart\Icon::get_svg('heart', '', 'shop'); ?>
	</a>
</div>
