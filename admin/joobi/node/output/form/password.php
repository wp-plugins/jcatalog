<?php 

* @link joobi.co
* @license GNU GPLv3 */












WView::includeElement( 'form.text' );




class WForm_Corepassword extends WForm_text {

	protected $inputClass='inputbox';
	protected $inputType='password';	
}


	function create(){

				if( empty( $this->element->width )) $this->element->width=20;

		return parent::create();
	}