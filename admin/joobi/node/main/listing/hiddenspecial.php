<?php 

* @link joobi.co
* @license GNU GPLv3 */

















class WListing_Corehiddenspecial extends WListings_default{




	function create() {
		static $hidden = array();
		if (!isset($hidden[$this->element->sid][$this->element->map])){
			$form  = WView::form( $this->formName );
			if (empty( $form ) ){
				$form = WView::form( WGlobals::get( 'parentFormid', '', 'global' ) );
			}			$element=WForm::getPrev($this->element->map);
			if (!$element){
				$element=WGlobals::getEID();
			}
			$form->hidden('trucs['.$this->element->sid.']['.$this->element->map.']',$element,true);
		}		return true;

	}
}


