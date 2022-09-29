<?php
$widget_id  = $args['widget_id'];

if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
    $wishlist_show_hide = 'no';
}

$settings   = $args['settings'];

$products   = wcd_query_products( $settings );     
$user_id    = get_current_user_id();
$wishlist   = wcd_get_wishlist( $user_id );

extract( $settings );

$id_class = '';
if ( is_array( $id_visibility ) && count( $id_visibility ) > 0 ) {
    $id_class = implode( ' ', (array)$id_visibility );
}

$img_class = '';
if ( is_array( $image_visibility ) && count( $image_visibility ) > 0 ) {
    $img_class = implode( ' ', (array)$image_visibility );
}

$title_class = '';
if ( is_array( $title_visibility ) && count( $title_visibility ) > 0 ) {
    $title_class = implode( ' ', (array)$title_visibility );
}

$category_class = '';
if ( is_array( $category_visibility ) && count( $category_visibility ) > 0 ) {
    $category_class = implode( ' ', (array)$category_visibility );
}

$short_desc_class = '';
if ( is_array( $short_desc_visibility ) && count( $short_desc_visibility ) > 0 ) {
    $short_desc_class = implode( ' ', (array)$short_desc_visibility );
}

$desc_class = '';
if ( is_array( $brief_desc_visibility ) && count( $brief_desc_visibility ) > 0 ) {
    $desc_class = implode( ' ', (array)$brief_desc_visibility );
}

$price_class = '';
if ( is_array( $price_visibility ) && count( $price_visibility ) > 0 ) {
    $price_class = implode( ' ', (array)$price_visibility );
}

$action_class = '';
if ( is_array( $action_visibility ) && count( $action_visibility ) > 0 ) {
    $action_class = implode( ' ', (array)$action_visibility );
}

$class = 'wl-st-table-header';

?>
<div class="wl-st-table-div">
<?php if( 'yes' == $multiselect_visibility ): ?>
    <form method="POST" class="multiple-product-add-to-cart">
