<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Item_Syndicate_class extends WClasses {




	public function syndicateToItem($pid,$vendid,$catid) {

		if ( empty($pid) || empty($vendid) ) return false;


		if ( empty($catid) ) {
						$vendorsHelperC = WClass::get( 'vendors.helper' );
			$catid = $vendorsHelperC->getVendorCategoryID( $uid );
		}
				if ( !empty($catid) ) {
			$itemCAtegoryItemM = WModel::get( 'item.categoryitem' );

				$itemCAtegoryItemM->setVal( 'pid', $pid );
				$itemCAtegoryItemM->setVal( 'catid', $catid );
				$status = $itemCAtegoryItemM->insertIgnore();

		}

		
				$ownerVendid = WModel::getElementData( 'item', $pid, 'vendid' );


		$itemSyndicateM = WModel::get( 'item.syndication' );
		$itemSyndicateM->setVal( 'pid', $pid );
		$itemSyndicateM->setVal( 'vendid', $vendid );
		$itemSyndicateM->setVal( 'ownervendid', $ownerVendid );
		$itemSyndicateM->setVal( 'modifiedby', WUser::get( 'uid' ) );
		$itemSyndicateM->setVal( 'modified', time() );
		$itemSyndicateM->insertIgnore();

		$this->userS('1314356542OZIA');

	}

}