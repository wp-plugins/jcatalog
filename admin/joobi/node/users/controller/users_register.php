<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Users_register_controller extends WController {

	function register(){


		$uid=WUser::get( 'uid' );

		$usersAddon=WAddon::get( 'users.'. WPref::load( 'PUSERS_NODE_FRAMEWORK_FE' ));
		if( empty($uid)){

			$allowRegistration=WPref::load( 'PUSERS_NODE_REGISTRATIONALLOW' );
			if( empty($allowRegistration)){
				$this->userE('1401855798FZFQ');
				return false;
			}			$usersAddon->goRegister();
		}else{
			$usersAddon->goProfile( $uid );
		}


		return true;



	}
}