<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Wishlist_items_listing_controller extends WController {
function listing() {

$type=WGlobals::get('type');

switch ($type) {

	case '110':

	case '120':

		$this->setView('wishlist_category_listing_wishlist_items');

	break;

	default:

		$this->setView('wishlist_products_listing_wishlist_items');

	break;

}


return true;

}}