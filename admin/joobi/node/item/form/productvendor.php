<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreProductvendor_form extends WForms_default {


function show() {





	if ( WExtension::exist( 'vendors.node' ) ) {

		$vendid = $this->getValue( 'vendid' );



		$uid = $this->getValue( 'uid' );

		
		$link = 'controller=vendors&task=home&eid='. $this->value;

		$itemid = WGlobals::get( JOOBI_PAGEID_NAME );

		if ( !empty($itemid) ) $link .= '&' . JOOBI_PAGEID_NAME . '='. $itemid;

		$vendlink = WPage::routeURL( $link, null, true, true, false );





		
		static $vendorHelperC = null;

		if ( empty($vendorHelperC) ) $vendorHelperC = WClass::get('vendor.helper',null,'class',false);

		if ( $vendorHelperC ) $vendor = $vendorHelperC->showVendName( $vendid, $uid, $vendlink );



		$this->content = $vendor;





		return true;



	} else return false;



}}