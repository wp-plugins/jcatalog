<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Files_Filtervendid_filter {
function create() {



	if ( WRoles::isAdmin( 'storemanager' ) ) return false;

	else {

		$uid = WUser::get('uid');



		static $vendidA = null;

		
		if ( !isset( $vendidA[ $uid ] ) && !empty( $uid ) ) {

			$vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );
			if ( !empty($vendorHelperC) ) $vendid = $vendorHelperC->getVendorID( $uid );
			else $vendid = 1;


			$vendidA[ $uid ] = $vendid;

		}


 		if ( empty( $vendidA[ $uid ] ) || empty( $uid  ) ) {

			return '0';

		} else return $vendidA[ $uid ];

	}


}}