<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_inbox_redirectsender_controller extends WController {


function redirectsender() {

	$uid = WGlobals::get( 'eid' );



	$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

	$vendid = $vendorHelperC->getVendorID( $uid );

	

	if ( empty($vendid ) ) WPages::redirect( 'controller=users&task=show&eid='. $uid , true );

	else WPages::redirect( 'controller=vendors&task=home&eid='. $vendid, true );

	return true;

}}