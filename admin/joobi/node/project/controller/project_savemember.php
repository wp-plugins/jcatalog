<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');
 class Project_Savemember_controller extends WController {








	function savemember(){

		$truc = WGlobals::get('trucs');

		$sid = WModel::get('project.members','sid');



		if (is_array($truc) && isset($truc[$sid])){

			$this->_model = WModel::get('project.members');

			$this->_model->getFormData();




			$this->_model->save();

			return WText::t('1209674941LKQS');

		}

		else {

			return WText::t('1209674941LKQT');

		}

	}
}