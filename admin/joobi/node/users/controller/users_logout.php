<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Users_logout_controller extends WController {
function logout(){



	$usersAddon=WAddon::get( 'users.' . JOOBI_FRAMEWORK );

	return $usersAddon->goLogout();



}}