<div id="tamm-panel-icon" class="tamm-panel-icon tamm-panel">
	<div class="tamm-panel-box-large mega-setting">
		<span class="setting-field tamm-panel-select-field tamm-panel-icon_type" data="{{data.megaData.icon_type}}">
			<label><?php esc_html_e( 'Icon Type', 'farmart' ) ?></label>
			<select name="{{ taMegaMenu.getFieldName( 'icon_type', data.data['menu-item-db-id'] ) }}">
				<option value="none"><?php esc_html_e( 'None', 'farmart' ) ?></option>
				<option value="svg" {{ 'svg' == data.megaData.icon_type ? 'selected="selected"' : '' }}><?php esc_html_e( 'SVG', 'farmart' ) ?></option>
				<option value="image" {{ 'image' == data.megaData.icon_type ? 'selected="selected"' : '' }}><?php esc_html_e( 'Image', 'farmart' ) ?></option>
				<option value="text" {{ 'text' == data.megaData.icon_type ? 'selected="selected"' : '' }}><?php esc_html_e( 'Text', 'farmart' ) ?></option>
			</select>
		</span>

		<div class="setting-field setting-field-svg setting-field-select" style="{{ 'svg' == data.megaData.icon_type ? '' : 'display: none;' }}">
			<p class="tamm-icon-color">
				<label><?php esc_html_e( 'SVG Color', 'farmart' ) ?></label><br>
				<input type="text" class="tamm-icon-color-picker"
					name="{{ taMegaMenu.getFieldName( 'icon_color', data.data['menu-item-db-id'] ) }}"
					value="{{ data.megaData.icon_color }}">
			</p>
			<hr>
		</div>

		<div class="setting-field setting-field-svg" style="{{ 'svg' == data.megaData.icon_type ? '' : 'display: none;' }}">
			<p>
				<textarea name="{{ taMegaMenu.getFieldName( 'icon_svg', data.data['menu-item-db-id'] ) }}" class="widefat tamm-panel-icon_svg" rows="20" contenteditable="true">
                   <# if ( data.megaData.icon_svg ) { #>
					<?php echo \Farmart\Icon::sanitize_svg('{{{ data.megaData.icon_svg }}}');?>
                    <# } #>
                </textarea>
			</p>
		</div>
		<div class="setting-field setting-field-image" style="{{ 'image' == data.megaData.icon_type ? '' : 'display: none;' }}">
			<p class="background-image">
				<label><?php esc_html_e( 'Image', 'farmart' ) ?></label><br>
				<span class="background-image-preview">
					<# if ( data.megaData.icon_image ) { #>
						<img src="{{ data.megaData.icon_image }}">
					<# } #>
				</span>

				<button type="button"
						class="button remove-button {{ ! data.megaData.icon_image ? 'hidden' : '' }}"><?php esc_html_e( 'Remove', 'farmart' ) ?></button>
				<button type="button" class="button upload-button"
						id="imageSVG-button"><?php esc_html_e( 'Select Image', 'farmart' ) ?></button>

				<input class="tamm-panel-icon_image" type="hidden" name="{{ taMegaMenu.getFieldName( 'icon_image', data.data['menu-item-db-id'] ) }}"
					value="{{ data.megaData.icon_image }}">
			</p>
		</div>

		<div class="setting-field setting-field-text" style="{{ 'text' == data.megaData.icon_type ? '' : 'display: none;' }}">
			<p>
				<input class="tamm-panel-icon_text widefat" type="text" name="{{ taMegaMenu.getFieldName( 'icon_text', data.data['menu-item-db-id'] ) }}"
					value="{{ data.megaData.icon_text }}">
			</p>
		</div>

		<div class="setting-field setting-field-text setting-field-select" style="{{ 'text' == data.megaData.icon_type ? '' : 'display: none;' }}">
			<p class="tamm-icon-color">
				<label><?php esc_html_e( 'Text Color', 'farmart' ) ?></label><br>
				<input type="text" class="tamm-icon-color-picker"
					name="{{ taMegaMenu.getFieldName( 'icon_text_color', data.data['menu-item-db-id'] ) }}"
					value="{{ data.megaData.icon_text_color }}">
			</p>
		</div>

	</div>


</div>