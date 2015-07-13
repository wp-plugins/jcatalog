<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Users_home_dashboard_controller extends WController {

	function dashboard(){



		$isRegistered=WUser::isRegistered();



		if( empty($isRegistered)){

			$usersAddon=WAddon::get( 'users.' . WPref::load( 'PUSERS_NODE_FRAMEWORK_FE' ));

			$usersAddon->goLogin();

			return false;

		}


		$eid=WGlobals::get();

		if( empty($eid)){

			$eid=WUser::get( 'uid' );

			WGlobals::setEID( $eid );

		}

		return true;


	}
}