<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_process_controller extends WController {














	function process(){



		
		$scheduleP=WPref::get( 'scheduler.node' );

		$scheduleP->updatePref( 'last_launched', time());



		
		
		if( intval( PLIBRARY_NODE_CRON ) >=5){	


			
			if(  WPref::load( 'PSCHEDULER_NODE_USEPWD' )){

				$password=WGlobals::get('password', '', '', 'string' );

				if( $password !=PSCHEDULER_NODE_PASSWORD ) return false;

			}


			$schedulerTasksO=WObject::get( 'scheduler.launchtasks' );

			$nbResults=$schedulerTasksO->process();



			
			$uid=WUser::get('uid');

			if( $uid > 0){

				$message=WMessage::get();

				$message->userS('1299163902NDIX');

				$message->userN('1298294163YKW',array('$nbResults'=>$nbResults));

				return false;

			}else{

				echo '<br>Scheduler working! ' . $nbResults . ' tasks.';

				exit();

			}


		}


		return true;



	}
}