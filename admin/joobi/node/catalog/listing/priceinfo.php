<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'main.listing.moneyconverted' );
class Catalog_Priceinfo_listing extends WListing_moneyconverted {


	function create() {



		static $productPricetypeC=null;

		$priceid = $this->getValue( 'priceid' );

		if ( empty($priceid) ) return false;



		
		$prodtypid = $this->getValue( 'prodtypid' );

		$type = $this->getValue( 'type' );



		if ( $type > 30 ) return false;



		if ( !isset($productPricetypeC) ) $productPricetypeC = WClass::get( 'product.pricetype', null, 'class', false );

		if ( !empty($productPricetypeC) && !$productPricetypeC->removePrice( $priceid, array( 10, 20 ) ) ) {

			$this->content = $productPricetypeC->getPriceTypeName( $priceid );

			return true;

		}


		return parent::create();



	}

}