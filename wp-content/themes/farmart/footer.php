<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Farmart
 */

?>

<?php do_action( 'farmart_before_site_content_close' );?>
</div><!-- #content -->
<?php do_action( 'farmart_before_footer' ) ?>
<footer id="colophon" class="site-footer">
	<?php do_action( 'farmart_footer' ) ?>
</footer><!-- #colophon -->
<?php do_action( 'farmart_after_footer' ) ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
