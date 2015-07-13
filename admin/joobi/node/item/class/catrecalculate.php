<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class Item_Catrecalculate_class extends WClasses {





	function reCalculateAll() {

		

		$query = 'UPDATE `#__productcat_node` AS A SET `numpid` = (
SELECT COUNT( B.`pid` ) FROM `#__productcat_product` AS B
LEFT JOIN `#__product_node` AS C ON B.`pid` = C.`pid`
WHERE B.`catid` = A.`catid`
AND C.`publish` = 1
);';

		$dbHandler = WTable::get();
		$dbHandler->load( 'q', $query );


				if ( WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) {
			
			$itemCategoryM = WModel::get( 'item.category' );
			$itemCategoryM->whereE( 'publish', 1 );
			$allCatA = $itemCategoryM->load( 'ol', array( 'catid', 'lft', 'rgt', 'numpid' ) );

			if ( !empty($allCatA) ) {

				foreach( $allCatA as $oneCat ) {

					if ( ( $oneCat->rgt - $oneCat->lft ) < 2 ) continue;

					$itemCategoryM->whereE( 'publish', 1 );
					$itemCategoryM->where( 'lft', '>', $oneCat->lft );
					$itemCategoryM->where( 'rgt', '<', $oneCat->rgt );
					$itemCategoryM->select( 'numpid', 0, null, 'sum' );
					$count = $itemCategoryM->load( 'lr' );

					$itemCategoryM->whereE( 'catid', $oneCat->catid );
					$itemCategoryM->setVal( 'numpidsub', $count );						$itemCategoryM->update();

				}
			}
		}

		return true;

		

















	}

}