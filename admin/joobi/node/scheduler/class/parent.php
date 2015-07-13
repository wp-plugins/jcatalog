<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');











class Scheduler_Parent_class extends WClasses {

















	


















	








	public $lastProcess=true;





	var $element=null;













	var $report=false;

















	var $_reports=array();





















	function process(){

		return true;

	}
















	function continueProcess(){

		if(time() >=$this->element->maxtime) return false;

		return true;

	}










	function lastProcess(){

		return $this->lastProcess;

	}












	function getLastRun(){

		return $this->element->lastdate;

	}














	function getNextRun(){

		return $this->element->nextdate;

	}












	function getMaxTime(){

		return $this->element->maxtime;

	}














	function getCurrentRun(){

		return $this->element->time;

	}
















	protected function increaseFrequency($ratio=2,$maximum=null){

		$newFrequency=$this->element->frequency / $ratio;

		if( isset($maximum) && $newFrequency < $maximum ) $newFrequency=$maximum;

		if( $newFrequency< 1 ) $newFrequency=1;

		return $this->changeFrequency( $newFrequency );

	}
















	protected function decreaseFrequency($ratio=2,$minimum=null){

		$newFrequency=$this->element->frequency * $ratio;

		if( isset($minimum) && $newFrequency > $minimum ) $newFrequency=$minimum;

		if( $newFrequency < 1 ) $newFrequency=1;

		return $this->changeFrequency( $newFrequency );

	}
















	function getFrequency(){

		return $this->element->frequency;

	}














	function addReport($report){



		if( empty($report)) return;

		if( is_array($report)) $this->_reports=array_merge($this->_reports,$report);

		else $this->_reports[]=(string) $report;

	}














	function getReports(){

		return $this->_reports;

	}














	function getID(){

		return $this->element->schid;

	}














	function setTask($task){

		$this->element=$task;

	}
















	function displayInfo(){

		return 	$this->report;

	}












	function unPublishScheduler($reason=''){





		$schedulerM=WModel::get( 'scheduler' );

		$schedulerM->whereE( 'schid', $this->element->schid );

		$schedulerM->setVal( 'publish', 0 );

		$schedulerM->update();



		
		$mail=WMail::get();

		$subject='A scheduled task has been automatically unpublished: '. $this->element->viewname;

		$body="Hello administrator,\n\r A scheduled task has been automatically unpublished. This is the unique name ". $this->element->viewname;

		$body .="\n\r This is the ID : " . $this->element->schid;

		if( !empty($reason)) $body .="\n\r Reason : " . $reason;

		$body .="\n\r\n\r No action is necessary but we wanted to inform you in case you wanted to verify why that task has been automatically Unpublished.";

		$mail->sendTextAdmin( $subject, $body );



		return false;

	}


















	function getParam($paramName,$default=null){

		if(isset($this->$paramName)) return $this->$paramName;

		return $default;

	}














	function changeFrequency($newRate){



		$schedulerM=WModel::get( 'scheduler' , 'object' );

		$schedulerM->whereE( 'schid', $this->element->schid );

		$schedulerM->setVal( 'frequency' , (int)$newRate );

		return $schedulerM->update();



	}


}


