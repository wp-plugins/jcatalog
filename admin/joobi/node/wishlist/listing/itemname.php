<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'listing.text' );
class Wishlist_Itemname_listing extends WListing_text {
function create() {



	if ( empty($this->value) ) {

		$this->value = $this->getValue( 'name', 'itemtrans' );

	}	

	$type = $this->getValue( 'type' );

	

	$tempType = $type % 100;

	$wishListTypeHundreded = $type - $tempType;

	

	

	
	switch ( $wishListTypeHundreded ) {

		case 100:	
			$this->element->lien = 'controller=catalog&task=category&(eid=catid)';

			break;

		case 200:	
			$this->element->lien = 'controller=vendors&task=home&(eid=vendid)';

			break;

		default:	
		case 0:

			$this->element->lien = 'controller=catalog&task=show&(eid=pid)';

			break;

	}
	

	return parent::create();



}}