<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Item_Translation_class extends WClasses {







	public function secureTranslation($itemO,$sid,$eid) {

		$uid = WUser::get( 'uid' );
		if ( empty($uid) ) return false;

						$roleHelper = WRole::get();
		if ( WRole::hasRole( 'storemanager' ) ) return true;

		if ( !WRole::hasRole( 'vendor' ) ) return false;

				$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
		$vendid = $vendorHelperC->getVendorID( $uid );
		if ( empty($vendid) ) return false;

				$modelName = WModel::get( $sid, 'namekey' );

		if ( $modelName == 'item.categorytrans' ) {
						$itemCategoryM = WModel::get( 'item.category' );
			$itemCategoryM->whereE( 'vendid', $vendid );
			$itemCategoryM->whereE( 'catid', $eid );
			if ( $itemCategoryM->exist() ) return true;
		} elseif ( $modelName == 'item.typetrans' || 'product.pricetrans' == $modelName || 'item.termstrans' == $modelName ) {
						return false;
		} else {							$itemM = WModel::get( 'item' );
			$itemM->whereE( 'vendid', $vendid );
			$itemM->whereE( 'pid', $eid );
			if ( $itemM->exist() ) return true;
		}
		return false;

	}

}