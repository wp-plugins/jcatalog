<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');
 class Project_Canceltask_controller extends WController {








	function canceltask() {



		WPref::get('task');

		$this->_model = WModel::get('task');

		$this->getTruc();



		WGlobals::setEID(  $this->_model->pjid );



		
		return true;

	}











	function addtask() {

		$status = parent::add();





		
		return true;

	}
}