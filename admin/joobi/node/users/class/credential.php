<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Users_Credential_class extends WClasses {




	public function goLogin(){

		WGlobals::setSession( 'login', 'previousURL', WView::getURI());
		$usersAddon=WAddon::get( 'users.' . WPref::load( 'PUSERS_NODE_FRAMEWORK_FE' ));
		$usersAddon->goLogin();

	}




	public function goRegister(){

		$usersAddon=WAddon::get( 'users.'. WPref::load( 'PUSERS_NODE_FRAMEWORK_FE' ));
		$usersAddon->goRegister();

	}








	public function verifyCredentialsAndLogin($username,$password){

		if( empty($password) || empty($username)){
			$this->userE('1415722221IUIO');
			return false;
		}
				$userO=WUser::get( 'data', $username );

		if( empty($userO)){
						$this->userE('1414741764AKJF');
			return false;
		}
		if( !empty($userO->password)){
			$usersEncryptC=WClass::get( 'users.register' );
			$match=$usersEncryptC->verifyMatchPassword( $password, $userO->password );
		}else{
			$match=false;
		}
		if( ! $match){

									$status=$this->_checkLegacy( $userO, $password );

			if( !$status){
				$this->userE('1408041590EIQX');
				return false;
			}
		}

				$membersSessionC=WUser::session();
		$sessionUser=$membersSessionC->setUserSession( $userO->uid, true, 'uid' );

		return $sessionUser;

	}






	private function _checkLegacy($userO,$password=''){

				if( !empty($userO->password)){
			return false;
		}else{
						if( $userO->registerdate < 1414627200){									$usersRegsiterC=WClass::get( 'users.register' );
				$newPassword=$usersRegsiterC->generateHashPassword( $password );

				$UserM=WModel::get( 'users' );
				$UserM->whereE( 'uid', $userO->uid );
				$UserM->setVal( 'password', $newPassword );
				$UserM->update();

				return true;
			}else{
				return false;
			}
		}
	}















	public function ghostAccount($email,$name='',$automaticLogin=false,$password=null,$username=null,$fromRegistration=false,$url='',$pageId=0){

		$email=trim( $email );
		$usersEmailC=WClass::get( 'users.email' );
		if( !$usersEmailC->validateEmail( $email )){
			$message=WMessage::get();
			$EMAIL=$email;
			$message->historyE('1377828382KXRU',array('$EMAIL'=>$EMAIL));
		}
						$uid=$this->_checkUser( $email );
		if( !empty($uid)){

						if( $automaticLogin){

				if( !defined('PUSERS_NODE_FRAMEWORK_FE')) WPref::get( 'users.node', false, true, false );
				$usersAddon=WAddon::get( 'users.'. PUSERS_NODE_FRAMEWORK_FE );

				$user=WUser::get( 'data', $uid );

				if( !empty($user->registered) && !empty($user->id)){

					if( !empty($password) && !empty($username)){


						if( $username !=$user->username){
														$this->_go2LoginPage( $fromRegistration );
						}

												$status=$usersAddon->automaticLogin( $user->username, $password );

						if( !empty($status)){
														return $user->uid;
						}else{
														$this->_go2LoginPage( $fromRegistration );
						}
					}else{
												$this->_go2LoginPage( $fromRegistration );
					}
				}else{
																				
				}
			}
			return $uid;

		}
		if( empty($name)) $name=$email;
		
		if( empty($password)){
			$password=WTools::randomString( 11, true );
						$sendPwd=false;			}else{
						$sendPwd=false;
		}
		if( !empty( $url )){
			$extraPramsO=new stdClass;
			$extraPramsO->url=$url;
			if( !empty($pageId)) $extraPramsO->pageID=$pageId;
		}

				WGlobals::set( 'userSyncSendPwd', $sendPwd, 'global' );

		if( !defined('PUSERS_NODE_FRAMEWORK_FE')) WPref::get( 'users.node', false, true, false );
		$usersAddon=WAddon::get( 'users.' . PUSERS_NODE_FRAMEWORK_FE );
		$status=$usersAddon->ghostAccount( $email, $password, $name, $username, $automaticLogin, true, $sendPwd, $extraPramsO );

		if( $status !==true){
			return 0;
		}
		$uid=$this->_checkUser( $email );
		if( !empty($uid)){
			WUser::get( null, 'reset' );
			$membersSessionC=WUser::session();
			$membersSessionC->setUserSession( $uid, true, 'uid' );

						$mailParams=new stdClass;
			$mailParams->name=$name;
			$namedA=explode( ' ', $name );
			if( !empty($namedA)) $mailParams->firstName=$namedA[0];
			$mailParams->username=( !empty($username) ? $username : $email );
			$mailParams->email=$email;
			$mailParams->password=$password;

						$mailingM=WMail::get();
			$mailingM->setParameters( $mailParams );
			$mailingM->sendNow( $uid, 'users_ghost_account', false );
		}else{
						WMessage::log( 'Failed to create guest account', 'error-guest-account-failed' );
			WMessage::log( $email, 'error-guest-account-failed' );
			WMessage::log( $name, 'error-guest-account-failed' );
			WMessage::log( $username, 'error-guest-account-failed' );

		}
		return $uid;

	}





	private function _go2LoginPage($fromRegistration){

		if( $fromRegistration){
			$message=WMessage::get();
			$message->historyW('1401195620IMUD');
		}
		if( !defined('PUSERS_NODE_FRAMEWORK_FE')) WPref::get( 'users.node', false, true, false );
		$usersAddon=WAddon::get( 'users.'. PUSERS_NODE_FRAMEWORK_FE );

				$this->userW('1401195620IMUD');

								$messageUser='';

		$status=$usersAddon->goLogin( true, $messageUser );


	}








	public function automaticLogin($username,$password,$frontEnd=true,$url='',$pageId=0){

		if( $frontEnd){
			$constantValue=WPref::load( 'PUSERS_NODE_FRAMEWORK_FE' );
		}else{
			$constantValue=WPref::load( 'PUSERS_NODE_FRAMEWORK_BE' );
		}
		$usersAddon=WAddon::get( 'users.' . $constantValue );
		return $usersAddon->automaticLogin( $username, $password, $url, $pageId );

	}







	private function _checkUser($email){


		$usersM=WModel::get('users');
				$usersM->whereE( 'email' , $email );
		return $usersM->load('lr', 'uid' );

	}

}