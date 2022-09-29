<?php
/**
 * The template for displaying archive pages.
 *
 * @package Industryup
 */
get_header(); ?>
<!-- Breadcrumb -->
<div class="bs-breadcrumb-section" style='background-image: linear-gradient(132deg, #f4f7fc 50% ,transparent 50%), url("<?php echo esc_url(( has_header_image() ? esc_url(get_header_image()) : get_theme_support( 'custom-header', 'default-image' ) )); ?>");'>
  <div class="overlay">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="bs-breadcrumb-title">
            <?php echo industryup_archive_page_title(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /End Breadcrumb -->
<main id="content">
  <div class="container">
    <div class="row">
      <div class="col-md-<?php echo ( !is_active_sidebar( 'sidebar-1' ) ? '12' :'9' ); ?>">
			<?php 
			if( have_posts() ) :
			while( have_posts() ): the_post();
			get_template_part('content',''); 
			endwhile; endif;
			?>
        <div class="col d-flex text-center justify-content-center">
			<?php
			//Previous / next page navigation
			the_posts_pagination( array(
			'prev_text'          => '<i class="fas fa-angle-left"></i>',
			'next_text'          => '<i class="fas fa-angle-right"></i>',
			) );
			?>
        </div>
      </div>
	  <aside class="col-md-3">
        <?php get_sidebar(); ?>
      </aside>
    </div>
  </div>
</main>
<?php get_footer(); ?>