<?php endif; ?>
    <div style="overflow-x:auto;">
    <?php do_action( 'codesigner_before_shop_loop' ); ?>
        <table class="wl-st-main_table <?php echo $data_table_show_hide; ?>">  
            <?php if ( $products->have_posts() && ( 'top-btm-header' == $table_header || 'top-header' == $table_header ) ) : ?>
            <thead>
                <tr>
                    <?php 
                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $id_class ),
                            esc_html( $id_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $img_class ),
                            esc_html( $image_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $title_class ),
                            esc_html( $title_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $category_class ),
                            esc_html( $category_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $short_desc_class ),
                            esc_html( $short_desc_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $desc_class ),
                            esc_html( $brief_desc_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $price_class ),
                            esc_html( $price_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class . ' wl-st-action-panel' .' '. $action_class ),
                            esc_html( $action_text )
                        );

                        if( 'yes' == $multiselect_visibility ):
                            printf( '<th>%s</th>',
                                esc_html( $multiselect_text )
                            );
                        endif;
                    ?>
                </tr> 
            </thead>

        <?php endif; 

        if( $products->have_posts() ) : 
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
            <?php do_action( 'codesigner_before_shop_loop_item' ); ?>
            <tr>

                <?php 
                if ( is_array( $id_visibility ) && count( $id_visibility ) > 0 ) {
                    printf( '<td class="wl-st-td %s">%d</td>',
                        esc_attr(  implode( ' ', (array)$id_visibility ) ),
                        esc_html( $product_id )
                    );
                }

                $image_visibility_class = '';
                if ( is_array( $image_visibility ) && count( $image_visibility ) > 0 ) {
                    $image_visibility_class = implode( ' ', (array)$image_visibility );
                }
                ?>

                <td class="wl-st-td wl-st-img <?php esc_attr_e( $image_visibility_class ); ?>"> 
                    <?php if ( 'none' == $image_on_click ): ?>
                        <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>  
                    <?php elseif ( 'zoom' == $image_on_click ) : ?>
                        <a id="wl-st-product-image-zoom" href="<?php echo esc_url( $thumbnail ); ?>"><img src="<?php echo esc_url( $thumbnail ); ?>" alt=""/></a>
                    <?php elseif ( 'product_page' == $image_on_click ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>         
                        </a>
                    <?php endif ?>
                </td>

                <td class="wl-st-td wl-st-name <?php echo implode( ' ', (array)$title_visibility ); ?>"> 

                    <?php do_action( 'codesigner_shop_loop_item_title' ); ?>
                    <a href="<?php the_permalink(); ?>"><?php echo $product->get_name(); ?></a>
                    <?php do_action( 'codesigner_after_shop_loop_item_title' ); ?>

                    <?php if( 'yes' == $show_sale_ribbon && $product->is_on_sale() ): ?>
                        <span class="wl-st-sale">
                            <?php echo esc_html( $sale_ribbon_text );  ?>                            
                        </span>
                    <?php endif; ?>

                </td>

                <?php 

                    if ( is_array( $category_visibility ) && count( $category_visibility ) > 0 ) {
                        printf( '<td class="wl-st-td %s">%s</td>',
                            esc_attr( implode( ' ', (array)$category_visibility ) ),
                            wc_get_product_category_list( $product_id )
                        );
                    }

                    if ( is_array( $short_desc_visibility ) && count( $short_desc_visibility ) > 0 ) {
                        printf( '<td class="wl-st-td %s">%s</td>',
                            esc_attr( implode( ' ', (array)$short_desc_visibility ) ),
                            wpautop( $product->get_short_description() )
                        );
                    }

                    if ( is_array( $brief_desc_visibility ) && count( $brief_desc_visibility ) > 0 ) {
                        $hyperlink  = $brief_description_enable_hyperlink;
                        $text       = $brief_description_read_more;
                        $product_url= get_the_permalink( $product_id );
                        $read_more_text = $hyperlink == 'yes' ? "<a class='rm-link' href='". esc_url( $product_url ) ."'>". esc_html( $text ) ."</a>" : ' ...'; 
                        printf( '<td class="wl-st-td %s">%s</td>',
                            esc_attr( implode( ' ', (array)$brief_desc_visibility ) ),
                            wp_trim_words( $product->get_description(), $product_desc_words_count, $read_more_text )
                        );
                    }

                    if ( is_array( $price_visibility ) && count( $price_visibility ) > 0 ) {
                        printf( '<td class="wl-st-td %s">%s</td>',
                            esc_attr( implode( ' ', (array)$price_visibility ) ),
                            $product->get_price_html()
                        );
                    }
                        
                    $action_visibility_class = '';
                    if ( is_array( $action_visibility ) && count( $action_visibility ) > 0 ) {
                        $action_visibility_class = implode( ' ', (array)$action_visibility );
                    }
                ?>
                <td class="wl-st-td <?php esc_attr_e( $action_visibility_class ); ?>"> 
                    <div class="wl-st-info-icons">
                        <?php if( 'yes' == $qty_show_hide ): 
                            $hide = 'simple' != $product->get_type() ? 'hide' : '';
                            ?>
                            <input min='1' type="number" name="qty" class="wl-st-qty <?php esc_attr_e( $hide ); ?>" value="1" >
                        <?php endif; ?>
                        <?php if ( 'yes' == $wishlist_show_hide ): ?>
                            <a href="#" class="wl-st-product-fav button ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>"><i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>" ></i></a>
                        <?php endif ?>

                        <?php 
                        do_action( 'codesigner_before_cart_button', $product, $widget_id, $settings );

                        if ( 'yes' == $cart_show_hide ): ?>
                            <?php if( 'simple' == $product->get_type() ) : ?>
                                <div class="wl-st-product-cart">
                                    <a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="wl-st-product-cart button product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
                                </div>
                            <?php else: ?>
                                <div class="wl-st-product-cart">
                                    <a class="wl-st-product-cart button" href="<?php echo get_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
                                </div>
                            <?php endif; ?>
                        <?php endif; 

                        do_action( 'codesigner_after_cart_button', $product, $widget_id, $settings );
                        ?>
                    </div>
                </td>

                <?php if( 'yes' == $multiselect_visibility ): 
                    $disabled = 'simple' != $product->get_type() ? 'disabled' : '';
                    ?>
                    <td class="multiple_items">
                        <input type="checkbox" name="cart_item_ids[]" value="<?php echo $product_id; ?>" <?php esc_attr_e( $disabled ); ?>>
                        <input class="multiple_qty" type="hidden" name="multiple_qty[<?php echo $product_id; ?>]" value="1">
                    </td>
                <?php endif ?>
            </tr> 
            <?php do_action( 'codesigner_after_shop_loop_item' ); ?>
        <?php endwhile; wp_reset_query(); ?>

        <?php if ('top-btm-header' == $table_header ) : ?>
            <tfoot>
                <tr>
                    <?php 
                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $id_class ),
                            esc_html( $id_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $img_class ),
                            esc_html( $image_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $title_class ),
                            esc_html( $title_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $category_class ),
                            esc_html( $category_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $short_desc_class ),
                            esc_html( $short_desc_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $desc_class ),
                            esc_html( $brief_desc_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class .' '. $price_class ),
                            esc_html( $price_text )
                        );

                        printf( '<th class="%s">%s</th>',
                            esc_attr( $class . ' wl-st-action-panel' .' '. $action_class ),
                            esc_html( $action_text )
                        );

                        if( 'yes' == $multiselect_visibility ):
                            printf( '<th>%s</th>',
                                esc_html( $multiselect_text )
                            );
                        endif;
                    ?>
                </tr> 
            </tfoot> 
        <?php endif ?>

         <?php else: 

            echo '<p>' . __( 'No Product Found!', 'woolementor-pro' ) . '</p>';

        endif; ?>
        </table>
    <?php do_action( 'codesigner_after_shop_loop' ); ?>
    </div>

    <?php if( 'yes' == $multiselect_visibility ): ?>
        <div class="multiselect-submit-div">
            <?php wp_nonce_field( 'woolementor' ); ?>
            <input type="hidden" name="action" value="multiple-product-add-to-cart">
            
            <?php 
                printf( '<input class="multiselect-submit" type="submit" value="%s">',
                    esc_attr( $multiselect_submit_text )
                );
            ?>
            
            <a class="button multiselect-view-cart" href="<?php echo wc_get_cart_url(); ?>" ><?php _e( 'View Cart', 'woolementor-pro' ); ?></a>
        </div>
        </form>
    <?php endif; ?>

</div>

<?php 

if ( 'yes' == $pagination_show_hide ):

    $class = '';
    if ( defined('DOING_AJAX') && DOING_AJAX ) {
        $class = 'wl-ajax-filter-pagination';
    }

    echo "<div class='wl-st-pagination ". esc_attr( $class ) ."'>";
    
    /**
    * woolementor pagination
    */
    wcd_pagination( $products, $pagination_left_icon, $pagination_right_icon ); 

    echo '</div>';
endif;
?>

<script type="text/javascript">
    jQuery(function($){
        $('.wl-st-data-table').DataTable();
    })
</script>