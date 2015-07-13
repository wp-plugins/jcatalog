<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















WView::includeElement( 'main.listing.moneycurrency' );
class WListing_Coremoney extends WListing_moneycurrency {





	function create() {

		static $curidUsed = null;

		if ( !isset($curidUsed) ) $curidUsed = WUser::get('curid');

		if ( !empty( $this->curid ) ) $curid = $this->curid;
		else $curid = $this->getValue( 'curid' );
		if ( empty( $curid ) ) $curid = WGlobals::get( 'curid', WPref::load('PCURRENCY_NODE_PREMIUM') );

				if ( $curid != $curidUsed && !empty($curid) && !empty($curidUsed) ) {
		    static $currencyC = null;
			if ( empty($currencyC) ) $currencyC = WClass::get( 'currency.convert',null,'class',false);
		    $convertedPrice = $currencyC->currencyConvert( $curid, $curidUsed, $this->value );
		} else {
			$convertedPrice = $this->value;
		}
		$this->content = WTools::format( $this->value, 'money', $curidUsed );

		return true;

	}
}



