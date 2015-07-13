<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_category_listing_controller extends WController {
function listing() {


	if ( WRoles::isNotAdmin( 'storemanager' ) ) {


		$roleC = WRole::get();
		$isStoreManger = WRole::hasRole( 'storemanager' );

		if ( $isStoreManger ) return true;

				if ( ! WPref::load( 'PITEM_NODE_ALLOWVENDORCAT' ) ) return false;

		
		$productHelperC = WClass::get( 'item.restriction', null, 'class', false);

 		if ( $productHelperC ) $result = $productHelperC->filterRestriction();

		else $result = false;


		if ( !$result ) {

			$message = WMessage::get();

			$message->exitNow( 'Unauthorized access 125' );

		}









	}


	return true;

}}