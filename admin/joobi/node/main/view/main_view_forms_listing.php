<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_Main_view_forms_listing_view extends Output_Listings_class {

	function prepareQuery() {



		if ( WPref::load( 'PMAIN_NODE_SHOWHIDDENVIEW' ) ) {

			$this->removeConditions( array( 'main_view_listings_listing_useredit' ) );

		}


		return true;



	}
}