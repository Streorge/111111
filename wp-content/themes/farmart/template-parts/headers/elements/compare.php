<?php
/**
 * Header Compare Template
 */
if ( ! class_exists( 'YITH_Woocompare' ) ) {
	return;
}

global $yith_woocompare;

if ( is_admin() ) {
	$count = [];
} else {
	$count = $yith_woocompare->obj->products_list;
}

?>
<div class="header-element header-element--compare">
	<a class="yith-contents yith-woocompare-open" href="#">
		<?php echo Farmart\Icon::get_svg( 'repeat', '', 'shop' ); ?>
		<?php if( intval( farmart_get_option( 'header_compare_counter' ) ) ): ?>
			<span class="mini-item-counter" id="mini-compare-counter"><?php echo sizeof( $count ); ?></span>
		<?php endif; ?>
	</a>
</div>
