<?php 

* @link joobi.co
* @license GNU GPLv3 */


















class WListing_Coreradio extends WListings_default{





	public function createHeader(){
				if( empty($this->element->align)) $this->element->align='center';
		if( empty($this->element->width)) $this->element->width='30px';
				return false;
	}




	function create(){

		if( !empty( $this->element->autoselectpremium ) && $this->getValue('premium')){
			$this->checked=1;
						WGlobals::set( 'radioCheckNoNeedListConfirm', true );
		}		$this->content='<input type="radio" id="em'.$this->line.'" value="'.$this->value.'" name="'.$this->name.'[]" ';
		if( $this->checked ) $this->content .='checked="checked" ';
		$this->content .='/>';
		return true;

	}





	public function advanceSearch(){
		return false;
	}







	public function searchQuery(&$model,$element,$searchedTerms=null,$operator=null){
	}
}

