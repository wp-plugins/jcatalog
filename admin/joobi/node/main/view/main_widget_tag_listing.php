<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Main_widget_tag_listing_view extends Output_Listings_class {

function prepareView() {



	if ( 'joomla' != JOOBI_FRAMEWORK_TYPE ) return true;



	
	if ( ! WApplication::isEnabled( 'main_content_plugin', true, false ) ) {

		$message = WMessage::get();

		$message->userW('1434036710ZKH');
		$message->userW('1434036710ZKI');

	}




	return true;



}
}