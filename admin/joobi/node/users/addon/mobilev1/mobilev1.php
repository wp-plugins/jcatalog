<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WLoadFile( 'users.class.parent', JOOBI_DS_NODE );
class Users_Mobilev1_addon extends Users_Parent_class {







	public function getUser($userId,$loadFrom='uid'){
		static $myMember=array();

		if( empty($userId)) return '';

		$colID=(empty($loadFrom)) ? 'uid' : $loadFrom;
		$key=trim($userId.'-'.$colID);
		$key=(string)$key;

		if( isset($myMember[$key])) return $myMember[$key];

		$userM=WModel::get( 'users', 'object', null, false );
		if( empty($userM)){
			return false;
		}

		$userM->select( '*', 0 );
		$userM->select( 'ip', 0, 'realip', 'ip' );
		if( is_numeric($userId)){
			$userM->whereE( $colID, $userId );
		}else{
			$userM->whereE( 'email', $userId );
			$userM->operator( 'OR' );
			$userM->whereE( 'username', $userId );
		}
				$userM->select( 'id', 0, 'id' );
		$myMember[$key]=$userM->load( 'o' );			if( empty($myMember[$key])) $myMember[$key]=false;

		return $myMember[$key];

	}

}