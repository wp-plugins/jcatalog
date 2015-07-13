<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




class Api_Mobilev1_User_addon {





	public function checkPlugin(){
	}




	public function goLogin($itemId=null,$message=''){
	}




	public function goRegister($itemId=null){
	}




	public function addUserRedirect(){
	}





	public function editUserRedirect($eid,$onlyLink=false){

	}













	public function ghostAccount($email,$password,$name='',$username='',$automaticLogin=false,$createJoobiUser=true,$extraPrams=null){

		return true;

	}





	public function automaticLogin($username,$password,$url='',$pageId=0){


				$usersCredentialC=WUser::credential();
		$userO=$usersCredentialC->verifyCredentialsAndLogin( $username, $password );

		if( empty($userO)) return false;

						$userSessionC=WUser::session();
		$sessionUser=$userSessionC->setUserSession( $userO->uid, false, 'uid' );


		return $userO->uid;

	}





	public function logout(){

				$_SESSION=array();
		WGlobals::setSession( '', '', '', true );
		session_destroy();

		if( ini_get("session.use_cookies")){
		    $params=session_get_cookie_params();
		    setcookie( session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"] );
		}
	}





	public function onAfterInitialise(){

	}


	




	public function getAvatar($userid){
	}









	public function syncUser($user,$isnew,$success,$msg){

	}








	public function clearSession($space='site'){

		$componentM=WModel::get( 'library.session' );
		$componentM->delete();

	}





	public function updateSession($uid,$ip){
		return true;

		$sessionID=WUser::getSessionId();
		if( empty($sessionID)) return;
		$sessionM=WTable::get( 'sesion_node', 'main_userdata', 'sessid' );
		$sessionM->setVal('sessid', WUser::getSessionId());
		$sessionM->setVal('uid', $uid );
		$sessionM->setVal( 'framework', WApplication::$ID );
		$sessionM->setVal('created', time());
		$sessionM->setVal('modified', time());
		$sessionM->setVal('ip', $ip, 0, null, 'ip' );
		$sessionM->replace();


				if( defined('PLIBRARY_NODE_SESSION_CLEAR') && PLIBRARY_NODE_SESSION_CLEAR > time()){
						$myTime=( JOOBI_SESSION_LIFETIME < 1 ) ? 5 : JOOBI_SESSION_LIFETIME;
			$expiredTime=time() - $myTime * 60; 						$sessionM->noValidate();
			$sessionM->where( 'modified' , '<=' , $expiredTime );
			$sessionM->whereE( 'framework', WApplication::$ID );
			$sessionM->delete();


		}
	}






	public function deleteSession($sessionID){


	}
}