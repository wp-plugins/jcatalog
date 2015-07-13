<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WLoadFile( 'main.class.ownership', JOOBI_DS_NODE );
class Item_Ownership_class extends Main_Ownership_class {






	public function isOwner($eid) {

		if ( empty($eid) ) return false;

		if ( WRole::hasRole( 'storemanager' ) ) return true;

				$controller = WGlobals::get( 'controller' );

		if ( $controller == 'item-category' ) {
			$model = 'item.category';
			$pkey = 'catid';
		}elseif ( $controller == 'item-terms' ) {
			$model = 'item.terms';
			$pkey = 'termid';

		} else {
			$model = 'item';
			$pkey = 'pid';
		}
		$vendorHelperC = WClass::get( 'vendor.helper' );
		$vendid = $vendorHelperC->getVendorID();

		$itemM = WModel::get( $model );


		if ( is_array($eid) ) $itemM->whereIn( $pkey, $eid );
		else $itemM->whereE( $pkey, $eid );
		$itemM->whereE( 'vendid', $vendid );

		$task = WGlobals::get( 'task' );
		$columnExists = false;
		if ( $task == 'copyall' ) {
			$columnExists = $itemM->columnExists( 'share' );
		}
		if ( $columnExists ) {
			$itemM->openBracket();
			$itemM->whereE( 'vendid', $vendid );
			$itemM->operator( 'OR' );
			$itemM->whereE( 'share', 1 );
			$itemM->closeBracket();
		} else {
			$itemM->whereE( 'vendid', $vendid );
		}
		return $itemM->exist();

	}
}