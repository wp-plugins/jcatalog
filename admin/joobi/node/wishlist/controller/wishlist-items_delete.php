<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Wishlist_items_delete_controller extends WController {
function delete() {

	




	

	$pid = WGlobals::get( 'pid', 0, null, 'int' );

	$catid = WGlobals::get( 'catid', 0, null, 'int' );

	$vendid = WGlobals::get( 'vendid', 0, null, 'int' );

	$wlid = WGlobals::get( 'wlid', 0, null, 'int' );



	if ( ( empty($pid) || empty($catid) || empty($vendid) ) && empty($wlid) ) return true;

	
	
	

	$wishlistProductsM = WModel::get('wishlist.items');


	if ( !empty($pid) ) $wishlistProductsM->whereE( 'pid', $pid );

	if ( !empty($catid) ) $wishlistProductsM->whereE( 'catid', $catid );

	if ( !empty($vendid) ) $wishlistProductsM->whereE( 'vendid', $vendid );

	$wishlistProductsM->whereE( 'wlid', $wlid );

	$wishlistProductsM->delete();



return true;



}}