<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'main.listing.moneyconverted' );
class Catalog_Searchprice_listing extends WListing_moneyconverted {

	function create() {

		$itemPriceType = $this->getValue( 'type', 'item.price' );
		if ( empty($itemPriceType) ) return false;

				$itemType = $this->getValue( 'type', 'item.type' );
		$prodtypid = $this->getValue( 'prodtypid', 'item' );
		$rolidviewprice = $this->getValue( 'rolidviewprice' );

		if ( $itemType < 100 && !in_array( $itemPriceType, array( 40, 50, 250 ) ) ) {

			if ( empty( $rolidviewprice ) || $rolidviewprice == 1 ) {
								if (!isset($itemTypeC)) $itemTypeC = WClass::get( 'item.type' );
				$rolidviewprice = $itemTypeC->loadData( $prodtypid, 'rolidviewprice' );
				if ( empty($rolidviewprice) || $rolidviewprice == 1 ) {
					$rolidviewprice = WPref::load('PPRODUCT_NODE_ROLIDVIEWPRICE');
				}			} else {
				$rolidviewprice = $rolidviewprice;
			}
			if ( !empty($rolidviewprice) ) {
				if ( !isset($this->_itemAccessC) ) $this->_itemAccessC = WClass::get( 'item.access' );
				$hasRole = $this->_itemAccessC->haveAccess( $rolidviewprice );
			}
			else $hasRole = true;

			if ( !$hasRole ) return false;

		}
				$discountvalue = $this->getValue( 'discountvalue', 'item' );
		$discountrate = $this->getValue( 'discountrate', 'item' );
		if ( !empty($discountvalue) || !empty($discountrate) ) {
			$price = $this->value;
			if ( $discountrate > 0 ) {
				$price = $price * ( 100 - $discountrate ) / 100;
			}
			if ( $discountvalue > 0 ) {
				$price = $price - $discountvalue;
				if ( $price < 0 ) $price = 0;
			}
			$this->value = $price;
		}
		return parent::create();

	}
}