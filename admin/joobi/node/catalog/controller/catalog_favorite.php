<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WLoadFile( 'wishlist.controller.wishlist-my-items_add' );
class Catalog_favorite_controller extends Wishlist_my_items_add_controller {

		function favorite() {

	return parent::add();
}}