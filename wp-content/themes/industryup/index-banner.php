<?php
$breadcrumb_display = get_theme_mod('breadcrumb_display','1');
if($breadcrumb_display == '1')
{
$background_image = get_theme_support( 'custom-header', 'default-image' );

if ( has_header_image() ) {
  $background_image = get_header_image();
}

$breadcrumb_img_type_display = get_theme_mod('breadcrumb_img_type_display','scroll');
?>

<div class="bs-breadcrumb-section" style='background-image: linear-gradient(132deg, #f9f9f9 50% ,transparent 50%),url("<?php echo esc_url( $background_image ); ?>");     background-attachment: <?php echo esc_attr($breadcrumb_img_type_display); ?>  
;'>

  <div class="overlay">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12">
			   <?php echo industryup_archive_page_title(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<?php } ?>