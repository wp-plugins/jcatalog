<?php 

* @link joobi.co
* @license GNU GPLv3 */













WView::includeElement( 'form.text' );




class WForm_Corenumeric extends WForm_text {

		protected $inputType='number';		protected $inputClass='inputbox';





	function create(){

				if((int)$this->value==$this->value ) $this->value=(int)$this->value;
		return parent::create();
	}
	function show(){
				if((int)$this->value==$this->value ) $this->value=(int)$this->value;
		return parent::show();
	}
}