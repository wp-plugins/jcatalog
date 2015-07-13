<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_assign_order_controller extends WController {




function order() {

	

	parent::order();

	

	$titleheader = WGlobals::get( 'titleheader' );

	$catid = WGlobals::get( 'catid' );



	WPages::redirect( 'controller=item-assign&catid='. $catid .'&titleheader='. $titleheader );



	return true;

}}