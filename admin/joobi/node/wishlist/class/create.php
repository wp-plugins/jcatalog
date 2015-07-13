<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');













class Wishlist_Create_class extends WClasses {







	function newList($uid,$nbType) {

		$userName = WUser::get( 'name', $uid );
		$wishlistTypeT = WType::get( 'wishlist.type' );
		$textType = $wishlistTypeT->getName( $nbType );
		$wishlistM = WModel::get( 'wishlist' );
		$wishlistM->type = $nbType;
		$wishlistM->core = 1;			$wishlistM->publish = 1;
		$wishlistM->authoruid = $uid;
		$wishlistM->namekey = strtolower( str_replace( array(' ', '-'), '_', $textType ) ) . $nbType . '-'. $uid . WUser::get( 'username', $uid );

		$wishlistTypeP = WView::picklist( 'wishlist_type' );
		$wishlistM->alias = $wishlistTypeP->getName( $nbType ) .' ' . WText::t('1369750845LDED') . ' ' . $userName;
		$wishlistM->rolid = WRole::getRole( 'registered' );

				if ( $nbType==30 ) {
			$wishlistM->private = 0;
		} else {
			$wishlistM->private = 1;
		}
				$wishlistM->setChild( 'wishlisttrans', 'name', $wishlistM->alias );
		$wishlistM->returnId();
		$wishlistM->save();


		return $wishlistM->wlid;

	}
}