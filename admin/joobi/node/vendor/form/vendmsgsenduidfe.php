<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WView::includeElement( 'form.select' );
class Vendor_Vendmsgsenduidfe_form extends WForm_select {




function create()

{

	$sentoid = WGlobals::get( 'uid' );

	if ( !empty($sentoid) )	{

		$this->value = $sentoid;

		$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

		$vendid = $vendorHelperC->getVendorID( $sentoid);

		$vendObj = $vendorHelperC->getVendor( $vendid );

		$this->content = '<b style="color:red;">'.$vendObj->name.'</b>';	

	}
	else return parent::create();

	return true;

}}