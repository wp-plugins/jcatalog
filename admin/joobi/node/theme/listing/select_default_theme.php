<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'listing.radio' );
class Theme_Select_default_theme_listing extends WListing_radio {
function create(){

	if($this->getValue('premium')==1){

		$this->checked=true ;

	}

	parent::create();

	return true;

}}