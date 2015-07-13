<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Api_Joomla16_Role_addon {






	public function getRoleName($roleID){
		static $roleA=array();

		if( !isset( $roleA[$roleID] )){
			$sql=WTable::get( '#__usergroups','','id' );
			$sql->whereE( 'id', $roleID );
			$roleA[$roleID]=$sql->load( 'lr', 'title' );
		}
		return $roleA[$roleID];

	}
	public function getColumnName(){

		return 'j16';

	}






	public function getRoles(){

		$db=JFactory::getDBO();

				$db->setQuery(
			'SELECT a.id, a.title ' .
			' FROM #__usergroups AS a' .
			' ORDER BY a.lft ASC'
		);
		$myGroups=$db->loadAssocList('id','title');
		if( empty($myGroups)) return false;

		$resultA=array();
		if( !empty($myGroups)){

			foreach( $myGroups as $id=> $title){
				$user=new stdClass;
				$user->id=$id;
				$user->name=$title;
				$resultA[]=$user;
			}		}
		return $resultA;
	}






	public function insertRole($uid,$equivalentRole){

		if( empty($equivalentRole)) return false;

				$userM=WModel::get( 'users', 'object', null, false );
		$userM->whereE( 'uid', $uid );
		$userID=$userM->load( 'lr', 'id' );

		if( empty($userID)) return false;
		$db=JFactory::getDBO();
		$query='INSERT IGNORE #__user_usergroup_map ' .
			' (`user_id` ,`group_id`) VALUES ( ' . (int)$userID . ', ' . (int)$equivalentRole . ') ';
		$db->setQuery( $query );
		$db->query();

	}





	public function deleteRole($uid,$equivalentRole){

		if( empty($equivalentRole)) return false;

				$userID=WUser::get( 'id', $uid );
		if( empty($userID)) return false;

		$db=JFactory::getDBO();

		$db->setQuery(
			'DELETE FROM #__user_usergroup_map ' .
			' WHERE user_id=' . (int)$userID . ' AND group_id=' . (int)$equivalentRole
		);
		$db->query();

	}
}