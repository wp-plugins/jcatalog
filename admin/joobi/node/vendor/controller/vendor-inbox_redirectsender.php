<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Vendor_inbox_redirectsender_controller extends WController {


function redirectsender() {

	$uid = WGlobals::get( 'eid' );



	$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

	$vendid = $vendorHelperC->getVendorID( $uid );

	

	if ( empty($vendid ) ) WPages::redirect( 'controller=users&task=show&eid='. $uid , true );

	else WPages::redirect( 'controller=vendors&task=home&eid='. $vendid, true );

	return true;

}}