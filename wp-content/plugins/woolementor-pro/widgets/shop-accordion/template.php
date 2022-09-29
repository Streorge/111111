<?php
$widget_id  = $args['widget_id'];

if ( defined('DOING_AJAX') && DOING_AJAX ) {
    $section_id = '';
}
else {
	$section_id = $args['section_id'];
}

if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
    $wishlist_show_hide = 'no';
}

$settings   = $args['settings'];


// $section_id = $this->get_id();

$products 	= wcd_query_products( $settings );
$user_id  	= get_current_user_id();
$wishlist 	= wcd_get_wishlist( $user_id );

extract( $settings );
?>
<div id="wl-shop-accordion-<?php esc_attr_e( $section_id ); ?>" class="wl-shop-accordion">
	<?php do_action( 'codesigner_before_shop_loop' ); ?>
	<div class="cx-container">
		<div class="cx-row">
         	<div class="cx-col-md-12 cx-col-sm-12">
            	<div class="wl-sa-accordion-area">

					<?php
					$count = 1;
					if( $products->have_posts()) : 
						while( $products->have_posts()) : $products->the_post();
							$product_id = get_the_ID();
							$product    = wc_get_product( $product_id );
							$thumbnail  = get_the_post_thumbnail_url( $product_id, $image_thumbnail_size );
							$fav_product= in_array( $product_id, $wishlist );

							if ( !empty( $fav_product ) ) {
								$fav_item = 'fav-item';
							}
							else{
								$fav_item = '';
							}

							if ( $count == 1 && 'yes' == $section_style_accordion_switcher ) {
								$wcd_open = 'wl-sa-open';
							}
							else{
								$wcd_open = '';
							}
							?>
						 
							<!-- Single Product -->
							<div id="wl-sa-single-accordion-<?php echo esc_attr( $section_id ) . esc_attr( $product_id ); ?>" class="wl-sa-single-accordion <?php echo esc_attr( $wcd_open ); ?>">
								<?php do_action( 'codesigner_before_shop_loop_item' ); ?>
								<div class="wl-sa-accordion-title wl-sa-item" data-id="<?php echo esc_attr( $section_id ) . esc_attr( $product_id ); ?>">
									<h2><?php 
									do_action( 'codesigner_before_shop_loop_item_title' );
									echo esc_html( $product->get_name() ); 
									do_action( 'codesigner_after_shop_loop_item_title' );
									?></h2><span></span>
								</div>
								<div class="wl-sa-accordion-content wl-sa-item-data">
									<div class="wl-sa-accordion-content-inner">
										<div class="wl-sa-acordion-left">
											<?php if ( 'none' == $image_on_click ): ?>
												<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>  
											<?php elseif ( 'zoom' == $image_on_click ) : ?>
												<a id="wl-sa-product-image-zoom" href="<?php echo esc_url( $thumbnail ); ?>"><img src="<?php echo esc_url( $thumbnail ); ?>" alt=""/></a>
											<?php elseif ( 'product_page' == $image_on_click ) : ?>
												<a href="<?php the_permalink(); ?>">
													<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>                              
												</a>
											<?php endif ?>
										</div>
										<div class="wl-sa-acordion-right">
											<div class="wl-sa-accordion-category">
												<?php if ( 'yes' == $product_category_show_hide ): ?>
													<span class="wl-sa-accordion-cat">
														<span><?php echo _e( 'CATEGORY :', 'woolementor-pro' ); ?></span> 
														<?php
														$cat_count 	= codesigner_sanitize_number( $product_category_count );
														$terms_list = wc_get_product_category_list( $product_id );
														$term_list 	= explode( ',' , $terms_list );
														$terms 		= array_slice( $term_list, 0, $cat_count );
														
														echo implode( ', ', $terms );
														?>
													</span> 
												<?php endif;

												if ( 'yes' == $star_rating_show_hide ): ?>
													<span class="wl-sa-rating">
														<?php 
			                                                for ( $i = 0; $i < 5; $i++ ) { 

			                                                    if ( $i < $product->get_average_rating() ) {
			                                                        echo '<i class="'. esc_attr( $star_rating_blockicon['value'] ) .'"></i>';
			                                                    }
			                                                    else{
			                                                        echo '<i class="'. esc_attr( $star_rating_empty_icon['value'] ) .'"></i>';
			                                                    }
			                                                }
			                                                ?>
														<span>(<?php echo $product->get_average_rating(); ?>)</span>
													</span>
												<?php endif;

												if ( 'yes' == $product_tag_show_hide ): ?>
													<?php
													$tag_count = codesigner_sanitize_number( $product_tag_count );
													$tags_list = wc_get_product_tag_list( $product_id );
													$tag_list = explode( ',' , $tags_list );
													$tags = array_slice( $tag_list, 0, $tag_count );

													foreach ( $tags as $key => $tag ) {
														if( $tag ) {
															echo '<span class="wl-sa-tag">'. esc_html( $tag ) .'</span>';
														}
													}
													 ?>
												<?php endif;

												if( 'outofstock' == $product->get_stock_status() && 'yes' == $stock_show_hide ): ?>
												    <span class="wl-sa-stock">
												        <?php echo esc_html( $stock_ribbon_text ); ?>
												    </span>
												<?php endif; ?>
											</div>

											<?php if ( 'yes' == $short_description_show_hide ): ?>
												<div class="wl-sa-short-description">
													<p><?php echo wp_trim_words( $product->get_short_description(), $product_short_desc_words_count ); ?></p>
												</div>
											<?php endif; ?>

											<?php if ( 'yes' == $brief_description_show_hide ): 
												$hyperlink 		= $brief_description_enable_hyperlink;
												$text 			= $brief_description_read_more ;
												$product_url 	= get_the_permalink( $product_id );
												$read_more_text = $hyperlink == 'yes' ? "<a href='". esc_url( $product_url ) ."'>". esc_html( $text ) ."</a>" : ' ...'; 
												$words_count 	= codesigner_sanitize_number( $product_desc_words_count );
												?>
												<div class="wl-sa-brief-description">
													<p><?php echo wp_trim_words( $product->get_description(), $words_count, $read_more_text ); ?></p>
												</div>
											<?php endif; ?>

											
											<div class="wl-sa-product-details">

												<div class="wl-sa-product-info">
													<strong class="wl-sa-price"><?php echo $product->get_price_html(); ?></strong>
												</div>
												<div class="wl-sa-info-icons">
													<?php if ( $details_btn_show_hide == 'yes' ): ?>
													<div class="wl-sa-product-page">
														<a href="<?php the_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $details_btn_icon['value'] ); ?>"></i></a>
													</div>
													<?php endif; ?>
													<?php if ( 'yes' == $wishlist_show_hide ): 
														
														?>
														<div class="wl-sa-product-fav">
															<a href="#" class="ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
																<i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
															</a>
														</div>
													<?php endif;

													do_action( 'codesigner_before_cart_button', $product, $widget_id, $settings );

													if ( 'yes' == $cart_show_hide ): ?>
														<?php if ( 'simple' == $product->get_type() ): ?>
															<div class="wl-sa-product-cart">
																<div class="wl-cart-area">
																	<a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
																</div>
															</div>
														<?php else: ?>
															<div class="wl-sa-product-cart">
																<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart"  ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
															</div>
														<?php endif;
													endif;

													do_action( 'codesigner_after_cart_button', $product, $widget_id, $settings );
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php do_action( 'codesigner_after_shop_loop_item' ); ?>
							</div>

						<?php $count++; endwhile; wp_reset_query(); else: 

						echo '<p>' . __( 'No Product Found!', 'woolementor-pro' ) . '</p>';

					endif; ?>
					
				</div>
			</div>
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

    echo "<div class='wl-sa-pagination {$class}'>";
    
    /**
    * woolementor pagination
    */
    wcd_pagination( $products, $pagination_left_icon, $pagination_right_icon ); 

    echo '</div>';
endif;

?>
<script>
	jQuery(function($) {
		$('.wl-sa-accordion-content', '#wl-shop-accordion-<?php echo $section_id; ?> .wl-sa-single-accordion.wl-sa-open').stop().slideDown('slow');
		

		$('.wl-sa-accordion-title', '#wl-shop-accordion-<?php echo $section_id; ?>').on('click', function(e){
			var id = $(this).data('id');
			var section = $(this).closest('.wl-shop-accordion');
			$('.wl-sa-accordion-content', section).stop().slideUp('slow');
			$('.wl-sa-accordion-content', '#wl-sa-single-accordion-'+id).stop().slideDown('slow');
			$('.wl-sa-single-accordion', section).removeClass('wl-sa-open');
			$('#wl-sa-single-accordion-'+id).addClass('wl-sa-open');
		});
	});
</script>