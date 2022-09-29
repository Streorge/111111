<?php
$widget_id  = $args['widget_id'];

if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
    $wishlist_show_hide = 'no';
}

$settings   = $args['settings'];

$products   = wcd_query_products( $settings );     
$user_id    = get_current_user_id();
$wishlist   = wcd_get_wishlist( $user_id );

        
$columns_tablet = isset( $columns_tablet ) && $columns_tablet ? $columns_tablet : 1;
$columns_mobile = isset( $columns_mobile ) && $columns_mobile ? $columns_mobile : 1;

extract( $settings );
?>

<div class="wl-sch-product-style cxp-4">    
    <?php do_action( 'codesigner_before_shop_loop' ); ?>
    <div class="cx-container">
        <div class="cx-grid">
        <?php
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
                ?>
                <div class="wl-sch-single-product <?php echo esc_attr( $alignment ); ?> wl-icons-<?php echo esc_attr( $icon_position_alignment ); ?>">
                    <?php do_action( 'codesigner_before_shop_loop_item' ); ?>
                    <div class="wl-sch-single-widget">

                        <?php if( 'outofstock' == $product->get_stock_status() && 'yes' == $stock_show_hide ): ?>
                            <div class="wl-sch-stock">
                                <?php echo $stock_ribbon_text; ?>
                            </div>
                        <?php endif; ?>

                        <div class="wl-sch-product-img">

                            <?php if ( 'none' == $image_on_click ): ?>
                                <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>  
                            <?php elseif ( 'zoom' == $image_on_click ) : ?>
                                <a id="wl-product-image-zoom" href="<?php echo esc_url( $thumbnail ); ?>"><img src="<?php echo esc_url( $thumbnail ); ?>" alt=""/></a>
                            <?php elseif ( 'product_page' == $image_on_click ) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>                              
                                </a>
                            <?php endif ?>
                            
                        </div>

                        <?php if ( 'bottom' == $icon_position_alignment ): ?>

                        <div class="wl-sch-product-details">
                            <div class="wl-sch-product-info">

                                <?php if ( 'yes' == $sale_ribbon_show_hide && $product->is_on_sale() ): ?>
                                    <div class="wl-sch-corner-ribbon">
                                        <?php
                                        printf( '<span>%1$s</span>',
                                            esc_html( $settings['sale_ribbon_text' ] )
                                        );
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <div class="wl-sch-product-name">
                                    <a class="wl-gradient-heading" href="<?php the_permalink(); ?>"><?php 
                                    do_action( 'codesigner_before_shop_loop_item_title' );
                                    echo esc_html( $product->get_name() ); 
                                    do_action( 'codesigner_after_shop_loop_item_title' );
                                    ?></a>
                                </div>

                                <?php if ( 'yes' == $product_desc_show_hide ): ?>
                                   <div class="wl-sch-product-desc">
                                   		<p><?php echo wp_trim_words( $product->get_short_description(), $product_desc_words_count ); ?></p>
                                   </div>
                                <?php endif; ?>

                                <h2 class="wl-sch-price"><?php echo $product->get_price_html(); ?></h2>

                                <?php if ( 'yes' == $star_rating_show_hide ): ?>
                                    <div class="wl-sch-rating">
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
                                    </div>
                                <?php endif; ?>

                            </div>

                            <div class="wl-sch-info-icons">

                                <?php if ( 'yes' == $wishlist_show_hide ): ?>
                                    <div class="wl-sch-product-fav">
                                        <a href="#" class="ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
                                            <i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
                                        </a>
                                    </div>
                                <?php endif;

                                if ( 'yes' == $wishlist_show_hide && 'yes' == $cart_show_hide ): ?>
                                    <div class="wl-sch-divider"></div>
                                <?php endif;

                                do_action( 'codesigner_before_cart_button', $product, $widget_id, $settings );

                                if ( 'yes' == $cart_show_hide ):
                                    if ( 'simple' == $product->get_type() ): ?>
                                        <div class="wl-sch-product-cart">
                                            <div class="wl-cart-area">
                                                <a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" title="<?php echo _e( 'Add to Cart', 'woolementor-pro' ) ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="wl-sch-product-cart">
                                            <a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart"  ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
                                        </div>
                                    <?php endif;
                                endif; 

                                do_action( 'codesigner_after_cart_button', $product, $widget_id, $settings );
                                ?>
                            </div>
                        </div>

                        <?php else: ?>

                        <div class="wl-sch-product-details">

                        	<?php if ( 'yes' == $wishlist_show_hide ): ?>
                                <div class="wl-sch-product-fav">
                                    <a href="#" class="ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
                                    <i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
                                </a>
                                </div>
                            <?php endif; ?>

                            <div class="wl-sch-product-info">

                                <div class="wl-sch-product-name">
                                    <a href="<?php the_permalink(); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
                                </div>

                                <?php if ( 'yes' == $star_rating_show_hide ): ?>
                                    <div class="wl-sch-rating">
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
                                    </div>
                                <?php endif;

                                if ( 'yes' == $product_desc_show_hide ): ?>
                                   <div class="wl-sch-product-desc">
                                   		<p><?php echo wp_trim_words( $product->get_short_description(), $product_desc_words_count ); ?></p>
                                   </div>
                                <?php endif; ?>

                            </div>

                            <div class="wl-sch-info-icons">

                               <div class="wl-sch-price">
                                  <h2><?php echo $product->get_price_html(); ?></h2>
                               </div>

                               <?php if ( 'yes' == $cart_show_hide ):
                                    if ( 'simple' == $product->get_type() ): ?>
                                        <div class="wl-sch-product-cart">
                                            <div class="wl-cart-area">
                                                <a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" title="<?php echo _e( 'Add to Cart', 'woolementor-pro' ) ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="wl-sch-product-cart">
                                            <a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart"  ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
                                        </div>
                                    <?php endif;
                                endif; ?>

                            </div>
                        </div>
                        
                        <?php endif ?>

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

    echo "<div class='wl-sch-pagination {$class}'>";
    
    /**
    * woolementor pagination
    */
    wcd_pagination( $products, $pagination_left_icon, $pagination_right_icon ); 

    echo '</div>';
endif;