<?php
if (!function_exists('industryup_header_logo_menu_section')) :
/**
 *  Header
 *
 * @since Industryup
 *
 */
function industryup_header_logo_menu_section()
{ 
?>

<!-- Logo image -->  
           <div class="navbar-header"> 
            <?php the_custom_logo(); 
                  if (display_header_text()) : ?>
                    <div class="site-branding-text navbar-brand">
                      <h1 class="site-title"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php 
                            echo esc_html(get_bloginfo('name'));
                          ?></a></h1>
                      <p class="site-description"><?php echo esc_html(bloginfo('description')); ?></p>
                    </div>
            <?php endif; ?>
          </div>
          <!-- /Logo -->
          <!-- /navbar-toggle --> 
          <!-- Navigation -->
           <div class="collapse navbar-collapse" id="navbar-wp">
           <?php wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'  => 'collapse navbar-collapse',
                'menu_class' => 'nav navbar-nav',
                'fallback_cb' => 'industryup_fallback_page_menu',
                'walker' => new industryup_nav_walker()
              ) ); 
      ?>
          </div>
<?php 
}
endif;
add_action('industryup_action_header_logo_menu_section', 'industryup_header_logo_menu_section', 1);