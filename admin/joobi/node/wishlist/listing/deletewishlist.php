<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'listing.butdelete' );
class Wishlist_Deletewishlist_listing extends WListing_butdelete {
	function create() {



		$core = $this->getValue( 'core' );

		if ( !empty($core) ) return false;



		return parent::create();



	}}