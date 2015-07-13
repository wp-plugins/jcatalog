<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');











class Api_Wp4_Users_class extends WClasses {



	private $appName=null;















	public function wpRun($appName){



	}












	public function addUser($user_id=null){



		
		$checkUserSyncDone=WGlobals::get( 'userSyncOnSaveDone', false, 'global' );

		if( $checkUserSyncDone ) return true;



		
		$userA=$this->_loadUserInfo( $user_id );

		if( empty($userA)) return false;



		$usersAddon=WAddon::get( 'api.'. JOOBI_FRAMEWORK . '.user' );

		$status=$usersAddon->syncUser( $userA, true, true );



		WGlobals::set( 'userSyncOnSaveDone', true, 'global' );



		return $status;



	}












	public function editUser($user_id=null,$old_user_data=null){



		
		$checkUserSyncDone=WGlobals::get( 'userSyncOnSaveDone', false, 'global' );

		if( $checkUserSyncDone ) return true;



		


		$userA=$this->_loadUserInfo( $user_id );

		if( empty($userA)) return false;





		$usersAddon=WAddon::get( 'api.'. JOOBI_FRAMEWORK . '.user' );

		$status=$usersAddon->syncUser( $userA, false, true );



		WGlobals::set( 'userSyncOnSaveDone', true, 'global' );

		return $status;





	}














	public function deleteUser($user_id=null){



		if( empty($user_id)) return false;



		$usersM=WModel::get('users');

		
		$usersM->whereE('id', $user_id );

		return $usersM->deleteAll();



	}




















	public function addUserPlugin($namekey,$user_id=null){



		
		$userA=$this->_loadUserInfo( $user_id );

		if( empty($userA)) return false;



		$instance=WExtension::plugin( $namekey );

		$instance->onUserAfterSave( $userA, true, '', '' );



	}
















	public function deleteUserPlugin($namekey,$user_id=null){



		$userA=$this->_loadUserInfo( $user_id );

		if( empty($userA)) return false;



		
		$instance=WExtension::plugin( $namekey );

		$instance->onUserAfterDelete( $userA, '', '' );



	}


















	public function editUserPlugin($namekey,$user_id=null,$old_user_data=null){



		
		$userA=$this->_loadUserInfo( $user_id );

		if( empty($userA)) return false;



		$instance=WExtension::plugin( $namekey );

		$instance->onUserAfterSave( $userA, false, '', '' );



	}




















	public function loginUserPlugin($namekey,$user_login=null,$user=null){



		$userA=$this->_loadUserInfo( $user->ID );



		if( empty($userA)) return false;



		
		$instance=WExtension::plugin( $namekey );

		$instance->onUserLogin( $userA, null );



	}




	public function logoutUserPlugin($namekey){



		
		$instance=WExtension::plugin( $namekey );

		$instance->onUserLogout( null, null );



	}












	private function _loadUserInfo($user_id){



		
		if( empty($user_id)){

			$email=WGlobals::get( 'email' );

			$wpUserT=WTable::get( '#__users', '', 'ID' );

			$wpUserT->whereE( 'user_email', $email );

			$user_id=$wpUserT->load( 'lr', 'ID' );

		}


		if( empty($user_id)) return false;



		$userCompleteO=get_userdata( $user_id );

		if( empty($user_id)) return false;



		$userO=$userCompleteO->data;



		$userA=array();

		if( isset($userO->ID)) $userA['id']=$userO->ID;

		if( isset($userO->user_email)) $userA['email']=$userO->user_email;

		if( isset($userO->user_login)) $userA['username']=$userO->user_login;


		$userA['password_clear']=WGlobals::get( 'WP_userPass', '', 'global' );

		if( isset($userO->display_name)) $userA['name']=$userO->display_name;



		
		$userA['roles']=$userCompleteO->roles;



		return $userA;



	}


}