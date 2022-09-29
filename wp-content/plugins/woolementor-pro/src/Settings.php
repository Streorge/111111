<?php
/**
 * All settings related functions
 */
namespace Codexpert\Woolementor_Pro;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\License;

/**
 * @package Plugin
 * @subpackage Settings
 * @author codexpert <hello@codexpert.io>
 */
class Settings extends Base {

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

	public function settings_fields( $args ) {
		unset( $args['sections']['wcd_upgrade'] );

		$email_templates	= Helper::get_posts( [ 'post_type' => 'elementor_library', 'meta_key' => '_elementor_template_type', 'meta_value' => 'wl-email' ] );
		$email_templates	= [ '' => __( 'Use WooCommerce Default', 'woolementor-pro' ) ] + $email_templates;
		$add_new_url		= add_query_arg( [ 'post_type' => 'elementor_library', 'tabs_group' => 'library', 'elementor_library_type' => 'wl-email' ], admin_url( 'edit.php' ) );

		$args['sections']['wcd_email_designer'] = array(
			'id'        => 'wcd_email_designer',
			'label'     => __( 'Email Designer', 'woolementor-pro' ),
			'icon'      => 'dashicons-email-alt',
			'color'		=> '#7D3CF7',
			'sticky'	=> false,
			'fields'    => [
				'emails-tab' => [
				'id'      => 'emails-tab',
				'label'     => __( 'Customer Emails' ),
				'type'      => 'tabs',
				'items'     => [
					'customer-emails' => [
						'id'      => 'customer-emails',
						'label'     => __( 'Customer Emails', 'woolementor-pro' ),
						'fields'    => [
							'customer-completed-order' => [
								'id'      	=> 'customer-completed-order',
								'label'     => __( 'Completed Order', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'Completed Order', 'woolementor-pro' ), $add_new_url ),
							],
							'customer-invoice' => [
								'id'      	=> 'customer-invoice',
								'label'     => __( 'Customer Invoice', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'Customer Invoice', 'woolementor-pro' ), $add_new_url ),
							],
							'customer-new-account' => [
								'id'      	=> 'customer-new-account',
								'label'     => __( 'New Account', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'New Account', 'woolementor-pro' ), $add_new_url ),
							],
							'customer-note' => [
								'id'      	=> 'customer-note',
								'label'     => __( 'Customer Note', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'Customer Note', 'woolementor-pro' ), $add_new_url ),
							],
							'customer-on-hold-order' => [
								'id'      	=> 'customer-on-hold-order',
								'label'     => __( 'On-hold Order', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'On-hold', 'woolementor-pro' ), $add_new_url ),
							],
							'customer-processing-order' => [
								'id'      	=> 'customer-processing-order',
								'label'     => __( 'Processing Order', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'Processing Order', 'woolementor-pro' ), $add_new_url ),
							],
							'customer-refunded-order' => [
								'id'      	=> 'customer-refunded-order',
								'label'     => __( 'Refunded Order', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'Refunded Order', 'woolementor-pro' ), $add_new_url ),
							],
							'customer-reset-password' => [
								'id'      	=> 'customer-reset-password',
								'label'     => __( 'Reset Password', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'Reset Password', 'woolementor-pro' ), $add_new_url ),
							],
						],
					],
					'admin-emails' => [
						'id'      => 'admin-emails',
						'label'     => __( 'Admin Emails', 'woolementor-pro' ),
						'fields'    => [
							'admin-new-order' => [
								'id'      	=> 'admin-new-order',
								'label'     => __( 'New Order', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'New Order', 'woolementor-pro' ), $add_new_url ),
							],
							'admin-cancelled-order' => [
								'id'      	=> 'admin-cancelled-order',
								'label'     => __( 'Cancelled Order', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'Cancelled Order', 'woolementor-pro' ), $add_new_url ),
							],
							'admin-failed-order' => [
								'id'      	=> 'admin-failed-order',
								'label'     => __( 'Failed Order', 'woolementor-pro' ),
								'type'      => 'select',
								'chosen'	=> true,
								'options'	=> $email_templates,
								'desc'      => sprintf( __( 'Choose a template that\'ll replace WooCommerce\'s <strong>%s</strong> email. <a href="%s" target="_blank">Create one</a> if you haven\'t created any.', 'woolementor-pro' ), __( 'Failed Order', 'woolementor-pro' ), $add_new_url ),
							],
						],
					],
				],
			],
			],
		);

		$args['sections']['wcd_license'] = array(
			'id'        => 'wcd_license',
			'label'     => __( 'License', 'woolementor-pro' ),
			'icon'      => 'dashicons-admin-network',
			'color'		=> '#ec5ca7',
			'hide_form'	=> true,
			'content'   => $this->plugin['license']->activator_form(),
		);

		return $args;
	}
}