<?php 

* @link joobi.co
* @license GNU GPLv3 */
















class WForm_Corerow extends WForms_default {




	function create(){
				return true;
	}



	function show(){
		return true;
	}




	function start(&$frame,$params=null){
		$frame->startPane( $params );
	}



	public function addElementToField(&$frame,$params=null,$HTML=null){

		$frame->_data=$params;

		if( empty($HTML)) return;


				if( WPref::load( 'PMAIN_NODE_DIRECT_EDIT' )){
			$outputDirectEditC=WClass::get( 'output.directedit' );
			$editButton=$outputDirectEditC->editView( 'form', $this->yid, $this->element->fid, 'form-layout' );
			if( !empty($editButton)) $params->text=$editButton . $params->text;
		}elseif( WPref::load( 'PMAIN_NODE_DIRECT_TRANSLATE' )){

			
		}
		$frame->add( $HTML );

	}




	function close(&$frame){
		$frame->endPane();
		$this->content=$frame->display();
	}

}