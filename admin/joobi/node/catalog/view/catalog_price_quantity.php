<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_price_quantity_view extends Output_Forms_class {
protected function prepareView() {



	$pid = WGlobals::getEID();

	if ( empty( $pid ) ) $pid = $this->getValue( 'pid' );



	$priceType = $this->getValue( 'type', 'product.price' );	




	
	
	$availableStartDate = $this->getValue( 'availablestart' );

	$availableEndDate = $this->getValue( 'availableend' );



	
	
	
	
	if ( !empty( $availableEndDate ) && ( time() > $availableEndDate ) ) $isAvailable = 'expired';

	else {

		if ( time() > $availableStartDate ) $isAvailable = 'avail';

		else $isAvailable = 'unavail';

	}
	WGlobals::set( 'productAvailable', $isAvailable, 'global' );



	
	
	if ( $priceType == 110 ) {

		$priceToShow = 'itemtype';

		$showPriceType = true;

	} else {

		$priceToShow = 'itemprice';

		$showPriceType = false;

	}


	$this->setValue( 'pricetoshow', $priceToShow );

	$this->setValue( 'showpricetype', $showPriceType );



	
	
	$this->setValue( 'pricetype', $priceType );





	return true;

}}