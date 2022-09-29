<# if ( data.depth == 0 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'farmart' ) ?>"
   data-panel="mega"><?php esc_html_e( 'Mega Menu', 'farmart' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'farmart' ) ?>"
   data-panel="background"><?php esc_html_e( 'Background', 'farmart' ) ?></a>
<div class="separator"></div>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'farmart' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'farmart' ) ?></a>
<# } else if ( data.depth == 1 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'farmart' ) ?>"
   data-panel="content"><?php esc_html_e( 'Menu Content', 'farmart' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu General', 'farmart' ) ?>"
   data-panel="general"><?php esc_html_e( 'General', 'farmart' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'farmart' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'farmart' ) ?></a>
<# } else { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'farmart' ) ?>"
   data-panel="content"><?php esc_html_e( 'Menu Content', 'farmart' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'farmart' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'farmart' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu General', 'farmart' ) ?>"
   data-panel="general_2"><?php esc_html_e( 'General', 'farmart' ) ?></a>
<# } #>
