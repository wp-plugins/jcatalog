<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Wishlist_Wishlist_my_products_listing_wishlist_items_view extends Output_Listings_class {

	function prepareQuery() {



		$eid = WGlobals::getEID();
		if ( empty($eid) ) return false;



		return true;



	}
}