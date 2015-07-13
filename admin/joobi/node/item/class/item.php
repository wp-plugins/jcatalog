<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Item_Item_class extends WClasses {






	public function getDesignation($pid) {

		$itemM = WModel::get( 'item' );
		$itemM->makeLJ( 'item.type', 'prodtypid' );
		$itemM->whereE( 'pid',  $pid );
		$itemM->select( 'type', 1 );
		$type = $itemM->load( 'lr' );

		$itemTypeT = WType::get( 'item.designation' );
		$designationName = $itemTypeT->getName( $type );

		return $designationName;
	}






	public function getOwner($pid) {

		$itemO = $this->_loadItemInformation( $pid );

		if ( empty($itemO->vendid) ) return false;

				$vendorHelperC = WClass::get( 'vendor.helper' );
		$uid = $vendorHelperC->getVendor( $itemO->vendid, 'uid' );

		return $uid;

	}






	public function getName($pid) {

		$itemO = $this->_loadItemInformation( $pid );
		return $itemO->name;

	}






	private function _loadItemInformation($pid) {
		static $AllItemA = array();

		if ( isset($AllItemA[$pid]) ) return $AllItemA[$pid];

		$itemM = WModel::get( 'item' );
		$itemM->makeLJ( 'itemtrans', 'pid' );
		$itemM->select( '*', 0 );
		$itemM->select( '*', 1 );
		$itemM->whereE( 'pid',  $pid );
		$AllItemA[$pid] = $itemM->load( 'o' );

		return $AllItemA[$pid];

	}

}