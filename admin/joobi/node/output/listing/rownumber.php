<?php 

* @link joobi.co
* @license GNU GPLv3 */

















class WListing_Corerownumber extends WListings_default{






	public function createHeader(){
				if( empty($this->element->align)) $this->element->align='center';
		if( empty($this->element->width)) $this->element->width='25px';
				return false;
	}




	function create(){
				$this->content=(string)($this->line + 1);
		return true;
	}




	public function advanceSearch(){
		return false;
	}







	public function searchQuery(&$model,$element,$searchedTerms=null,$operator=null){
	}
}
