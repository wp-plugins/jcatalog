<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_CoreStatus_listing extends WListings_default{


	function create(){



		$sid=$this->modelID;

		$nextdate='nextdate_'.$sid;

		$lastdate='lastdate_'.$sid;

		$frequency='frequency_'.$sid;

		
		if( $this->data->$nextdate < time()){

			$this->content='<font color="red"><u>Late</u> </font>';

		}else{

			$this->content='<font color="green"><u>On time</u> </font>';

		}
		



















		

		return true;

	}}