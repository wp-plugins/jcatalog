<?php 

* @link joobi.co
* @license GNU GPLv3 */
















class WButton_CoreJscancel extends WButtons_default {

	protected $noJSonButton=true;




	function create(){

		
		$this->buttonO->buttonJS='history.back();';
		return true;
	}
}