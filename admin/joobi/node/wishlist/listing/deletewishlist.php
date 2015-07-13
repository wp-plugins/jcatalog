<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'listing.butdelete' );
class Wishlist_Deletewishlist_listing extends WListing_butdelete {
	function create() {



		$core = $this->getValue( 'core' );

		if ( !empty($core) ) return false;



		return parent::create();



	}}