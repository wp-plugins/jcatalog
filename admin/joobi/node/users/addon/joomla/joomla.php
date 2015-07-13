<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WLoadFile( 'users.class.parent', JOOBI_DS_NODE );
class Users_Joomla_addon extends Users_Parent_class {






	public function getUser($userId,$loadFrom=''){			static $myMember=array();

		if( empty($userId)) return '';

		$colID=( empty($loadFrom)) ? 'id' : $loadFrom;
		$key=trim($userId.'-'.$colID);
		$key=(string)$key;

		if( isset($myMember[$key])) return $myMember[$key];	
		$userM=WModel::get( 'users', 'object', null, false );
		if( empty($userM)){
			WMessage::log( $userId, 'install-missing-users-model' );
			WMessage::log( debugB(), 'install-missing-users-model' );
			WMessage::log( 'install-missing-users-model', 'install' );
			return false;
		}

		$userM->select( '*', 0 );
		$userM->select( 'ip', 0, 'realip', 'ip' );
		if( is_numeric($userId)){
			$userM->whereE( $colID, $userId );
		}else{
			$userM->whereE('email',$userId);
			$userM->operator( 'OR' );
			$userM->whereE( 'username', $userId );
		}
				$userM->select( 'id', 0, 'id' );
		$myMember[$key]=$userM->load( 'o' );			if( empty($myMember[$key])) $myMember[$key]=false;

		return $myMember[$key];

	}









	public function goLogin($itemId=null,$message=''){
		$usersAddon=WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.user' );
		return $usersAddon->goLogin( $itemId, $message );
	}










	public function goRegister($itemId=null){
		$usersAddon=WAddon::get( 'api.'. JOOBI_FRAMEWORK . '.user' );
		return $usersAddon->goRegister( $itemId );
	}





	public function checkPlugin(){
		WApplication::enable( 'plg_users_user_plugin', 1, 'plugin' );
	}












	public function ghostAccount($email,$password,$name='',$username=null,$automaticLogin=false,$createJoobiUser=true,$sendPwd=false,$extraPrams=null){
		$usersAddon=WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.user' );
		return $usersAddon->ghostAccount( $email, $password, $name, $username, $automaticLogin, $createJoobiUser, $sendPwd, $extraPrams );
	}




	public function addUserRedirect(){
		$usersAddon=WAddon::get( 'api.'. JOOBI_FRAMEWORK . '.user' );
		return $usersAddon->addUserRedirect();
	}







	public function showUserProfile($eid,$onlyLink=false){
		$usersAddon=WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.user' );
		return $usersAddon->showUserProfile( $eid, $onlyLink );
	}






	public function editUserRedirect($eid,$onlyLink=false){
		$usersAddon=WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.user' );
		return $usersAddon->editUserRedirect( $eid, $onlyLink );
	}





	public function getPicklistElement(){
		$usersAddon=WAddon::get( 'users.'. JOOBI_FRAMEWORK );
		return $usersAddon->getPicklistElement();
	}







	public function automaticLogin($username,$password,$url='',$pageId=0){
		$usersAddon=WAddon::get( 'api.'. JOOBI_FRAMEWORK . '.user' );
		return $usersAddon->automaticLogin( $username, $password, $url, $pageId );
	}





	public function checkConfirmationRequired(){
				return false;

	}






	public function getAvatar($uid){
		$avatar=WUser::avatar($uid);
		return $avatar;
	}
}