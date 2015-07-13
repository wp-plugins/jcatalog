<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Users_cancel_controller extends WController {
function cancel(){



	$status=parent::cancel();



	if( WRoles::isAdmin( 'manager' )) return  $status;

	else {

		$this->setView( 'users_dashboard' );

		return $status ;

	}


}}