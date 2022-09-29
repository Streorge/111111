<?php
/**
 * Template file for displaying mobile menu
 */
?>

<div class="fm-menu-mobile farmart-menu-mobile">
	<div class="menu-box-title">
		<div class="fm-icon menu-icon menu-icon-js">
			<?php echo Farmart\Icon::get_svg('menu'); ?>
		</div>
	</div>
	<div class="menu-mobile-wrapper">
		<div class="primary-menu-mobile">
			<div class="menu-box">
				<div class="top-content">
					<?php echo Farmart\Icon::get_svg('arrow-left', 'go-back close-canvas-mobile-panel'); ?>
					<div class="author">
						<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>"><?php echo Farmart\Icon::get_svg('user', '', 'shop'); ?><span><?php echo esc_html__( 'Login & Register', 'farmart' ); ?></span></a>
					</div>
				</div>
				<nav class="menu-content">
					<?php
						if ( has_nav_menu( 'mobile' ) ) {
							wp_nav_menu( apply_filters( 'farmart_navigation_mobile_content', array(
								'theme_location' => 'mobile',
								'container'      => false,
								'menu_class'     => 'fm-nav-mobile-menu menu',
							) ) );
						} else {
							wp_nav_menu( apply_filters( 'farmart_navigation_mobile_content', array(
								'theme_location' => 'primary',
								'container'      => false,
								'menu_class'     => 'fm-nav-mobile-menu menu',
							) ) );
						}
					?>
				</nav>
			</div>
			<?php
				$output = array();

				$items = farmart_get_option( 'header_primary_menu_items' );
				if ( $items ) {
					foreach ( (array) $items as $item ) {

						if ( $item['image'] ) {
							$image_id = $item['image'];
							if( is_numeric($image_id) ) {
								$img = wp_get_attachment_image( $image_id, 'full' );
							} else {
								$img = sprintf('<img src="%s" alt="">', $image_id);
							}
						}

						if ( $item['svg'] ) {
							$img = '<span class="farmart-svg-icon">' . $item['svg'] . '</span>';
						}

						if ( $item['text' ] ) {
							$text = $item['text'];
						}

						if ( isset( $item['link'] ) && ! empty( $item['link'] ) ) {
							if ( $img ) {
								$output[] = sprintf( '<div class="bottom-content--item"><a href="%s">%s %s</a></div>', esc_url( $item['link'] ), $img, $text );
							}
						} else {
							if ( $img ) {
								$output[] = sprintf( '<div class="bottom-content--item">%s %s</div>', $img, $text );
							}
						}

					}
				}

				if ( $output ) {
					printf( '<div class="bottom-content">%s</div>', implode( ' ', $output ) );
				}
			?>
		</div>
	</div>
	<div class="fm-off-canvas-layer"></div>
</div>