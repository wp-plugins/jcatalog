<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Item_terms_listing_view extends Output_Listings_class {

	function prepareQuery() {



		if ( WRoles::isAdmin( 'storemanager' ) || WRole::hasRole( 'storemanager' ) ) {

			$this->removeConditions( array( 'item_terms_listing_share', 'item_terms_listing_vendid' ) );

		}


		return true;



	}
}