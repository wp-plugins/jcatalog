<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_related_listing_controller extends WController {




function show() {


	
	$pid = WGlobals::getEID();



	if ( WRoles::isNotAdmin( 'storemanager' ) ) {

		if ( empty( $pid ) ) {

			$message = WMessage::get();

			$message->exitNow( 'Unauthorized access 128' );

		}


		
		$productHelperC = WClass::get( 'item.restriction', null, 'class', false);

 		if ( $productHelperC ) $result = $productHelperC->filterRestriction( 'query', 'item', 'pid', $pid );

		else $result = false;



		if ( !$result ) {

			$message = WMessage::get();

			$message->exitNow( 'Unauthorized access 129' );

		}
	}






	






	return true;


}
}