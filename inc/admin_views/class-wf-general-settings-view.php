<?php

namespace inc\admin_views;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use inc\fortnox\api\WF_Company_Information;
use inc\fortnox\WF_Plugin;
use inc\wetail\admin\WF_Admin_Settings;

class WF_General_Settings_View {

	/**
	 * Adds all required setting fields for General Settings View
	 */
	public static function add_settings() {
		$page = "fortnox";

		// General tab
		WF_Admin_Settings::add_tab( [
			'page'  => $page,
			'name'  => "general",
			'title' => __( "General", WF_Plugin::TEXTDOMAIN )
		] );

		// API section
		WF_Admin_Settings::add_section( [
			'page' => $page,
			'tab'  => "general",
			'name' => "api"
		] );

		WF_Admin_Settings::add_custom_field( [
			'title'   => __( "Status", WF_Plugin::TEXTDOMAIN ),
			'page'    => $page,
			'tab'     => "general",
			'name'    => "fortnox_license_status",
			'section' => "api",
		], self::get_app_status_html() );

		// API key field
		WF_Admin_Settings::add_field( [
			'page'        => $page,
			'tab'         => "general",
			'section'     => "api",
			'name'        => "fortnox_license_key",
			'title'       => __( "1. Wetail license key", WF_Plugin::TEXTDOMAIN ),
			'description' => __( 'Your Wetail license key that you got in the confirmation mail of your order.<br>If you haven\'t signed up yet, <a href="https://wetail.io/service/integrationer/woocommerce-fortnox/" target="_blank">use this link</a>.', WF_Plugin::TEXTDOMAIN ),
			'after'       =>
				'<a href="#" class="button fortnox-check-connection">' . __( "Save and check", WF_Plugin::TEXTDOMAIN ) . '</a> ' .
				'<span class="spinner fortnox-spinner"></span><span class="alert"></span>'
		] );

		WF_Admin_Settings::add_field( [
			'page'        => $page,
			'tab'         => "general",
			'section'     => "api",
			'name'        => "fortnox_organization_number",
			'title'       => __( "2. Organization number", WF_Plugin::TEXTDOMAIN ),
			'description' => __( 'Add your organization number here', WF_Plugin::TEXTDOMAIN ),
			'after'       =>
				'<a href="#" class="button fortnox-check-connection">' . __( "Register application", WF_Plugin::TEXTDOMAIN ) . '</a> ' .
				'<span class="spinner fortnox-spinner"></span><span class="alert"></span>'
		] );


		WF_Admin_Settings::add_custom_field( [
			'title'   => __( "3. Activate app in Fortnox", WF_Plugin::TEXTDOMAIN ),
			'page'    => $page,
			'tab'     => "general",
			'name'    => "fortnox_activate_app",
			'section' => "api",
		], self::get_activate_app_html() );

		WF_Admin_Settings::add_field( [
			'page'    => $page,
			'tab'     => "general",
			'section' => "api",
			'title'   => __( "4. Fetch settings from Fortnox", WF_Plugin::TEXTDOMAIN ),
			'type'    => "button",
			'button'  => [
				'text' => __( "Fetch settings", WF_Plugin::TEXTDOMAIN ),
			],
			'data'    => [
				[
					'key'   => "fortnox-bulk-action",
					'value' => "fortnox_get_settings"
				]
			]
		] );

		// class-wf-products section
		/* Hidden section and fields
		WF_Admin_Settings::add_section( [
			'page' => $page,
			'tab'  => "general",
			'name' => "debug",
		] );

		WF_Admin_Settings::add_field( [
			'page'    => $page,
			'tab'     => 'general',
			'section' => 'debug',
			'type'    => 'checkboxes',
			'title'   => __( 'Debug', WF_Plugin::TEXTDOMAIN ),
			'options' => [
				[
					'name'        => 'fortnox_debug_log',
					'label'       => __( 'Activate logging', WF_Plugin::TEXTDOMAIN ),
					'description' => __( 'Unnecessary logging can clog your system resources.', WF_Plugin::TEXTDOMAIN ) . ' <span class="red warning">' . __( 'Turn off when not debugging!', WF_Plugin::TEXTDOMAIN ) . '</span><br>' . __( 'The debug log can be found in <b>WooCommerce</b> -> <b>Status</b> -> <b>Logs</b>', WF_Plugin::TEXTDOMAIN )
				]
			]
		] );

		$organization_number = ( $organization_number = self::get_connected_org_number() ) ? $organization_number : '<span class="red warning">' . __( 'NOT CONNECTED', WF_Plugin::TEXTDOMAIN ) . '</span>';
		WF_Admin_Settings::add_field( [
			'page'    => $page,
			'tab'     => 'general',
			'section' => 'debug',
			'type'    => 'info',
			'value'   => $organization_number,
			'title'   => __( 'Organization registration number in Fortnox<br>(if connected)', WF_Plugin::TEXTDOMAIN ),
			'tooltip' => __( "This is a read-only information that shows the organization registration number of the company in Fortnox that you are connected to.", WF_Plugin::TEXTDOMAIN )
		] ); */
	}

	private static function get_connected_org_number() {
		$organization_number = get_option( 'fortnox_connected_organization_number' );

		if ( $organization_number ) {
			return $organization_number;
		}

		$organization_number = WF_Company_Information::get_organization_number();

		if ( $organization_number ) {
			update_option( 'fortnox_connected_organization_number', $organization_number );

			return $organization_number;
		}
	}

	private static function get_app_status_html(): string {
		$organization_number = self::get_connected_org_number();
		$html                = "";
		$org_number          = get_option( 'fortnox_connected_organization_number', '' );
		$is_active = ! empty( $org_number );

		if ( $is_active ) {
			$html          .= '<span class="license-status active" data-logged-out-text="' . __( 'Inactive application', WF_Plugin::TEXTDOMAIN ) . '">';
			$logged_in_lin = '<a class="fortnox-logged-out" href="#">' . __( 'Log out', WF_Plugin::TEXTDOMAIN ) . '</a>';
			$text          = sprintf( __( 'Your application is active. %s', WF_Plugin::TEXTDOMAIN ), $logged_in_lin );

			if ( $organization_number ) {
				$text = sprintf( __( 'Your application is active with %s as your organization number. %s', WF_Plugin::TEXTDOMAIN ), $organization_number, $logged_in_lin );
			}

			$html .= '<span>' . $text . '</span>';
		} else {
			$html .= '<span class="license-status not-active">';
			$html .= __( 'Inactive application', WF_Plugin::TEXTDOMAIN );
		}

		$html .= "</span>";

		return $html;
	}

	private static function get_activate_app_html(): string {
		$html = '<a class="button" href="https://api.wetail.io/integrations/fortnox/auth" target="_blank">' . __( 'Activate app', WF_Plugin::TEXTDOMAIN ) . '</a>';

		$html .= '<p class="description" style="max-width: 341px;">' . __( 'Go to Fortnox and activate the application. Note! You need to be logged in to Fortnox to do this.', WF_Plugin::TEXTDOMAIN ) . '</p>';

		return $html;
	}
}
