<?php 

* @link joobi.co
* @license GNU GPLv3 */

















class WButton_CoreExtlink extends WButtons_default {

	protected $noJSonButton=true;
	var $_target='_blank';





	function create(){

		$this->buttonO->href=$this->buttonO->action;
		return true;
	}
}