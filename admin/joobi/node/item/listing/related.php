<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreRelated_listing extends WListings_default{

function create() {



	$relatedID = $this->getValue( 'relpid', 'item.related' );





	
	$eid = WGlobals::get( 'eid' );

	$prodtypid = WGlobals::get( 'prodtypid' );

	$titleheader = WGlobals::get( 'titleheader' );

	$pid = $this->value;



	if ( !empty($relatedID) ) {
		$related = 1; 		$iconO = WPage::newBluePrint( 'icon' );
		$iconO->icon = 'yes';
		$iconO->text = WText::t('1206732372QTKI');
		$display = WPage::renderBluePrint( 'icon', $iconO );
	} else {
		$related = 0; 		$iconO = WPage::newBluePrint( 'icon' );
		$iconO->icon = 'cancel';
		$iconO->text = WText::t('1206732372QTKJ');
		$display = WPage::renderBluePrint( 'icon', $iconO );
	}

	$link = WPage::routeURL( 'controller=item-related&task=add&relpid='. $pid .'&rel='. $related .'&eid='. $eid .'&prodtypid='. $prodtypid .'&titleheader='. $titleheader );



 	$this->content = '<a href="'. $link .'">'.$display.'</a>';

	return true;

}}