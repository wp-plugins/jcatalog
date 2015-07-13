<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_inbox_listing_controller extends WController {




function listing() {

	$vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );



	if ( WRoles::isAdmin( 'storemanager' ) )

	{

		$vendid = 1;



		$vendorObj = ( !empty( $vendorHelperC ) ) ? $vendorHelperC->getVendor( $vendid ) : null;

		$uid = ( isset($vendorObj->uid) ) ? $vendorObj->uid : WUser::get( 'uid' );

	}

	else

	{

		$uid = WUser::get( 'uid' );

		$vendid = WGlobals::get( 'id' );

		if ( empty($vendid) )

		{

			$vendid = ( !empty($vendorHelperC) ) ? $vendorHelperC->getVendorID( $uid ) : 0;

		}
	}


	WGlobals::set( 'id', $vendid );

	WGlobals::set( 'uid', $uid );





	return true;

} }