<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package Industryup
 */
?>
<!--==================== industryup-FOOTER AREA ====================-->
  <?php 
  $industryup_footer_widget_background = get_theme_mod('industryup_footer_widget_background');
  $industryup_overlay_footer_widget_control = get_theme_mod('industryup_overlay_footer_widget_control'); 
   if($industryup_footer_widget_background != '') { ?>
<footer style="background-image:url('<?php echo esc_url($industryup_footer_widget_background);?>');">
  <?php } else { ?>
<footer> 
  <?php } ?>
  <div class="overlay" style="background-color: <?php echo esc_attr($industryup_overlay_footer_widget_control);?>;">
  <!--Start industryup-footer-widget-area-->
  <?php if ( is_active_sidebar( 'footer_widget_area' ) ) { ?>
  <div class="bs-footer-widget-area">
    <div class="container">
      <div class="row">
        <?php  dynamic_sidebar( 'footer_widget_area' ); ?>
      </div>
    </div>
  </div>
  <?php } ?>
  <!--End industryup-footer-widget-area-->
  <div class="bs-footer-copyright">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'industryup' ) ); ?>">
					<?php
					/* translators: placeholder replaced with string */
					printf( esc_html__( 'Proudly powered by %s', 'industryup' ), 'WordPress' );
					?>
				</a>
				<span class="sep"> | </span>
				<?php
				/* translators: placeholder replaced with string */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'industryup' ), 'industryup', '<a href="' . esc_url( __( 'https://themeansar.com/', 'industryup' ) ) . '" rel="designer">Themeansar</a>' );
				?>		
			</div>
		</div>
        <div class="col-md-6 text-right">
           <?php 
		  $footer_social_icon_enable = get_theme_mod('footer_social_icon_enable','on');
		  if($footer_social_icon_enable !='off')
		  {
		  $industryup_footer_fb_link = get_theme_mod('industryup_footer_fb_link');
		  $industryup_footer_fb_target = get_theme_mod('industryup_footer_fb_target',1);
		  $industryup_footer_twt_link = get_theme_mod('industryup_footer_twt_link');
		  $industryup_footer_twt_target = get_theme_mod('industryup_footer_twt_target',1);
		  $industryup_footer_lnkd_link = get_theme_mod('industryup_footer_lnkd_link');
		  $industryup_footer_lnkd_target = get_theme_mod('industryup_footer_lnkd_target',1);
		  $industryup_footer_insta_link = get_theme_mod('industryup_footer_insta_link');
		  $industryup_footer_insta_target = get_theme_mod('industryup_footer_insta_target',1);
		  ?>
		  <ul class="bs-social">
			<?php if($industryup_footer_fb_link !=''){?>
			<li><span class="icon-soci"><a <?php if($industryup_footer_fb_target) { ?> target="_blank" <?php } ?>href="<?php echo esc_url($industryup_footer_fb_link); ?>"><i class="fab fa-facebook-f"></i></a></span> </li>
			<?php } if($industryup_footer_twt_link !=''){ ?>
			<li><span class="icon-soci"><a <?php if($industryup_footer_twt_target) { ?>target="_blank" <?php } ?>href="<?php echo esc_url($industryup_footer_twt_link);?>"><i class="fab fa-twitter"></i></a></span></li>
			<?php } if($industryup_footer_lnkd_link !=''){ ?>
			<li><span class="icon-soci"><a <?php if($industryup_footer_lnkd_target) { ?>target="_blank" <?php } ?> href="<?php echo esc_url($industryup_footer_lnkd_link); ?>"><i class="fab fa-linkedin"></i></a></span></li>
			<?php } 
			if($industryup_footer_insta_link !=''){ ?>
			<li><span class="icon-soci"><a <?php if($industryup_footer_insta_target) { ?>target="_blank" <?php } ?> href="<?php echo esc_url($industryup_footer_insta_link); ?>"><i class="fab fa-instagram"></i></a></span></li>
			<?php } ?>
		  </ul>
		  <?php } ?>
      </div>
      </div>
    </div>
  </div>
  </div>
</footer>
</div>
<!-- Scroll To Top -->
<a href="#" class="bs_upscr"><i class="fas fa-angle-up"></i></a>
<!-- /Scroll To Top -->
<?php wp_footer(); ?>
</body>
</html>