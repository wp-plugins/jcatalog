<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_Parentcategory_picklist extends WPicklist {





	function create() {

		$eid = WGlobals::getEID();

				if ( $eid == 1 ) return false;

		$prodtypid = WGlobals::get( 'prodtypid', 0 );

				if ( !empty($eid) ) {
			$itemCategoryM = WModel::get( 'item.category' );
			$itemCategoryM->whereE( 'catid', $eid );
			$catidDefault = $itemCategoryM->load( 'lr', 'parent' );
		} else {
			$catidDefault = 0;
		}

				$itemCategoryM = WModel::get( 'item.category' );
		$itemCategoryM->whereE( 'parent', $eid );
		$allParentCATIDA = $itemCategoryM->load( 'lra', 'catid' );

				$this->setDefault( $catidDefault, false );

		$productCategoryM = WModel::get( 'item.category' );
		$productCategoryM->makeLJ( 'item.categorytrans', 'catid' );
		$productCategoryM->whereLanguage(1);
		$productCategoryM->select( 'name', 1 );
		$productCategoryM->select( array( 'catid', 'parent', 'namekey', 'publish', 'alias' ) );
				if ( !empty($allParentCATIDA) ) $productCategoryM->whereIn( 'catid', $allParentCATIDA, 0, true );

				$controller = WGlobals::get( 'controller' );
		$prodTypeT = WType::get( 'item.designation' );
		$allTernativeA = $prodTypeT->allNames();
		$thereIsAlternative = in_array( $controller, $allTernativeA ) ? true : false;

		if ( !empty($prodtypid) || $thereIsAlternative ) {
			$productCategoryM->openBracket();
			if ( $thereIsAlternative ) {
				$productTypeM = WModel::get( 'item.type' );

				$typeValue = $prodTypeT->getValue( $controller, false );
				$productTypeM->whereE( 'type', $typeValue );
				$productTypeM->whereE( 'publish', 1 );
				$auctionTypesA = $productTypeM->load('lra', 'prodtypid' );
				if ( !empty($auctionTypesA) ) $productCategoryM->whereIn( 'prodtypid', $auctionTypesA );
			} else {
				$productCategoryM->whereE( 'prodtypid', $prodtypid );
			}			$productCategoryM->operator( 'OR' );
			$productCategoryM->where( 'prodtypid', '=', '0' );
			$productCategoryM->closeBracket();
		}


		
								WPref::load( 'PITEM_NODE_ALLOWVENDORCAT' );


				if ( WRoles::isNotAdmin( 'storemanager' ) ) {

			if ( PITEM_NODE_ALLOWVENDORCAT && PITEM_NODE_ALLOWPRODALLCAT != 1 ) {

				$uid = WUser::get('uid');
				$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
				$vendid = $vendorHelperC->getVendorID( $uid );
				$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
				$StoreManagerVendid = $vendorHelperC->getVendorID( 0, true );

		 		if ( empty( $vendid ) ) {
						$vendid = $StoreManagerVendid;
				}
								if ( PITEM_NODE_ALLOWPRODALLCAT == 3 ) {
					$productCategoryM->openBracket();
					$productCategoryM->whereE( 'vendid', $StoreManagerVendid );
					$productCategoryM->operator( 'OR' );
					$productCategoryM->whereE( 'vendid', $vendid );
					$productCategoryM->closeBracket();
				} else {						$productCategoryM->whereE( 'vendid', $StoreManagerVendid );
				}
			}
		}
		if ( WRoles::isNotAdmin( 'storemanager' ) ) {
			$productCategoryM->whereE( 'publish', 1 );
			$productCategoryM->checkAccess();
		}

		if ( !empty($catidDefault) ) {
			$productCategoryM->openBracket();
			$productCategoryM->whereE( 'catid', $catidDefault );
			$productCategoryM->operator( 'OR' );
		}
		if ( !empty($eid) ) $productCategoryM->where( 'catid', '!=', $eid ); 		if ( !empty($catidDefault) ) $productCategoryM->closeBracket();


		$productCategoryM->orderBy( 'ordering', 'ASC' );
		$productCategoryM->orderBy( 'name', 'ASC', 1 );
		$maxCount = 10000;
		$productCategoryM->setLimit( $maxCount );
		$allCategoriesA = $productCategoryM->load( 'ol' );
				if ( empty($allCategoriesA) ) return false;
				if ( empty($allCategoriesA) ) return false;

		if ( count($allCategoriesA) > ( $maxCount * 0.95 ) ) {
			$this->adminE( 'You are getting close to the maximum number of categories, please inform the development team to increase the number of categories' );
		}
		$parent = array();
		$parent['pkey'] = 'catid';
		$parent['parent'] = 'parent';
		$parent['name'] = 'name';
		$childOrderParent = array();
		$list = WOrderingTools::getOrderedList( $parent, $allCategoriesA, 1, false, $childOrderParent );

		if ( empty($list) ) return false;


		$this->addElement( 0, WText::t('1359160980BTYI') );
		foreach( $list as $itemList ) {
			if ( $itemList->publish != 1 ) $extra = ' ( '.WText::t('1206732372QTKO').' )';
			else $extra = '';
			$this->addElement( $itemList->catid, $itemList->name . $extra );
		}
		return true;

	}





   private function _traceVendor() {

   	if ( WRoles::isAdmin( 'storemanager' ) ) return 0;
   	else {
   		$uid = WUser::get('uid');

   		static $vendidA = null;
   		if ( !isset( $vendidA[ $uid ] ) && !empty( $uid ) ) {
			$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
			$vendidA[ $uid ] = $vendorHelperC->getVendorID( $uid );
		}
		return isset( $vendidA[ $uid ] ) ? $vendidA[ $uid ] : 0;
   	}
   }
}