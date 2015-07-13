<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Main_view_listing_view extends Output_Listings_class {
function prepareQuery() {



if ( WPref::load( 'PMAIN_NODE_SHOWHIDDENVIEW' ) ) {

	$this->removeConditions( array( 'main_view_listing_useredit' ) );

}


	return true;

	

}
}