<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_Basket_address_edit_view extends Output_Forms_class {
protected function prepareView() {



		$zoneusestates =  WPref::load( 'PBASKET_NODE_ZONEUSESTATES' );



		if ( empty($zoneusestates) ) {

			$this->removeElements( array('basket_edit_address_stateid_picklist' ) );

		} else {

			$this->removeElements( array('basket_edit_address_state_input' ) );

		}


	return true;



}}