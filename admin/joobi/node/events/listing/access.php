<?php 

* @link joobi.co
* @license GNU GPLv3 */


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