<?php 

* @link joobi.co
* @license GNU GPLv3 */




WView::includeElement( 'main.listing.iptracker' );
class Comment_CoreIpcheck_listing extends WListings_iptracker {










function listing() {




	$installed = WExtension::exist( 'iptracker.node' );
	if ( !empty($installed) && WGlobals::checkCandy(50) ) {						return parent::create();

	} else {

		return false;

	}


}}