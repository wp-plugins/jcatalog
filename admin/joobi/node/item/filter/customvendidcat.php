<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Customvendidcat_filter {


	function create() {



		
		if ( WRoles::isAdmin( 'storemanager' ) ) return false;

		else {

			$uid = WUser::get('uid');



			
			
			static $userRoleA = array();

	 		if ( !isset( $userRoleA[ $uid ] ) ) {

	 			$roleC = WRole::get();

				$userRoleA[ $uid ] = WRole::hasRole( 'storemanager' );

	 		}








			static $vendidA = null;

			
			if ( !isset( $vendidA[ $uid ] ) && !empty( $uid ) ) {

				$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

				$vendidA[ $uid ] = $vendorHelperC->getVendorID( $uid );

			}


	 		if ( empty( $vendidA[ $uid ] ) || empty( $uid  ) ) {

				$message = WMessage::get();

				$message->exitNow( 'Unauthorized access 131' );

			} else {
				return $vendidA[ $uid ];
			}
		}


	}

}