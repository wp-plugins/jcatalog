<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreProdlistvendownershow_form extends WForms_default {
function show() {

	$storeName = $this->getValue( 'name', 'vendor' );

	if ( !empty( $storeName ) ) $display = $storeName;

	else {

		$vendUID = $this->getValue( 'uid', 'vendor' );

		$display = WUser::get( 'name', $vendUID );

	}


	$vendid = $this->getValue( 'vendid' );

	$link = 'controller=vendors&task=home&eid='. $vendid ;

	$this->content = WPage::createPopUpLink( WPage::linkPopUp( $link, null, 'popup' ), $display, 800, 600 );


	return true;

}}