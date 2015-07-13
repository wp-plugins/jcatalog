<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'listing.butdelete' );
class Wishlist_Deleteitem_listing extends WListing_butdelete {
	function create() {



		$type = $this->getValue( 'type' );

		$tempType = $type % 100;
		$wishListTypeHundreded = $type - $tempType;

				switch ( $wishListTypeHundreded ) {
			case 100:					$this->element->lien = 'controller=wishlist-my-items&task=delete(wlid=wlid)(catid=catid)(eid=wlid)(titleheader=titleheader)';
				break;
			case 200:					$this->element->lien = 'controller=wishlist-my-items&task=delete(wlid=wlid)(vendid=vendid)(eid=wlid)(titleheader=titleheader)';
				break;
			default:				case 0:
				$this->element->lien = 'controller=wishlist-my-items&task=delete(wlid=wlid)(pid=pid)(eid=wlid)(titleheader=titleheader)';
				break;
		}

		return parent::create();

	}}