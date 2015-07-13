<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


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