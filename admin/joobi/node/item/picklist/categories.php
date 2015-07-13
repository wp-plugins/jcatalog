<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_Categories_picklist extends WPicklist {

	function create() {



		$prodtypid = WGlobals::get( 'prodtypid', 0 );

		$controller = WGlobals::get( 'controller' );



		$productCategoryM = WModel::get( 'item.category' );


		$productCategoryM->makeLJ( 'item.categorytrans', 'catid' );

		$productCategoryM->whereLanguage(1);

		$productCategoryM->select( 'name', 1 );

		$productCategoryM->select( array( 'catid', 'parent', 'namekey' ) );



		$allTernativeA = array( 'auction', 'subscription' );

		$thereIsAlternative = in_array( $controller, $allTernativeA ) ? true : false;


		if ( !empty($prodtypid) || $thereIsAlternative ) {


			$productCategoryM->openBracket();

			if ( $thereIsAlternative ) {

				$productTypeM = WModel::get( 'item.type' );

				$prodTypeT = WType::get( 'item.designation' );

				$typeValue = $prodTypeT->getValue( $controller, false );

				$productTypeM->whereE( 'type', $typeValue );

				$auctionTypesA = $productTypeM->load('lra', 'prodtypid' );

				if ( !empty($auctionTypesA) ) $productCategoryM->whereIn( 'prodtypid', $auctionTypesA );

			} else {

				$productCategoryM->whereE( 'prodtypid', $prodtypid );

			}
			$productCategoryM->operator( 'OR' );

			$productCategoryM->where( 'prodtypid', '=', '0' );

			$productCategoryM->closeBracket();



		}


		$productCategoryM->where( 'namekey', '!=', 'root' );

		$productCategoryM->whereE( 'publish', 1 );

		$productCategoryM->checkAccess();
		$productCategoryM->orderBy( 'name', 'ASC', 1 );

		$productCategoryM->setLimit( 1000 );

		$allCategoriesA = $productCategoryM->load( 'ol' );



		
		if ( count($allCategoriesA) == 1000 ) return false;



		$parent = array();

		$parent['pkey'] = 'catid';

		$parent['parent'] = 'parent';

		$parent['name'] = 'name';

		$childOrderParent = array();

		$list = WOrderingTools::getOrderedList( $parent, $allCategoriesA, 1, false, $childOrderParent );



		if ( empty($list) ) return false;



		$this->addElement( 0, WText::t('1309242746DBFE') );

		foreach( $list as $itemList ) {

			$this->addElement( $itemList->catid, $itemList->name );

		}


		return true;



	}
}