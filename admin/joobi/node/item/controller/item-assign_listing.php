<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_assign_listing_controller extends WController {

	function listing() {



		$catid = WGlobals::get('catid');



		if ( WRoles::isNotAdmin( 'storemanager' ) ) {

			if ( empty( $catid ) ) {

				$message = WMessage::get();

				$message->exitNow( 'Unauthorized access 121' );

			}


			
			$productHelperC = WClass::get( 'item.restriction', null, 'class', false);

	 		if ( $productHelperC ) $result = $productHelperC->filterRestriction( 'query', 'item.category', 'catid', $catid );

			else $result = false;



			if ( !$result ) {

				$message = WMessage::get();

				$message->exitNow( 'Unauthorized access 122' );

			}
		}


		
		$categoryproductM = WModel::get( 'item.categoryitem' );

		$categoryproductM->whereE( 'catid', $catid );

		$categoryproduct = $categoryproductM->load('lra', 'pid');


		return true;


	}
}