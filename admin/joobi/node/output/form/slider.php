<?php 

* @link joobi.co
* @license GNU GPLv3 */



















class WForm_Coreslider extends WForms_default {



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
		}elseif( WPref::load( 'PMAIN_NODE_DIRECT_TRANSLATE' )){
		}

		$frame->startPage( $params );
		$frame->add( $HTML );
		$frame->endPage( $params );


	}




	function close(&$frame){
		$frame->endPane();
		$this->content=$frame->display();
	}
}


