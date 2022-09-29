<?php
$widget_id  = $args['widget_id'];

if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
    $wishlist_show_hide = 'no';
}

$empty_message = __( 'No Product Found!', 'woolementor' );

$settings   = $args['settings'];

$hover_mode = $settings['hover_mode'] == 'yes' && wcd_is_edit_mode() ? 'wl-str-hover' : '';        
$products 	= wcd_query_products( $settings );
$user_id  	= get_current_user_id();
$wishlist 	= wcd_get_wishlist( $user_id );

extract( $settings );
?>

<div class="wl-str-container">
    <?php do_action( 'codesigner_before_shop_loop' ); ?>
	<ul class="wl-str-grid cx-grid wl-str-style-<?php esc_attr_e( $layout ); ?>">
	<?php
	if( $products->have_posts()) : 
		while( $products->have_posts()) : $products->the_post();
			$product_id = get_the_ID();
			$product    = wc_get_product( $product_id );
			$thumbnail  = get_the_post_thumbnail_url( $product_id );
            $fav_product= in_array( $product_id, $wishlist );

            if ( !empty( $fav_product ) ) {
                $fav_item = 'fav-item';
            }
            else{
                $fav_item = '';
            }
			?>
				<li class="wl-str-single-product">

                    <?php do_action( 'codesigner_before_shop_loop_item' ); 

                    if( 'yes' == $show_sale_ribbon && $product->is_on_sale() ): ?>
						<div class="wl-str-ribbon"><?php echo esc_html( $sale_ribbon_text ); ?></div>
					<?php endif;

					if( 'outofstock' == $product->get_stock_status() && 'yes' == $stock_show_hide ): ?>
					    <div class="wl-str-stock">
					        <?php echo esc_html( $stock_ribbon_text ); ?>
					    </div>
					<?php endif ?>

					<figure class="<?php esc_attr_e( $hover_mode ); ?>">

						<a href="<?php the_permalink( $product_id ); ?>"><img src="<?php echo esc_url( $thumbnail ); ?>" alt="img04"></a>
						<figcaption class="wl-str-product-info">
							<p class="wl-str-product-title">
								<a href="<?php the_permalink( $product_id ); ?>"><?php 
                                    do_action( 'codesigner_before_shop_loop_item_title' );
                                    echo esc_html( $product->get_name() ); 
                                    do_action( 'codesigner_after_shop_loop_item_title' );
                                    ?></a>
							</p>
							<p class="wl-str-product-price"><?php echo $product->get_price_html(); ?></p>
							<p class="wl-str-product-btns">
								<?php if ( 'yes' == $wishlist_show_hide ): ?>
									<span class="wl-str-product-fav">
										<a href="#" class="ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
                                            <i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
                                        </a>
									</span>
								<?php endif;

								do_action( 'codesigner_before_cart_button', $product, $widget_id, $settings );

								if ( 'yes' == $cart_show_hide ):
									if( 'simple' == $product->get_type() ) : ?>
								  		<span class="wl-str-cart">
								  			<a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
								  		</span>
								  	<?php else: ?>
								  		<span class="wl-str-cart">
								  			<a href="<?php echo get_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
								  		</span>
								  	<?php endif;
								endif; 

								do_action( 'codesigner_after_cart_button', $product, $widget_id, $settings );
								?>
							</p>
						</figcaption>
					</figure>

                    <?php do_action( 'codesigner_after_shop_loop_item' ); ?>
				</li>
			<?php endwhile; wp_reset_query(); else: 

		echo '<p>' . __( 'No Product Found!', 'woolementor-pro' ) . '</p>';

	endif; ?>

	</ul>
    <?php do_action( 'codesigner_after_shop_loop' ); ?>
</div>

<?php 
if ( 'yes' == $pagination_show_hide ):

    $class = '';
    if ( defined('DOING_AJAX') && DOING_AJAX ) {
        $class = 'wl-ajax-filter-pagination';
    }

    echo "<div class='wl-str-pagination ". esc_attr( $class ) ."'>";
    
    /**
    * woolementor pagination
    */
    wcd_pagination( $products, $pagination_left_icon, $pagination_right_icon ); 

    echo '</div>';
endif;
?>

<script type="text/javascript">
	jQuery(function($){
		$('.wl-str-container').mouseenter(function(e){
			$(this).addClass('hover')
		});
		$('.wl-str-container').mouseleave(function(e){});
	})
</script>