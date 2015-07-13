<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Item_Access_class extends WClasses {






	public function haveAccess($rolid) {
		static $roleC=null;
		static $myAccessA = array();

		if ( !isset($myAccessA[$rolid] ) ) {

			if ( !isset($roleC) ) $roleC = WRole::get();

			if ( empty($rolid) ) $hasRole = true;
			else $hasRole = $roleC->hasRole( $rolid );

			$myAccessA[$rolid] = (bool)$hasRole;

		}
		return $myAccessA[$rolid];

	}






	public function checkItemAccess($pid,$TEXT='') {

		if (empty($pid) ) return false;
		if ( empty($TEXT) ) $TEXT = WText::t('1329161637HNDY');

				if ( WGlobals::checkCandy(50,true) ) return true;

		$itemM = WModel::get('item');
		$itemM->whereE('pid', $pid);
		$myProduct = $itemM->load('o', array('rolid_buy', 'prodtypid') );
		if ( empty($myProduct) ) return false;

		$rolid_buy = ( !empty( $myProduct->rolid_buy ) ) ? $myProduct->rolid_buy : 0;
		$prodtypid = ( !empty($myProduct->prodtypid) ) ? $myProduct->prodtypid : 0;

		if ( empty( $rolid_buy ) || $rolid_buy == 1 ) {
						static $itemTypeC=null;
			if (!isset($itemTypeC) ) $itemTypeC = WClass::get( 'item.type' );
			$rolid_buy = $itemTypeC->loadData( $prodtypid, 'rolid_buy' );
			if ( empty($rolid_buy) || $rolid_buy == 1 ) {
				$rolid_buy = WPref::load( 'PPRODUCT_NODE_ROLID_BUY' );
			}		}
		if ( !empty($rolid_buy) ) {
			$itemAccessC = WClass::get( 'item.access' );
			$hasRole = $itemAccessC->haveAccess( $rolid_buy );
		} else $hasRole = true;

				if ( !$hasRole ) {

			$ROLENAME = WRole::getRole( $rolid_buy, 'name' );
			$this->userW('1329161637HNDZ',array('$ROLENAME'=>$ROLENAME,'$TEXT'=>$TEXT));

			return false;
		}
		return true;

	}
}