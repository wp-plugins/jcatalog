<?php 

* @link joobi.co
* @license GNU GPLv3 */

















WView::includeElement( 'listing.text' );
class WListing_Coretextarea extends WListing_text {





	function create() {
		$this->value = str_replace( array( "\n", "\r" ) , '<br />', $this->value );
		return parent::create();
	}
}