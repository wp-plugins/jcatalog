<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WLoadFile( 'main.class.ownership', JOOBI_DS_NODE );
class Users_Ownership_class extends Main_Ownership_class {






	public function isOwner($eid){

		if( is_array($eid)) $eid=$eid[0];

		if( empty($eid)) return false;

		$currentLoggedUID=WUser::get( 'uid' );
		if( $eid==$currentLoggedUID ) return true;

				if( WRole::hasRole( 'sadmin' )) return true;

				if( WRole::hasRole( 'admin' )){

						if( WRole::hasRole( 'sadmin', $eid )) return false;
		}
		return false;

	}
}