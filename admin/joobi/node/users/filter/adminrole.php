<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Users_Adminrole_filter {

	function create(){


		if( WRole::hasRole( 'sadmin' )) return false;



		return true;



	}
}