<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.select' );
class Main_CoreTypeform_form extends WForm_select {
function create() {



	if ( $this->newEntry ) {

		return parent::create();

	}


	
	
	$designLayoutTypeT = WType::get( 'design.layoutype' );

	$layoutTypeA = $designLayoutTypeT->allNames();



	if ( in_array( $this->value, $layoutTypeA ) ) {



		return parent::create();

	}








	$formObject = WView::form( $this->formName );

	$formObject->hidden( $this->map, $this->value );



	$this->content = $this->value;



	return true;



}}