<?php
namespace ElementPack\Modules\RemoteArrows;

use ElementPack\Base\Element_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Element_Pack_Module_Base {

	public function get_name() {
		return 'remote-arrows';
	}

	public function get_widgets() {
		$widgets = [
			'Remote_Arrows',
		];

		return $widgets;
	}
}
