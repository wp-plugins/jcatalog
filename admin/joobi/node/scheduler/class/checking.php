<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












class Scheduler_Checking_class extends WClasses {






	function lateTask(){

				$lastLaunched=WPref::load( 'PSCHEDULER_NODE_LAST_LAUNCHED' );			if( $lastLaunched < ( time() - 14400 )){				
			$message=WMessage::get();
			$message->userW('1405633010MFWR');
			$message->userW('1405633010MFWS');
			
			switch( intval( PLIBRARY_NODE_CRON )){
				case 5:											$message->userW('1374795728LREB');
					break;
				case 10:											break;
				case 15:						$message->userW('1374795728LREC');
					break;
			}
		}
	}
}