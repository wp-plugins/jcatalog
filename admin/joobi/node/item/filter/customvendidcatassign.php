<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Customvendidcatassign_filter {

	function create() {

		$roleC = WRole::get();
		$isStoreManger = WRole::hasRole( 'storemanager' );

		if ( WRoles::isAdmin( 'storemanager' ) ) return false; 
		$uid = WUser::get('uid');
		if ( empty( $uid ) ) {
			$message = WMessage::get();
			$message->exitNow( 'Unauthorized access 132' );
		}
				$allowVendorCat = WPref::load( 'PITEM_NODE_ALLOWVENDORCAT' );
		$allowPorductCat = WPref::load( 'PITEM_NODE_ALLOWPRODALLCAT' );

				if ( !$allowVendorCat || $allowPorductCat == 1 ) {
			return false;
		} else {

						if ( $allowPorductCat == 3 ) {

				$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
				$StoreManagerVendid = $vendorHelperC->getVendorID( 0, true );

				$vendorHelperC = WClass::get( 'vendor.helper' );
				$vendid = $vendorHelperC->getVendorID( $uid );

		 		if ( empty( $vendid ) ) {
					$message = WMessage::get();
					$message->exitNow( 'Unauthorized access 153' );
				} else return array( $vendid, $StoreManagerVendid );


			} else {


				
								$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
				$vendid = $vendorHelperC->getVendorID( 0, true );
				return array( $vendid );

			}
		}
	}
}