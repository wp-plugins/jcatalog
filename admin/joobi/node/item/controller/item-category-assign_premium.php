<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_category_assign_premium_controller extends WController {
function premium() {



	
	$pid = WGlobals::get('pid');

	$catid = WGlobals::get('catid');


	$prodtypid = WGlobals::get( 'prodtypid' );

	$titleheader = WGlobals::get( 'titleheader' );



	$productCAtegoryproductM = WModel::get('item.categoryitem');

	$productCAtegoryproductM->whereE( 'pid', $pid );

	$productCAtegoryproductM->setVal( 'premium', '0' );

	$productCAtegoryproductM->update();

	

	$productCAtegoryproductM->whereE( 'pid', $pid );

	$productCAtegoryproductM->whereE( 'catid', $catid );

	$productCAtegoryproductM->setVal( 'premium', 1 );

	$productCAtegoryproductM->update();	



	WPages::redirect( 'controller=item-category-assign&task=listing&pid='. $pid .'&prodtypid='. $prodtypid .'&titleheader='. $titleheader );

	return true;

}}