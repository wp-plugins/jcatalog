<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'form.layout' );
class Main_Coreformparams_form extends WForm_layout {
function create() {



	
	$namekey = $this->getValue( 'type' );



	$mainDirectEditC = WClass::get( 'main.directedit' );
	$exist = $mainDirectEditC->getParamsView( $namekey, 'form' );

	if ($exist) {
		$this->viewID = $exist;
		return parent::create();
	} else {
		return false;
	}

	return true;



}}