<?php
$widget_id  = $args['widget_id'];

if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
    $wishlist_show_hide = 'no';
}

$settings   = $args['settings'];

extract( $settings );

$hover_mode = $settings['hover_mode'] == 'back' && wcd_is_edit_mode() ? 'hover' : '';
$products 	= wcd_query_products( $settings );
$user_id  	= get_current_user_id();
$wishlist 	= wcd_get_wishlist( $user_id );
?>

<div class="wl-sf-product-style wl-shop-wrapper">
    <?php do_action( 'codesigner_before_shop_loop' ); ?>
	<div class="cx-container">
		<div class="wl-sf-cols cx-grid">
			<?php
			if( $products->have_posts()) : 
				while( $products->have_posts()) : $products->the_post();
					$product_id = get_the_ID();
					$product    = wc_get_product( $product_id );
					$thumbnail_size = sanitize_text_field( $image_thumbnail_size );
					$thumbnail  = get_the_post_thumbnail_url( $product_id, $thumbnail_size );
	                $fav_product= in_array( $product_id, $wishlist );

	                if ( !empty( $fav_product ) ) {
	                    $fav_item = 'fav-item';
	                }
	                else{
	                    $fav_item = '';
	                }
					?>
					<div class="wl-sf-col" ontouchstart="this.classList.toggle('hover');">
                    	<?php do_action( 'codesigner_before_shop_loop_item' ); ?>
						<div class="wl-sf-container <?php esc_attr_e( $hover_mode ); ?>">
							<div class="front" style="background-image: url(<?php echo esc_url( $thumbnail ); ?>)">
								<div class="inner">
                                	<?php do_action( 'codesigner_shop_loop_item_title' ); ?>
									<p class="wl-sf-product-title"><?php echo esc_attr( $product->get_name() ); ?></p>
                                	<?php do_action( 'codesigner_after_shop_loop_item_title' ); ?>
									<span class="wl-sf-product-price"><?php echo $product->get_price_html(); ?></span>
								</div>

								<?php if ( 'yes' == $sale_ribbon_show_hide && $product->is_on_sale() ): ?>
									<div class="wl-sf-corner-ribbon">
										<?php
										printf( '<span>%1$s</span>',
		                                    esc_html( $settings['sale_ribbon_text' ] )
		                                );
										?>
									</div>
								<?php endif;

								if( 'outofstock' == $product->get_stock_status() && 'yes' == $stock_show_hide ): ?>
							    	<div class="wl-sf-stock">
								        <?php echo esc_html( $stock_ribbon_text ); ?>
								    </div>
								<?php endif ?>
							</div>
							<div class="back">
								<div class="inner">
								<?php if ( 'yes' == $short_description_show_hide ) : ?>
									<p class="wl-sf-short-description"><?php 
									$words_count = codesigner_sanitize_number( $product_desc_words_count );
									echo wp_trim_words( $product->get_short_description(), $words_count ); ?></p>
								<?php endif;

								if ( 'yes' == $view_details_show_hide ): ?>
									<span class="wl-sf-product-view">
										<a href="<?php the_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $view_details_icon['value'] ); ?>" ></i></a>
									</span>
								<?php endif;

								if ( 'yes' == $wishlist_show_hide ): ?>
									<span class="wl-sf-product-fav">
										<a href="#" class="ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
	                                        <i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
	                                    </a>
									</span>
								<?php endif;

								do_action( 'codesigner_before_cart_button', $product, $widget_id, $settings );

								if ( 'yes' == $cart_show_hide ):
									if( 'simple' == $product->get_type() ) : ?>
										<span class="wl-sf-cart">
											<a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
										</span>
									<?php else: ?>
										<span class="wl-sf-cart">
											<a href="<?php echo get_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
										</span>
									<?php endif;
								endif; 

								do_action( 'codesigner_after_cart_button', $product, $widget_id, $settings );
								?>
								</div>
							</div>
						</div>
                    	<?php do_action( 'codesigner_after_shop_loop_item' ); ?>
					</div>
					<?php endwhile; wp_reset_query(); else: 

				echo '<p>' . __( 'No Product Found!', 'woolementor-pro' ) . '</p>';

			endif; ?>
		</div>
	</div>
    <?php do_action( 'codesigner_after_shop_loop' ); ?>
</div>

<?php
if ( 'yes' == $pagination_show_hide ):

    $class = '';
    if ( defined('DOING_AJAX') && DOING_AJAX ) {
        $class = 'wl-ajax-filter-pagination';
    }

    echo "<div class='wl-sf-pagination {$class}'>";
    
    /**
    * woolementor pagination
    */
    wcd_pagination( $products, $pagination_left_icon, $pagination_right_icon ); 

    echo '</div>';
endif;
?>

<script type="text/javascript">
	jQuery(function($){
		$('.wl-sf-container').mouseenter(function(e){
			$(this).addClass('hover')
		});
		$('.wl-sf-container').mouseleave(function(e){
			$(this).removeClass('hover')
		});
	})
</script>