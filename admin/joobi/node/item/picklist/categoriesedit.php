<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');





class Item_Categoriesedit_picklist extends WPicklist {
	function create() {



		$pid = WGlobals::getEID();

		$prodtypid = WGlobals::get( 'prodtypid', 0 );





		if ( !empty($pid) ) {

			
			if ( empty($prodtypid) ) {

				$prodtypid = $this->getValue( 'prodtypid' );

			}


			
			$itemCategoryitemM = WModel::get('item.categoryitem');

			$itemCategoryitemM->whereE( 'pid', $pid );

			$itemCategoryitemM->whereE( 'premium', 1 );

			$catidDefault = $itemCategoryitemM->load('lr', 'catid' );



		} else {

			$catidDefault = 0;

		}
		
		$this->setDefault( $catidDefault, false );



		$productCategoryM = WModel::get( 'item.category' );


		$productCategoryM->makeLJ( 'item.categorytrans', 'catid' );

		$productCategoryM->whereLanguage(1);

		$productCategoryM->select( 'name', 1 );

		$productCategoryM->select( array( 'catid', 'parent', 'namekey', 'publish', 'alias' ) );



		
		$controller = WGlobals::get( 'controller' );

		$prodTypeT = WType::get( 'item.designation' );

		$allTernativeA = $prodTypeT->allNames();

		$thereIsAlternative = in_array( $controller, $allTernativeA ) ? true : false;


		
		if ( !empty($prodtypid) || $thereIsAlternative ) {


			$productCategoryM->openBracket();

			$multipelType = WPref::load( 'PITEM_NODE_CATMULTIPLETYPE' );
			$addItemType = false;


			if ( $thereIsAlternative ) {


				$productTypeM = WModel::get( 'item.type' );
				$typeValue = $prodTypeT->getValue( $controller, false );

				$productTypeM->whereE( 'type', $typeValue );

				$productTypeM->whereE( 'publish', 1 );

				$auctionTypesA = $productTypeM->load( 'lra', 'prodtypid' );


				if ( !empty($auctionTypesA) ) {
					if ( $multipelType ) {
						$productCategoryM->makeLJ( 'item.categorytype', 'catid', 'catid', 0, 2 );
						$productCategoryM->whereIn( 'prodtypid', $auctionTypesA, 2 );
					} else {
						$productCategoryM->whereIn( 'prodtypid', $auctionTypesA );
					}				} else {
					$addItemType = true;
				}

			} else {
				$addItemType = true;
			}
			if ( $addItemType ) {
				if ( $multipelType ) {
					$productCategoryM->makeLJ( 'item.categorytype', 'catid', 'catid', 0, 2 );
					$productCategoryM->whereE( 'prodtypid', $prodtypid, 2 );
				} else {
					$productCategoryM->whereE( 'prodtypid', $prodtypid );
				}


			}

			$productCategoryM->operator( 'OR' );


			if ( $multipelType ) $productCategoryM->isNull( 'prodtypid', true, 2 );
			else $productCategoryM->where( 'prodtypid', '=', '0' );



			$productCategoryM->closeBracket();


		}


		$productCategoryM->where( 'namekey', '!=', 'root' );





		



		
		
		
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

			$productCategoryM->checkAccess();
			$productCategoryM->whereE( 'publish', 1 );


		}



		$maxCount = 10000;

		$productCategoryM->orderBy( 'ordering', 'ASC' );

		$productCategoryM->orderBy( 'name', 'ASC', 1 );

		$productCategoryM->setLimit( $maxCount );

		$allCategoriesA = $productCategoryM->load( 'ol' );

		
		if ( empty($allCategoriesA) ) return false;



		if ( count($allCategoriesA) > ( $maxCount * 0.95 ) ) {

			$message = WMessage::get();

			$message->adminE( 'You are getting close to the maximum number of categories, please inform the development team to increase the number of categories' );

		}


		$parent = array();

		$parent['pkey'] = 'catid';

		$parent['parent'] = 'parent';

		$parent['name'] = 'name';

		$childOrderParent = array();

		$list = WOrderingTools::getOrderedList( $parent, $allCategoriesA, 1, false, $childOrderParent );



		if ( empty($list) ) return false;



		$this->addElement( 0, WText::t('1359160980BTYH') );

		foreach( $list as $itemList ) {

			if ( $itemList->publish != 1 ) $extra = ' ( '.WText::t('1206732372QTKO').' )';

			else $extra = '';

			$this->addElement( $itemList->catid, $itemList->name . $extra );

		}


		return true;



	}}