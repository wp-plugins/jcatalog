<?php 

* @link joobi.co
* @license GNU GPLv3 */
















class WForm_Coreconcatenate extends WForms_default {









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

		if( !empty($HTML)){
			$frame->add( $HTML );
		}
	}




	function close(&$frame){
		$frame->endPane();
		$this->content=$frame->display();
	}

}

