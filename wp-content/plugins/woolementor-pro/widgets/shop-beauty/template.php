<?php
$widget_id  = $args['widget_id'];

if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
    $wishlist_show_hide = 'no';
}

$settings   = $args['settings'];
        
if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
    $wishlist_show_hide = 'no';
}

$products = wcd_query_products( $settings );        
$user_id  = get_current_user_id();
$wishlist = wcd_get_wishlist( $user_id );

extract( $settings );
?>

<div class="wl-sb-product-style">
    <?php do_action( 'codesigner_before_shop_loop' ); ?>
    <div class="cx-container">
        <div class="cx-grid">

        <?php
        if( $products->have_posts()) : 
            while( $products->have_posts()) : $products->the_post();
                $product_id         = get_the_ID();
                $product            = wc_get_product( $product_id );
                $thumbnail_size     = sanitize_text_field( $image_thumbnail_size );
                $thumbnail          = get_the_post_thumbnail_url( $product_id, $thumbnail_size );
                $fav_product        = in_array( $product_id, $wishlist );
                $purchase_text      = str_replace( '%price%', wc_price( $product->get_price() ), $purchase_button_text );

                if ( !empty( $fav_product ) ) {
                    $fav_item = 'fav-item';
                }
                else{
                    $fav_item = '';
                }

                if ( 'yes' == $image_show_hide ) {
                    $style_w = "50%";
                }
                else {
                    $style_w = "100%";
                }
                ?>

                <div class="wl-sb-single-product">
                    <?php do_action( 'codesigner_before_shop_loop_item' ); ?>
                    <div class="wl-sb-single-widget">

                        <?php if ( 'yes' == $sale_ribbon_show_hide && $product->is_on_sale() ): ?>
                            <div class="wl-sb-corner-ribbon">
                                <?php
                                printf( '<span>%1$s</span>',
                                    esc_html( $settings['sale_ribbon_text' ] )
                                );
                                ?>
                            </div>
                        <?php endif;

                        if ( 'yes' == $image_show_hide ): ?>
                            <div class="wl-sb-product-img">

                                <?php if ( 'none' == $image_on_click ): ?>
                                    <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>  
                                <?php elseif ( 'zoom' == $image_on_click ) : ?>
                                    <a id="wl-product-image-zoom" href="<?php echo esc_url( $thumbnail ); ?>"><img src="<?php echo esc_url( $thumbnail ); ?>" alt=""/></a>
                                <?php elseif ( 'product_page' == $image_on_click ) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>                              
                                    </a>
                                <?php endif ?>
                                <?php if( 'outofstock' == $product->get_stock_status() && 'yes' == $stock_show_hide ): ?>
                                    <div class="wl-sb-stock">
                                        <?php echo esc_html( $stock_ribbon_text ); ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endif; ?>

                        <div class="wl-sb-product-details" style="width: <?php echo esc_attr( $style_w ); ?>">
                            <div class="wl-sb-product-info">
                                <div class="wl-sb-product-name"><a class="wl-gradient-heading" href="<?php the_permalink(); ?>"><?php 
                                    do_action( 'codesigner_before_shop_loop_item_title' );
                                    echo esc_html( $product->get_name() ); 
                                    do_action( 'codesigner_after_shop_loop_item_title' );
                                    ?></a>
                                </div>
                                <?php if ( 'yes' == $product_desc_show_hide ): ?>
                                   <div class="wl-sb-product-desc">
                                        <p><?php 
                                        $words_count = codesigner_sanitize_number( $product_desc_words_count );
                                        echo wp_trim_words( $product->get_short_description(), $words_count ); ?></p>
                                   </div>
                                <?php endif;

                                if ( 'yes' == $star_rating_show_hide ): ?>
                                    <div class="wl-sb-rating">
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

                                <div class="wl-sb-purchase-wishlist-area">

                                    <?php
                                    do_action( 'codesigner_before_cart_button', $product, $widget_id, $settings );

                                     if ( 'yes' == $purchase_show_hide ):
                                        if ( 'simple' == $product->get_type() ): ?>
                                            <div class="wl-sb-cart-area">
                                                <a href="?add-to-cart=<?php echo get_permalink( $product_id ); ?>" data-quantity="1" class="wl-sb-product-cart button product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><?php echo wp_kses_post( $purchase_text ); ?></a>
                                            </div>
                                        <?php else: ?>
                                            <div class="wl-sb-cart-area">
                                                <a href="<?php echo get_permalink( $product_id ); ?>" data-quantity="1" class="wl-sb-product-cart button product_type_<?php echo esc_attr( $product->get_type() ); ?>" data-product_id="<?php echo $product_id; ?>" ><?php echo wp_kses_post( $purchase_text ); ?></a>
                                            </div>
                                        <?php endif;
                                    endif;

                                    do_action( 'codesigner_after_cart_button', $product, $widget_id, $settings );

                                    if ( 'yes' == $wishlist_show_hide ): ?>
                                        <div class="wl-sb-product-fav">
                                            <a href="#" class="ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
                                            <i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
                                        </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php do_action( 'codesigner_after_shop_loop_item' ); ?>
                </div>

            <?php endwhile; wp_reset_query(); else: 

            echo '<p>' . __( 'No Product Found!', 'woolementor' ) . '</p>';

        endif; ?>

        </div> 
    </div> 
    <?php do_action( 'codesigner_after_loop' ); ?>
</div>

<?php 

if ( 'yes' == $pagination_show_hide ):

    $class = '';
    if ( defined('DOING_AJAX') && DOING_AJAX ) {
        $class = 'wl-ajax-filter-pagination';
    }

    echo "<div class='wl-sb-pagination {$class}'>";
    
    /**
    * woolementor pagination
    */
    wcd_pagination( $products, $pagination_left_icon, $pagination_right_icon ); 

    echo '</div>';
endif;

?>
<script>
    jQuery(function($){
        $(".wl-sb-product-image-zoom").fancybox({
            arrows: true,
            'transitionIn'  :   'elastic',
            'transitionOut' :   'elastic',
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   false

        }).attr('data-fancybox', 'gallery');
    })
</script>