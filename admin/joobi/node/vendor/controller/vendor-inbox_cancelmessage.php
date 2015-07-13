<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_inbox_cancelmessage_controller extends WController {




function cancelmessage() {

	$trucs = WGlobals::get( 'trucs' );

	$vendid = ( isset($trucs['x']['id']) ) ? $trucs['x']['id'] : 0;

	

	parent::cancel();

	

	$link = ( !empty($vendid)) ? 'controller=vendor-inbox&task=listing&id='. $vendid : 'controller=vendor-inbox&task=listing';

	WPages::redirect( $link, true );

	return true;

}}