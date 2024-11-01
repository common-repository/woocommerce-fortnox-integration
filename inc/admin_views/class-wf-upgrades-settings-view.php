<?php

namespace inc\admin_views;

use inc\wetail\admin\WF_Admin_Settings;
use inc\fortnox\WF_Plugin;


if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class WF_Upgrades_Settings_View {
	private static $upgrades_items = array();

	/**
	 * Adds all required setting fields for Accounting View
	 */
	public static function add_settings() {
		$page = "fortnox";

		self::set_items();

		// General tab
		WF_Admin_Settings::add_tab( [
			'page'  => $page,
			'name'  => "upgrades",
			'title' => __( "Upgrades", WF_Plugin::TEXTDOMAIN )
		] );

		// API section
		WF_Admin_Settings::add_section( [
			'page' => $page,
			'tab'  => "upgrades",
			'name' => "upgrades"
		] );

		foreach ( self::$upgrades_items as $key => $upgrade_item ):
			WF_Admin_Settings::add_custom_field( [
				'page'    => $page,
				'tab'     => "upgrades",
				'name'    => $key,
				'section' => "upgrades",
			], self::get_upgrade_item_html( $key, $upgrade_item ) );
		endforeach;
	}

	private static function set_items(): void {
		self::$upgrades_items = array(
			'fortnox_pro'     => array(
				'name'        => __( 'WooCommerce Fortnox Pro', WF_Plugin::TEXTDOMAIN ),
				'description' => __( 'Read inventory and/or prices from Fortnox to WooCommerce.', WF_Plugin::TEXTDOMAIN ),
				'link'        => 'https://wetail.io/integrationer/woocommerce-fortnox-pro-integration/',
				'price'       => '195 kr/' . __( 'month', WF_Plugin::TEXTDOMAIN ),
				'button'      => __( 'Upgrade', WF_Plugin::TEXTDOMAIN )
			),
			'klarna_fortnox'  => array(
				'name'        => __( 'Klarna Fortnox', WF_Plugin::TEXTDOMAIN ),
				'description' => __( 'Automatic reconciliation between Klarna and Fortnox.', WF_Plugin::TEXTDOMAIN ),
				'link'        => 'https://wetail.io/integrationer/klarna-fortnox-account-receivables/',
				'price'       => '195 kr/' . __( 'month', WF_Plugin::TEXTDOMAIN ),
				'button'      => __( 'Upgrade', WF_Plugin::TEXTDOMAIN )
			),
			'wetail_shipping' => array(
				'name'        => __( 'Wetail Shipping', WF_Plugin::TEXTDOMAIN ),
				'description' => __( 'Print shipping labels and book carrier directly from WooCommerce order admin.', WF_Plugin::TEXTDOMAIN ),
				'link'        => 'https://wetail.io/integrationer/wetail-shipping/',
				'price'       => __( 'View pricing', WF_Plugin::TEXTDOMAIN ),
				'button'      => __( 'Order', WF_Plugin::TEXTDOMAIN )
			)
		);
	}

	/**
	 * @param string $key
	 * @param array $upgrade_item
	 *
	 * @return string
	 */
	private static function get_upgrade_item_html( string $key, array $upgrade_item ): string {
		$icon_link = '<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M7.86206 1H12M12 1V5M12 1L7.86206 5" stroke="#007CBA" stroke-linecap="round" stroke-linejoin="round"/>
		<path d="M5.13793 3H1V12H10.6552V8.33333" stroke="#007CBA" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>';

		$html = '<li class="upgrades__item ' . $key . '">';

		$html .= '<span class="upgrades__item--content">';
		$html .= '<h4 class="name">' . $upgrade_item[ 'name' ] . '</h4>';
		$html .= '<p class="description">' . $upgrade_item[ 'description' ] . '</p>';
		$html .= '<a href="' . $upgrade_item[ 'link' ] . '" target="_blank" class="more-info-link">' . __( 'More info', WF_Plugin::TEXTDOMAIN ) . ' ' . $icon_link . '</a>';
		$html .= '</span>';
		$html .= '<span class="upgrades__item--footer">';
		$html .= '<span class="price">' . $upgrade_item[ 'price' ] . '</span>';
		$html .= '<a href="' . $upgrade_item[ 'link' ] . '" class="button" target="_blank">' . $upgrade_item[ 'button' ] . '</a>';
		$html .= '</span>';

		$html .= '</li>';

		return $html;
	}
}
