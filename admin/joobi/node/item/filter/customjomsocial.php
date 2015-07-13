<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Customjomsocial_filter {
function create() {



	if ( WRoles::isAdmin( 'storemanager' ) ) return false;

	else {

		$profileID = WGlobals::get( 'userid' );

		$uid = WUser::get( 'uid', $profileID, false );



		static $vendidA = null;

		
		if ( !isset( $vendidA[ $uid ] ) && !empty( $uid ) ) {

			$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

			$vendidA[ $uid ] = $vendorHelperC->getVendorID( $uid );

		}


 		if ( empty( $vendidA[ $uid ] ) || empty( $uid  ) ) {

			return '0';

		} else return $vendidA[ $uid ];

	}


}}