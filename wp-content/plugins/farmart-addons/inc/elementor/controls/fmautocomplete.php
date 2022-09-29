<?php

namespace FarmartAddons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class FMautocomplete extends \Elementor\Base_Data_Control {

	/**
	 * Get heading control type.
	 *
	 * Retrieve the control type, in this case `heading`.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'fmautocomplete';
	}

	public function enqueue() {
		// Styles
		wp_register_style( 'fmautocomplete', FARMART_ADDONS_URL . 'assets/css/admin/autocomplete.css', [], '20191807' );
		wp_enqueue_style( 'fmautocomplete' );

		// Scripts
		wp_register_script( 'fmautocomplete', FARMART_ADDONS_URL . 'assets/js/admin/autocomplete.js', [
			'jquery',
			'jquery-ui-autocomplete',
			'jquery-ui-sortable'
		], '20191807', true );
		wp_enqueue_script( 'fmautocomplete' );
	}

	/**
	 * Get heading control default settings.
	 *
	 * Retrieve the default settings of the heading control. Used to return the
	 * default settings while initializing the heading control.
	 *
	 * @since  1.0.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'multiple' => false,
			'sortable' => false,
			'source'   => 'category' // post type or taxonomy
		];
	}

	/**
	 * Render heading control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
        <div class="elementor-control-field">
            <# if ( data.label ) {#>
            <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <# } #>
            <div class="elementor-control-input-wrapper">
                <ul class="fm_autocomplete">
                    <li class="fm_autocomplete-input">
                        <input class="fm_autocomplete_param" type="text" placeholder="{{ data.placeholder }}"/>
                        <input class="fm_autocomplete_value" type="hidden" data-source="{{data.source}}"
                               data-multiple="{{data.multiple}}"
                               data-sortable="{{data.sortable}}" value="{{data.controlValue}}"/>
                        <span class="loading"></span>
                    </li>

                    <li class="fm_autocomplete-loading">
                        <span class="loading"></span>
                    </li>
					<?php
					?>
                </ul>

            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
		<?php
	}

}