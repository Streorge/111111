<?php
/**
 * The template for displaying the content.
 * @package Industryup
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="bs-blog-post shd">
		<div class="bs-blog-thumb">
			<?php 
			if(has_post_thumbnail()){
			echo '<a  href="'.esc_url(get_the_permalink()).'">';
			the_post_thumbnail( '', array( 'class'=>'img-fluid' ) );
			echo '</a>';
			?>
			<?php } ?>
		</div>


		<article class="small"> 
			<div class="bs-blog-category">
				<?php   $cat_list = get_the_category_list();
				if(!empty($cat_list)) { ?>
				<?php the_category(', '); ?>
				<?php } ?>
			</div>
			<h4 class="title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array('before' => 'Permalink to: ','after'  => '') ); ?>">
			<?php the_title(); ?></a>
			</h4>	
				<div class="bs-blog-meta">
				<span class="bs-blog-date"><a href="<?php echo esc_url(get_month_link(get_post_time('Y'),get_post_time('m'))); ?>">
			<?php echo esc_html(get_the_date('M j, Y')); ?></a></span>
			<span class="bs-author">
			<a class="bs-icon" href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"> <?php esc_html_e('by','industryup'); ?>
				<?php the_author(); ?>
				</a>
			</span>
			<span class="comments-link">
			 <a href="<?php echo esc_url(get_comments_link( )); ?>"><?php echo esc_html(get_comments_number()); ?> <?php esc_html_e('Comments','industryup'); ?></a>
			</span>
			<?php $tag_list = get_the_tag_list();
				if($tag_list){ ?>
				<span class="tag-links"><a href="<?php the_permalink(); ?>"><?php the_tags('', ', ', ''); ?></a></span>
			<?php } ?>

			</div>	
    		<?php the_content(__('Read More','industryup'));
				wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'industryup' ), 'after' => '</div>' ) ); ?>
		</article>
	</div>
</div>