<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreNewitem_listing extends WListings_default{
function create()  {

	static $itemTypeC = null;



	
	$prodtypid = $this->getValue( 'prodtypid' );



	if ( empty( $prodtypid ) || WPref::load( 'PITEM_NODE_CATMULTIPLETYPE' )  ) {

		$this->content = WText::t('1327698302NOMA');

		return true;

	}




	if (empty($itemTypeC) ) $itemTypeC = WClass::get( 'item.type' );


	$ITEM_TYPE_NAME =  $itemTypeC->loadData( $prodtypid, 'name' );

	$this->content = str_replace(array('$ITEM_TYPE_NAME'), array($ITEM_TYPE_NAME),WText::t('1359160979NZWA'));



	$designation = $itemTypeC->loadData( $prodtypid, 'designation' );

	$this->element->lien = 'controller='.$designation.'&task=new(categoryid=catid)(prodtypid=prodtypid)';



	return true;



	
	$option = WGlobals::get( 'option' );

	if ( !empty($option) ) $option = substr( $option, 4 );





	
	
	switch ( $designation ) {

		case 'jsubscription':

			$text = WText::t('1327698302NOLY');

			break;

		case 'jmarket':

		case 'jstore':

			$text = WText::t('1327698302NOLZ');

			break;

		case 'jauction':

		default:

			$text = WText::t('1327698302NOMA');

			break;

	}




	$display = $text; 


	

	$this->content = $display;

	return true;



}}