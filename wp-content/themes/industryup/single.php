<!-- =========================
     Page Breadcrumb   
============================== -->
<?php get_header();
$background_image = get_theme_support( 'custom-header', 'default-image' );

if ( has_header_image() ) {
  $background_image = get_header_image();
}
?>

<div class="bs-breadcrumb-section" style='background-image: url("<?php echo esc_url( $background_image ); ?>" );'>
<div class="overlay">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12">
			    <div class="bs-breadcrumb-title">
            <h1><?php the_title(); ?></h1>
			       <div class="bs-blog-meta">
              <span class="bs-blog-date"><?php echo esc_html(get_the_date('M')); ?> <?php echo esc_html(get_the_date('j,')); ?> <?php echo esc_html(get_the_date('Y')); ?></span>
              <span class="cat-links">
              <?php $cat_list = get_the_category_list();
                if(!empty($cat_list)) { ?>
                  <?php the_category(', '); ?>
                <?php } ?>
              </span>
             </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<!-- =========================
     Page Content Section      
============================== -->
<main id="content">
  <div class="container">
    <div class="row"> 
      <div class="col-md-<?php echo ( !is_active_sidebar( 'sidebar-1' ) ? '12' :'9' ); ?> col-sm-8">
		      <?php if(have_posts())
		        {
		      while(have_posts()) { the_post(); ?>
          <div class="col-md-12">
            <div class="bs-blog-post shd single"> 
              <?php 
              if(has_post_thumbnail()){
              echo '<a class="bs-blog-thumb">';
              the_post_thumbnail( '', array( 'class'=>'img-responsive' ) );
              echo '</a>';
               } ?>
              <article class="small">
              <?php the_content(); ?>
                <?php wp_link_pages(array(
                'before' => '<div class="single-nav-links">',
                'after' => '</div>',
                ));
                ?>
              </article>
            </div>
          </div>
		      <?php } ?>
		      <div class="col-md-12 text-center">
            <?php the_posts_navigation(); ?>
          </div>  
          <div class="col-md-12">
            <div class="media bs-info-author-block shd p-4 mb-5"> <a class="bs-author-pic mr-3" href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 160 ); ?></a>
			<div class="media-body">
                <h4 class="media-heading"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><?php the_author(); ?></a></h4>
                <p><?php the_author_meta( 'description' ); ?></p>
              </div>
            </div>
          </div>
		      <?php } ?>
         <?php comments_template('',true); ?>
      </div>
      <div class="col-md-3 col-sm-4">
      <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>