<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WView::includeElement( 'listing.yesno' );
class Item_CoreSelectedfile_listing extends WListing_yesno {


function create() {



	$pid= WGlobals::get('pid');

	$myid = $this->getValue('filid', 'files');

	$map = WGlobals::get('map');

	$model = WGlobals::get('model');



	$listOfSelectedFilesA = WGlobals::get( 'listOfSelectedFilesA', array(), 'global' );


	$value = 0;

	if ( !empty($listOfSelectedFilesA) ) {

		foreach( $listOfSelectedFilesA as $oneFile ) {


			if ( $oneFile->filid == $myid ) $value = 1;

		}


	}


	if ( $value ) {
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

	$link = 'controller=files-attach&task=selectfile&pid='. $pid .'&filid='. $myid .'&attach='. !$value .'&map='. $map .'&model='. $model;

	$this->content = '<a href="'. WPage::routeURL( $link ) .'">'. $display .'</a>';



	return true;



}
}