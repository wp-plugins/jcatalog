<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Wishlist_Wishlist_my_products_listing_wishlist_items_view extends Output_Listings_class {

	function prepareQuery() {



		$eid = WGlobals::getEID();
		if ( empty($eid) ) return false;



		return true;



	}
}