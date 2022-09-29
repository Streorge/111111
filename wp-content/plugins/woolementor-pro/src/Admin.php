<?php
/**
 * All admin facing functions
 */
namespace Codexpert\Woolementor_Pro;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\Metabox;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author codexpert <hello@codexpert.io>
 */
class Admin extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'woolementor-pro', false, WOOLEMENTOR_PRO_DIR . '/languages/' );
	}

	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {

		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';

		wp_enqueue_style( "select2", 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css' );
		wp_enqueue_style( "{$this->slug}", plugins_url( "/assets/css/style{$min}.css", WOOLEMENTOR_PRO ), $this->version, 'all' );

		wp_enqueue_script( "select2", 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['jquery'] );
		wp_enqueue_script( "{$this->slug}", plugins_url( "/assets/js/admin{$min}.js", WOOLEMENTOR_PRO ), ['jquery'], $this->version, true );
		$localized = array(
			'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
		);
		wp_localize_script( $this->slug, 'WOOLEMENTOR_PRO', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	public function widget_links( $links ) {
		unset( $links['gopro'] );

		return $links;
	}

	public function action_links( $links ) {
		$deactivate = $links['deactivate'];
		unset( $links['deactivate'] );
		$links['settings'] = '<a href="' . add_query_arg( 'page', 'woolementor', admin_url( 'admin.php' ) ) . '">' . __( 'Settings', 'woolementor-pro' ) . '</a>';
		$links['deactivate'] = $deactivate;

		return $links;
	}

	public function plugin_row_meta( $plugin_meta, $plugin_file ) {
		
		if ( $this->plugin['basename'] === $plugin_file ) {
			$plugin_meta['doc'] = '<a href="https://help.codexpert.io/docs/codesigner/?utm_campaign=plugins-page" target="_blank" class="wl-plugins-help">' . __( 'Documentation', 'woolementor-pro' ) . '</a>';
			$plugin_meta['help'] = '<a href="https://help.codexpert.io/tickets/?utm_campaign=plugins-page" target="_blank" class="wl-plugins-help">' . __( 'Support', 'woolementor-pro' ) . '</a>';
		}

		return $plugin_meta;
	}

	public function supports_payment_form( $supports, $features, $ins  )	{
		if( $features == 'payment_form' && wcd_is_edit_mode() ) {
			return false;
		}

		return $supports;
	}

	public function conditions_for_templates()	{
		?>
			<div class="wl-templates-conditions">
				<?php echo Helper::get_template( 'template-conditions' ) ?>
			</div>
		<?php
	}

	public function save_template_data( $post_id ){

		if ( isset( $_GET['wl_template_conditions'] ) ) {
			foreach (  sanitize_text_field( $_GET['wl_template_conditions']  ) as $key => $value ) {
				update_post_meta( $post_id, 'wl_'.$key, $value );
			}

			update_option( 'wl_template_conditions', sanitize_text_field( $_GET['wl_template_conditions'] ) );
		}
	}

	public function pseudo_page_ids( $posts )	{
		$posts['home'] = __( 'Home', 'woolementor-pro' );

		return $posts;
	}
}