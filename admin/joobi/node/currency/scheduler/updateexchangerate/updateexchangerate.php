<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Currency_Updateexchangerate_scheduler extends Scheduler_Parent_class {


	function process() {


		
		$time = $this->getCurrentRun();

		if ( empty($time) || ( $time == 0 ) ) $time = time();



		
		static $curRateC=null;

		if ( empty($curRateC) ) $curRateC = WClass::get( 'currency.rate' );

		$curRateC->updateExchangeRate( '', $time );


		return true;


	}

}