<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_cancel_controller extends WController {
function cancel() {



	$eid = WGlobals::getEID();



	$itemItemC = WClass::get( 'item.item' );

	$designation = $itemItemC->getDesignation( $eid );



	if ( empty($designation) ) $designation = 'catalog&task=listing';

	WPages::redirect( 'controller=' . $designation );





	return true;



}}