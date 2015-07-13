<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WLoadFile( 'main.class.ownership', JOOBI_DS_NODE );
class Wishlist_Ownership_class extends Main_Ownership_class {






	public function isOwner($eid) {

		if ( empty($eid) ) return false;

		$roleHelper = WRole::get();
		$storeManagerRole = WRole::hasRole( 'storemanager' );
		if ( !empty( $storeManagerRole ) ) return true;

		$myEID = ( is_array($eid) ? $eid[0] : $eid );

		if ( !empty($myEID) ) {

			$authoruid = WModel::getElementData( 'wishlist', $myEID, 'authoruid' );

			$uid = WUser::get( 'uid' );
			if ( $authoruid != $uid ) return false;

			return true;

		}
		return false;

	}
}