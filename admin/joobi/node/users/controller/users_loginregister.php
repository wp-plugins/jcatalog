<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Users_loginregister_controller extends WController {

	function loginregister(){



		$isRegistered=WUser::isRegistered();

		if( !empty($isRegistered)){

			$uid=WUser::get( 'uid' );
			$usersAddon=WAddon::get( 'users.'. WPref::load( 'PUSERS_NODE_FRAMEWORK_FE' ));
			$usersAddon->goProfile( $uid );




		}

		

		return true;



	}
}