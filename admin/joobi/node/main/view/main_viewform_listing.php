<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Main_viewform_listing_view extends Output_Listings_class {
function prepareView() {



	$yid = WGlobals::get( 'yid' );

	$type = WView::get( $yid, 'type', null, null, false );


	if ( $type == 151 ) {

		$this->removeElements( array( 'main_viewform_listing_main_viewform_required', 'main_viewform_listing_main_viewform_readonly') );

	}


	return true;



}}