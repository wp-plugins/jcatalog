<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreAssignprod_listing extends WListings_default{
function create()  {

	
	$option = WGlobals::getApp();

	if ( !empty($option) ) $option = substr( $option, 4 );



	
	
	switch ( $option ) {

		case 'jsubscription': 

			$text = WText::t('1218029673NSUZ');

			break;

		case 'jmarket': 

		case 'jstore': 

			$text = WText::t('1206961902CIFE');

			break;

		case 'jauction': 

			$text = WText::t('1298357874SMVP');

			break;

		default: 

			$text = WText::t('1233642085PNTA');

			break;

			

	}
	

	$display = $text .' (<span style="color:red;">'. $this->value .'</span>)';

	

	
	$this->content = '<b>'. ( ($this->value > 0 ) ? $display : $display  ) .'</b>';

	return true;

	

}}