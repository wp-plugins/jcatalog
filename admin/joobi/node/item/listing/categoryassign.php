<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreCategoryassign_listing extends WListings_default{
function create() {

	


	$catid = $this->value;

	$catidOrigin = $this->getValue( 'catid', 'item.category' );


	$pid = WGlobals::get('pid');

	$prodtypid = WGlobals::get( 'prodtypid' );

	$titleheader = WGlobals::get( 'titleheader' );



	if ( !empty($catid) ) {

		$iconO = WPage::newBluePrint( 'icon' );

		$iconO->icon = 'yes';

		$iconO->text = WText::t('1206732372QTKI');

		$display = WPage::renderBluePrint( 'icon', $iconO );

	} else {

		$iconO = WPage::newBluePrint( 'icon' );

		$iconO->icon = 'cancel';

		$iconO->text = WText::t('1206732372QTKJ');

		$display = WPage::renderBluePrint( 'icon', $iconO );

	}



	$link = 'controller=item-category-assign&task=assignproducts&pid='. $pid .'&prodtypid='. $prodtypid;

	$link .= '&catid='. $catidOrigin .'&titleheader='. $titleheader;

	$this->content = '<a href="'. WPage::routeURL( $link ) .'">'. $display .'</a>';


	return true;


}
}