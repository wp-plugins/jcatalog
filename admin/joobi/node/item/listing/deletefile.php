<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreDeletefile_listing extends WListings_default{
function create() {

	$pid= WGlobals::get('pid');

	$map= WGlobals::get('map');

	if (empty($map)) $map = 'filid';


	$iconO = WPage::newBluePrint( 'icon' );
	$iconO->icon = 'delete';
	$iconO->text = WText::t('1206732372QTKL');
	$display = WPage::renderBluePrint( 'icon', $iconO );



	$link =  WPage::linkPopUp( 'controller=files-attach&task=delete&pid='.$pid.'&eid='. $this->value.'&map='. $map ) ;

	$text = WText::t('1318336000EBWT');

	$this->content = '<a style="cursor: pointer;" onclick=" var yes = confirm(\''.$text.'\'); if (yes) { window.location=\''.$link.'\';}">'. $display .'</a>';


	return true;


}
}