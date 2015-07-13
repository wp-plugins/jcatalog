<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_CoreBackbe_button extends WButtons_external {




function create() {



	$roleC = WRole::get();

	$roleVend = WRole::hasRole( 'vendor' );

	if ( !$roleVend ) return false;



	if ( WRoles::isAdmin( 'storemanager' ) ) $link = WPage::routeURL( 'controller=vendors' );

	else {

		$lastPage = WGlobals::getSession( 'pageLocation', 'lastPage', 'controller=catalog' );

		$lastPageItem = WGlobals::getSession( 'pageLocation', 'lastPageItem', true );

		$link = WPage::routeURL( $lastPage, '', false, false, $lastPageItem );

	}


	$this->setAddress( $link );





	return true;



}}