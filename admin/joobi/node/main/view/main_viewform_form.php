<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Main_viewform_form_view extends Output_Forms_class {
function prepareView() {



	$type = $this->getValue( 'type' );



	$designLayoutTypeT = WType::get( 'design.layoutype' );

	$acceptedTypeA = $designLayoutTypeT->allNames();



	if ( !in_array( $type, $acceptedTypeA ) ) {

		$this->removeElements( 'main_viewform_form_parentdft' );

	}

	if ( WRoles::isAdmin( 'manager' ) ) {

		$this->removeMenus( 'main_viewform_form_save_ajax' );

	} else {

		$this->removeMenus( 'main_viewform_form_save_normal' );

	}





	return true;



}}