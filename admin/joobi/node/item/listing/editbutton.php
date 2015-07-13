<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreEditbutton_listing extends WListings_default{
function create() {



	if ( WGlobals::get( 'is_popup', false, 'global' ) ) return false;



	$pid= WGlobals::get('pid');

	$iconO = WPage::newBluePrint( 'icon' );
	$iconO->icon = 'edit';
	$iconO->text = WText::t('1206732361LXFE');
	$display = WPage::renderBluePrint( 'icon', $iconO );


	$link =  WPage::linkPopUp( 'controller=files-attach&task=edit&pid='. $pid .'&eid='. $this->value ) ;



	$this->content = '<a href="'. $link .'"'.$extraLink.'>'. $display .'</a>';

	$this->content = WPage::createPopUpLink( $link, $display, '80%', '60%', '', '', '', WGlobals::get( 'is_popup', false, 'global' ) );



return true;



}}