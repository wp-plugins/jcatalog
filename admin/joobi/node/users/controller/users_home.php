<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Users_home_controller extends WController {

	function home(){


		$isRegistered=WUser::isRegistered();
		if( !empty($isRegistered)){
			$itemId=WPage::getSpecificItemId( 'users', 'dashboard' );
			WPages::redirect( 'controller=users&task=dashboard', $itemId );
		}

		if( !defined('PUSERS_NODE_FRAMEWORK_FE')) WPref::get( 'users.node', false, true, false );

		$usersAddon=WAddon::get( 'users.'. PUSERS_NODE_FRAMEWORK_FE );
		$usersAddon->goLogin();



		return true;



	}
}