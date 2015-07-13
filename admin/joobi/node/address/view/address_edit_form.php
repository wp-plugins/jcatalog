<?php 

* @link joobi.co
* @license GNU GPLv3 */



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