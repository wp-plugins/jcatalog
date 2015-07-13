<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Item_Restriction_class extends WClasses {












 function filterRestriction($place='listing',$modelName='item',$columnName=null,$whereValue=null) {


	if ( WRoles::isNotAdmin( 'storemanager' ) ) {
		static $vendidA = null;
 		$uid = WUser::get('uid');
		if ( empty($uid) ) {
			$message = WMessage::get();
			$message->exitNow( 'Unauthorized access 101' );
		}

 				 		static $userRoleA = array();
 		if ( !isset( $userRoleA[ $uid ] ) ) {
 			$roleC = WRole::get();
			$userRoleA[ $uid ] = WRole::hasRole( 'storemanager' );
 		}
 		 		if ( $userRoleA[ $uid ] ) return true;


	 			if ( !isset( $vendidA[ $uid ] ) ) {
			$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
			$vendidA[ $uid ] = $vendorHelperC->getVendorID( $uid );
		}
		switch ( $place ) {
			case 'listing' :
					if ( !empty( $vendidA[ $uid ] ) ) return true;
					else return false;
					break;
			case 'eid' :
					$eid = WGlobals::getEID();
					if ( !empty( $vendidA[ $uid ] ) && ( empty($eid) || $eid == $vendidA[ $uid ] ) ) {
						WGlobals::setEID( $vendidA[ $uid ] );
						return true;
					} else return false;
					break;
			case 'edit' :

					if ( empty( $vendidA[ $uid ] ) ) return false;
					else {
						$eid = WGlobals::getEID();

						if ( empty( $eid ) ) return true;
						else {
							if ( empty( $modelName ) || empty( $columnName ) ) return true;
							else {
								$productM = WModel::get( $modelName );
								$productM->whereE( 'vendid', $vendidA[ $uid ] );
								$productM->whereE( $columnName, $eid );
								$prodCheck = $productM->load( 'lr', $columnName );

								if ( !empty( $prodCheck ) ) return true;
								else return false;
							}						}					}
					break;
			case 'query' :
					if ( empty( $vendidA[ $uid ] ) ) return false;
					else {
						if ( empty( $modelName ) || empty( $columnName ) || empty( $whereValue ) ) return true;
						else {
							$productM = WModel::get( $modelName );
							$productM->whereE( 'vendid', $vendidA[ $uid ] );
							$productM->whereE( $columnName, $whereValue );
							$prodCheck = $productM->load( 'lr', $columnName );

							if ( !empty( $prodCheck ) ) return true;
							else return false;
						}					}					break;
			default : break;
		}

	} else return true;

 	return true;
 }
}