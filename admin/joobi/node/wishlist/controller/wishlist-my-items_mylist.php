<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Wishlist_my_items_mylist_controller extends WController {
function mylist() {



	WPages::redirect( 'controller=wishlist-my' );

	return true;

}}