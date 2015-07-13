<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Users_Users_listings_view extends Output_Listings_class {
function prepareView(){



	$mainExit=WExtension::exist( 'main.node' );

	if( !$mainExit )  $this->removeElements( array( 'users_listings_users_ip', 'users_listings_users_login_report' ));



	return true;



}}