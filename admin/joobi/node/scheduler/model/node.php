<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_Node_model extends WModel {


	private $_copyingTask=false;





	function validate(){



		$this->validateDate( 'nextdate' );



		if( !empty($this->maxtime) && !$this->_copyingTask ) $this->maxtime=$this->maxtime * 60;



		if( empty($this->viewname) && !empty($this->core)) $this->viewname=$this->namekey;



		if(!empty($this->p['maxtimefreq'])){

			$this->p['maxtimefreq']=$this->p['maxtimefreq'] * 60;

		}
		if(!empty($this->p['mintimefreq'])){

			$this->p['mintimefreq']=$this->p['mintimefreq'] * 60;

		}
		
		if(!empty($this->ptype) && $this->ptype==2){

			$cronparser=WClass::get('scheduler.cronparser');

			$cronparser->checkCron($this->cron);

		}


		return parent::validate();



	}












	function copyValidate(){

		$this->_copyingTask=true;

		return true;

	}}