<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Users_System_plugin extends WPlugin {


	function onAfterInitialise(){
		$usersAddon=WAddon::get( 'api.'. JOOBI_FRAMEWORK . '.user' );
		$usersAddon->onAfterInitialise();
	}
}