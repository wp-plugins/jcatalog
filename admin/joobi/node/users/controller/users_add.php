<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Users_add_controller extends WController {








	function add(){


		$usersAddon=WAddon::get( 'users.'. WPref::load( 'PUSERS_NODE_FRAMEWORK_BE' ));
		if( !empty($usersAddon)) $usersAddon->addUserRedirect();

		return parent::add();


	}
}