<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Users_save_controller extends WController {


	function save(){



		$status=parent::save();



		if( WRoles::isAdmin( 'manager' )){

			$this->setView( 'users_listings' );

			return  $status;

		

		}else{

			$this->setView( 'users_dashboard' );

			return $status;

		}


	}}