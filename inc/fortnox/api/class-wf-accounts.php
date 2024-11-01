<?php

namespace inc\fortnox\api;

if ( !defined( 'ABSPATH' ) ) die();


class WF_Accounts {

    /** Fetches all payment terms from Fortnox
     * @return array
     * @throws \Exception
     */
    public static function get_and_store_accounts_from_fortnox(){
        $accounts = self::fetch_all_accounts();
	    $active_accounts = self::filter_accounts( $accounts );

	    $map_func = function ( $account ){
			return [
				'number'=> $account['Number'],
				'name'  => $account['Description']
			];
	    };

	    $active_accounts = array_map( $map_func, $active_accounts );

        self::store_asset_accounts( $active_accounts );
        self::store_own_capital_and_debts_accounts( $active_accounts );
        self::store_revenue_accounts( $active_accounts );
    }

	/**
	 * @param $response
	 *
	 * @return mixed
	 */
	public static function normalize_response($response){
		$response = json_encode( $response, JSON_PRETTY_PRINT);
		return json_decode( $response, true);
	}

	/**
	 * Fetches all accounts from Fortnox. Response from Fortnox is made into an assoc array since Fortnox uses @ in reponse
	 */
	public static function fetch_all_accounts(){
		$response = WF_Request::get( '/accounts?limit=500' );
		$response = self::normalize_response( $response );
		$accounts = $response['Accounts'];
		$total_pages = $response['MetaInformation']['@TotalPages'];

		for( $index = 2; $index <= $total_pages; $index++){
			$response = WF_Request::get( sprintf('/accounts?limit=500&page=%d', $index ));
			$response = self::normalize_response( $response );
			$accounts = array_merge($accounts, $response['Accounts']);
		}
		return $accounts;
	}

	/**
	 * Filters out inactive accounts below 4000
	 */
	private static function filter_accounts( $accounts ){
		$filter_func = function ( $account ){
			if( $account['Active'] && $account['Number'] < 4000) {
				return true;
			}
		};

		return array_filter( $accounts, $filter_func );
	}

	/**
	 * Returns asset accounts
	 */
	public static function get_asset_accounts(){
		return get_option( 'fortnox_asset_accounts' );
	}

	/**
	 * Returns own capital and debts accounts
	 */
	public static function get_own_capital_and_debts_accounts(){
		return get_option( 'fortnox_own_capital_and_debts_accounts' );
	}

	/**
	 * Returns revenue accounts
	 */
	public static function get_revenue_accounts(){
		return get_option( 'fortnox_revenue_accounts' );
	}

	/**
	 * Save asset accounts
	 */
	private static function store_asset_accounts( $accounts ){
		$filter_func = function ( $account ){
			if( $account['number'] < 2000) {
				return true;
			}
		};

		update_option('fortnox_asset_accounts', array_filter( $accounts, $filter_func ) );
	}

	/**
	 * Save own capital and debts accounts
	 */
	private static function store_own_capital_and_debts_accounts( $accounts ){
		$filter_func = function ( $account ){
			if( $account['number'] >= 2000 && $account['number'] <= 3000) {
				return true;
			}
		};

		update_option('fortnox_own_capital_and_debts_accounts', array_filter( $accounts, $filter_func ) );
	}

	/**
	 * Save revenue accounts
	 */
	private static function store_revenue_accounts( $accounts ){
		$filter_func = function ( $account ){
			if( $account['number'] >= 3000 && $account['number'] <= 4000) {
				return true;
			}
		};

		update_option('fortnox_revenue_accounts', array_filter( $accounts, $filter_func ) );
	}
}
