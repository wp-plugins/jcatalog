<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WView::includeElement( 'listing.select' );
class Events_Access_listing extends WListing_select {




function create(){



$editable=$this->getValue('visible');

	if( $editable < 10){

		parent::create();

	}


return true;

}
}