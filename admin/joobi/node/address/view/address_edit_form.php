<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_Address_edit_form_view extends Output_Forms_class {
function prepareView() {



	$zoneusestates =  WPref::load( 'PBASKET_NODE_ZONEUSESTATES' );



	if ( empty($zoneusestates) ) {

		$this->removeElements( array('address_edit_form_address_stateid' ) );

	} else {

		$this->removeElements( array('address_edit_form_address_state' ) );

	}


	return true;



}}