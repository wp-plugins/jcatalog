<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Users_CoreProfile_edit_button extends WButtons_external {


	function create(){



		$usersAddon=WAddon::get( 'users.'. WPref::load( 'PUSERS_NODE_FRAMEWORK_FE' ));

		$link=$usersAddon->editUserRedirect( WUser::get( 'uid' ), true );


		if( empty( $link )) return false;


		$this->setAction( $link );



		return true;



	}}