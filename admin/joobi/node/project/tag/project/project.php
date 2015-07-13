<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');






class Project_Project_tag {
 	







	function process($object){

		$tags = array();



		foreach($object as $tag => $value){

			switch($value->name) {

				case 'projectname':

					$tags[$tag] = $this->params->projectname;

					break;

				case 'priority':

					$tags[$tag] = $this->params->priority;

					break;

				case  'task':

					$tags[$tag] = $this->params->task;

					break;

				case  'description':

					$tags[$tag] = $this->params->description;

					break;

				case  'footer':

					$tags[$tag] = $this->params->footer;

					break;

				case  'namekey':

					$tags[$tag] = $this->params->namekey;

					break;

				case  'plink':

					$tags[$tag] = $this->params->plink;

					break;

				case  'deadline':

					$tags[$tag] = $this->params->deadline;

					break;

				case  'assignedto':

					$tags[$tag] = $this->params->assignedto;

					break;

			}









		}

		return $tags;

	}

}