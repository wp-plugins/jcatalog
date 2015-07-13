<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_Itemterms_picklist extends WPicklist {

function create() {



	$controller = WGlobals::get('controller');

	$task = WGlobals::get('task');

	$namekey = $this->getParamsValue('namekey');

	$type = 1;

	$itemTermsM = WModel::get('item.terms');



	if ($namekey == 'item_term_licenses_general'
	|| $namekey == 'item_term_licenses_type'
	|| $namekey == 'item_term_licenses_item') $type = array( 1,3,4 );
	else $type = array( 2 ); 


	$itemTermsM->select('termid');

	$itemTermsM->select('alias');


	$itemTermsM->whereIn('type', $type );

	$itemTermsM->whereE('publish', 1 );
	$itemTermsM->checkAccess();

		if ( WRoles::isNotAdmin( 'storemanager' ) ) {
		$vendorHelperC = WClass::get( 'vendor.helper' );
		$vendid = $vendorHelperC->getVendorID();
		$itemTermsM->openBracket();
		$itemTermsM->whereE( 'vendid', $vendid );
		$itemTermsM->operator( 'OR' );
		$itemTermsM->whereE( 'share', 1 );
		$itemTermsM->closeBracket();
	}

	$resultsA = $itemTermsM->load('ol');




	if ( empty($resultsA) ) return false;



	if ( 'preferences' != $task ) {

		if ( ( $controller == 'item-type' ) ) {
			$this->addElement( 'general', WText::t('1310465174GEKS') );
		} elseif( WRoles::isNotAdmin( 'storemanager' ) ) {
						$this->addElement( 'type', WText::t('1206732425HINT') );
		} else {
						$this->addElement( 'general', WText::t('1310465174GEKS') );
			$this->addElement( 'type', WText::t('1310465174GEKT') );
		}
	}














	if (!empty($resultsA)) {

		foreach( $resultsA as $key => $result) {

			$this->addElement( $result->termid , $result->alias);

		}
	} else {

		return false;

	}

	return true;


}
}