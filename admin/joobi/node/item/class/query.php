<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Query_class extends WClasses {

	private $_alltypesA = array();






	public function count($edit=false,$type='') {

		$this->getAllTypes( $edit, $type );

		if ( empty($type) ) {
			return count( $this->_alltypesA );
		} else {

			if ( !empty( $this->_alltypesA ) ) {
				$itemDesignationT = WType::get( 'item.designation' );
				$getTypeID = $itemDesignationT->getValue( $type );
				if ( empty( $getTypeID ) ) {
					return count( $this->_alltypesA );
				} else {
					$count = 0;
					foreach( $this->_alltypesA as $oneT ) {
						if ( $oneT->type == $getTypeID ) $count++;
					}					return $count;
				}
			} else {
				return 0;
			}
			return count( $this->_alltypesA );
		}
	}





	public function getPublishedType() {

		$type = $this->_alltypesA[0]->type;

		$itemTypeT = WType::get( 'item.designation' );
		$designationName = $itemTypeT->getName( $type );
		return strtolower( $designationName );

	}






	public function getAllTypes($edit=false,$type='') {
		static $vendorHelperC = null;
		static $itemTypesA = array();

		if ( !empty( $type ) ) {
			$itemDesignationT = WType::get( 'item.designation' );
			$getTypeID = $itemDesignationT->getValue( $type );
		}

		if ( !isset( $vendorHelperC ) ) $vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );
		$vendid = ( $vendorHelperC ) ? $vendorHelperC->traceVendor() : 0;

		static $itemTypeM = null;
		if ( empty( $itemTypeM ) ) $itemTypeM = WModel::get( 'item.type' );
		$itemTypeM->makeLJ( 'item.typetrans', 'prodtypid' );
		$itemTypeM->select( 'name', 1 );

		if ( $edit ) {
			$itemTypeM->checkAccess( 0, 0, 0, 0, 'rolid_edit' );
		}		if ( !isset( $itemTypesA[$type] ) ) {

			$itemTypeM->makeLJ( 'item.typetrans', 'prodtypid' );
			$itemTypeM->whereLanguage( 1 );
			$itemTypeM->whereE( 'publish', 1 );

			if ( WRoles::isNotAdmin() ) {
				if ( !empty( $vendid ) ) {
					$itemTypeM->whereE( 'vendid', 0, 0, null, 1 );
					$itemTypeM->whereE( 'vendid', $vendid, 0, null, 0, 1, 1 );
				} else $itemTypeM->whereE( 'vendid', 0 );
			} else {
				if ( ! WRole::hasRole( 'vendor' ) ) {
					$message = WMessage::get();
					$message->exitNow( 'Unauthorized access 332' );

				} else {
					if ( !empty( $vendid ) ) {
						$itemTypeM->whereE( 'vendid', 0, 0, null, 1 );
						$itemTypeM->whereE( 'vendid', $vendid, 0, null, 0, 1, 1 );
					} else $itemTypeM->whereE( 'vendid', 0 );
				}			}
			$itemTypeM->checkAccess();

			if ( !empty( $getTypeID ) ) {
				$itemTypeM->whereE( 'type', $getTypeID );
			}
			$itemTypeM->orderBy( 'type' );
			$itemTypeM->setLimit( 500 );
			$itemTypesA[$type] = $itemTypeM->load( 'ol', array( 'prodtypid', 'namekey', 'type' ) );
		}
		$this->_alltypesA = $itemTypesA[$type];
		return $itemTypesA[$type];

	}
}