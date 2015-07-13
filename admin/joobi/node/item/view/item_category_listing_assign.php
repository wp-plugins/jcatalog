<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_Item_category_listing_assign_view extends Output_Listings_class {


	function prepareQuery() {


		$multipelType = WPref::load( 'PITEM_NODE_CATMULTIPLETYPE' );

		if ( $multipelType ) {
			$this->removeConditions( array( 'item_category_listing_assign_prodtypid', 'item_category_listing_assign_fix' ) );
		} else {
			$this->removeConditions( array( 'item_category_listing_assign_multiple_prodtypid', 'item_category_listing_assign_multiple_fix' ) );
		}
		
		

		return true;



	}
}