<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreAssigns_listing extends WListings_default{

function create() {

	


	$pid = $this->value;

	$catid = WGlobals::get('catid');

	$productPID = $this->getValue( 'pid', 'item' );



	$prodtypid = WGlobals::get( 'prodtypid' );

	$titleheader = WGlobals::get( 'titleheader' );



	if ( !empty($pid) ) {
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


	$link = 'controller=item-assign&task=assigncategories&catid='. $catid .'&prodtypid='. $prodtypid;

	$link .= '&pid='. $productPID .'&titleheader='. $titleheader;

	$this->content = '<a href="'. WPage::routeURL( $link ) .'">'. $display .'</a>';



	return true;


}
}