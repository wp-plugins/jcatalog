<?php 

* @link joobi.co
* @license GNU GPLv3 */


WView::includeElement( 'form.layout' );
class Design_Fieldparamslisting_form extends WForm_layout {
function create() {



	




	$designFieldsC = WClass::get( 'design.fields' );

	$namekey = $designFieldsC->load( $this->getValue( 'fieldid' ), 'listing' );



	$mainDirectEditC = WClass::get( 'main.directedit' );

	$exist = $mainDirectEditC->getParamsView( $namekey, 'listing' );


	if ($exist) {

		$this->viewID = $exist;

		return parent::create();

	} else {

		return false;

	}


	return true;



}}