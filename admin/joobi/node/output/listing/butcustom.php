<?php 

* @link joobi.co
* @license GNU GPLv3 */

















class WListing_CoreButcustom extends WListings_default{





	public function createHeader(){
				if( empty($this->element->align)) $this->element->align='center';
		if( empty($this->element->width)) $this->element->width='30px';
				return false;
	}





	function create(){
		if( empty($this->value)) return false;

		if( !isset($this->buttonNameSepcial)){
			$this->buttonNameSepcial=$this->element->map;
		}
		switch( $this->buttonNameSepcial){
			case 'copy':
				$text=WText::t('1206732372QTKK');
				break;
			case 'delete':
				$text=WText::t('1206732372QTKL');
				$ACTION=$text;
				$this->element->lienValidation='onclick="return confirm(\''.str_replace(array('$ACTION'), array($ACTION),WText::t('1233626551NWXV')).'\')"';
				break;
			case 'edit':
				$text=WText::t('1206732361LXFE');
				break;
			case 'show':
				$text=WText::t('1206732372QTKM');
				break;
			default :
				$text=$this->element->name;
		}

		$data=new stdClass;
		$data->image=$this->buttonNameSepcial;
		$data->text=$text;
		$img[$this->buttonNameSepcial]=WPage::renderBluePrint( 'legend', $data );

		$this->content=$img[$this->buttonNameSepcial];

		return true;

	}





	public function advanceSearch(){
		return false;
	}







	public function searchQuery(&$model,$element,$searchedTerms=null,$operator=null){
	}
}