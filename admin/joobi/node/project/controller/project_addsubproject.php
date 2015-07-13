<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
 class Project_Addsubproject_controller extends WController {








	function addsubproject() {

		WGlobals::setEID(  0);

		$this->setView( 'project_milestone_form');



		return true;



	}
}