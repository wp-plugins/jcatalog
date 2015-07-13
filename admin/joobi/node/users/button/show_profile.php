<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Users_CoreShow_profile_button extends WButtons_external {


	function create(){



		$usersAddon=WAddon::get( 'users.'. WPref::load( 'PUSERS_NODE_FRAMEWORK_FE'));

		$link=$usersAddon->showUserProfile( WUser::get( 'uid' ), true );

		if( empty( $link )) return false;


		$this->setAction( $link );



		return true;



	}}