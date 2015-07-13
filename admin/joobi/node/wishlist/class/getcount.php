<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class Wishlist_Getcount_class extends WClasses {










	public function countItemTypes($itemID,$typeOfElement='item') {
				if ( empty( $itemID ) ) return false;

		if ( !isset($allTypes) ) {
			static $allTypes = null;
			static $itemTypeA = array( 'Favorite' => 20, 'Watch' => 10, 'Wish' => 30, 'Like' => 40, 'Dislike' => 45 );
			static $categoryTypeA = array( 'Favorite' => 120, 'Watch' => 110, 'Like' => 140, 'Dislike' => 145 );
			static $vendorTypeA = array( 'Favorite' => 220, 'Watch' => 210, 'Like' => 240, 'Dislike' => 245 );
			$allTypes = new stdClass;
			$allTypes->item = $itemTypeA;
			$allTypes->category = $categoryTypeA;
			$allTypes->vendor = $vendorTypeA;

		}
		$resultTypeA = array();

				if ( empty( $wishlistM ) ) $wishlistM = WModel::get( 'wishlist.items' );
		$wishlistM->makeLJ( 'wishlist', 'wlid'  );
		$wishlistM->select( 'wlid', 0, 'total', 'count' );
			$wishlistM->select( 'type', 1 );
		switch ( $typeOfElement ) {
			case 'category':					$wishlistM->whereE( 'catid', $itemID );
				break;
			case 'vendor':					$wishlistM->whereE( 'vendid', $itemID );
				break;
			default:				case 'item':
				$wishlistM->whereE( 'pid', $itemID );
				break;
		}


			$wishlistM->whereIn( 'type', $allTypes->$typeOfElement, 1 );
		$wishlistM->whereE( 'publish', 1 );
		$wishlistM->groupBy( 'type', 1 );
		$resultTypeA = $wishlistM->load( 'ol' );
		
		$countA = array();
		if ( !empty($resultTypeA) ) {
			foreach( $resultTypeA as $resultCount ) {
				$countA[$resultCount->type] = ( !empty($resultCount->total) ? $resultCount->total : 0 );
			}		}
		$typeA = array();
		foreach( $allTypes->$typeOfElement as $key => $type ) {
			$name = 'count' . $key;
			$value = ( !empty( $countA[$type] ) ) ? $countA[$type] : 0;
						$typeA[ $name ] = $value;

		}
		return $typeA;

	}
}