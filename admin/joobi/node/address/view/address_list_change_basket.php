<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_Address_list_change_basket_view extends Output_Listings_class {
protected function prepareView() {



	$selectedid = WGlobals::get('selectedid');

	$basketaddtype = WGlobals::get('basketaddtype');



	if ( !empty($selectedid) ) WGlobals::setSession( 'checkoutEditAddress', 'selectedid', $selectedid );

	else WGlobals::set( 'selectedid', WGlobals::getSession( 'checkoutEditAddress', 'selectedid' ) );



	if ( !empty($basketaddtype) ) WGlobals::setSession( 'checkoutEditAddress', 'basketaddtype', $basketaddtype );

	else WGlobals::set( 'basketaddtype', WGlobals::getSession( 'checkoutEditAddress', 'basketaddtype' ) );



	return true;



}}