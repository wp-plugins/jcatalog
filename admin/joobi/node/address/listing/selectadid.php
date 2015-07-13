<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_CoreSelectadid_listing extends WListings_default{
function create() {



	$eid = WGlobals::get('pid');

	$vendid= WGlobals::get('vendid');

	$addid = $this->getValue('adid', 'address');

	if ( $this->value ) {


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




	$link = 'controller=address-item&task=selectaddress&pid='. $eid .'&adid='. $addid .'&vendid='. $vendid;

	$this->content = '<a href="'. WPage::routeURL( $link ) .'">'. $display .'</a>';



	return true;



}}