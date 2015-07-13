<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');



 class Project_Milestone_model extends WModel {



	function validate() {



		$prefix='C'.WModel::get('milestonetrans','sid');

		
		if (isset($this->alias) && isset($this->$prefix->name)) {

			if (empty($this->alias)) {

				$this->alias=$this->$prefix->name;

			}

		}



		
		if (isset($this->startdate)) {

			
			if ($this->startdate != '0000-00-00 00:00:00') {

				$this->startdate = strtotime( $this->startdate );

			}




 		}

 		if (isset($this->deadline) && isset($this->startdate)) {

			
			if ($this->deadline != '0000-00-00 00:00:00') {

				$this->deadline = strtotime( $this->deadline );

			}




 		}



		return true;

	}





}