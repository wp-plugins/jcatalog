<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Wishlist_my_back_controller extends WController {
function back() {



	$lastPage = WGlobals::getSession( 'pageLocation', 'lastPage', 'controller=catalog' );

	$lastPageItem = WGlobals::getSession( 'pageLocation', 'lastPageItem', true );

	WPages::redirect( $lastPage, $lastPageItem );



	return true;



}}