<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Vendor_inbox_cancelmessage_controller extends WController {




function cancelmessage() {

	$trucs = WGlobals::get( 'trucs' );

	$vendid = ( isset($trucs['x']['id']) ) ? $trucs['x']['id'] : 0;

	

	parent::cancel();

	

	$link = ( !empty($vendid)) ? 'controller=vendor-inbox&task=listing&id='. $vendid : 'controller=vendor-inbox&task=listing';

	WPages::redirect( $link, true );

	return true;

}}