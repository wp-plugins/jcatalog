<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_Launchtasks_object {




	private $_forceTasks=0;	

	private $_nbTaskssuccss=0; 		private $_tasksfailed=array();	
	private $_limitSeconds=0;







	public function oneTask($namekey){

		if( empty($namekey)) return false;

		$schedulerM=WModel::get('scheduler','object');
		$schedulerM->whereE( 'viewname', $namekey );
		$task=$schedulerM->load('o', array('viewname','schid'));

		if( empty( $task )) return false;

		$this->_launchTask( $task );

		return true;

	}











 	public function process(){


 		
 		$schedulerPref=WPref::get('scheduler.node');

		$libraryPref=WPref::get('library.node');



		$time=time();



		$nbTasks=0;



		
		$debut=microtime();

		list( $usecdeb, $secdeb )=explode( " ", $debut );



		$message=WMessage::get();



		$cleanUpTime=WPref::load( 'PSCHEDULER_NODE_CLEANUPTIME' );
		if( $cleanUpTime < $time){
			$nextTime=$this->_cleanUpScheduledTask( $time );
			$schedulerPref->updatePref( 'cleanuptime', $nextTime );
		}




 		
		if( empty($this->_forceTasks)){


			if( PLIBRARY_NODE_NEXTCRON > $time){

				$message->userN('1298350272MURB');

				$DATE=WApplication::date( WTools::dateFormat( 'day-date-time' ) , PLIBRARY_NODE_NEXTCRON + WUser::timezone());

				$JOOBIDATE=WApplication::date( WTools::dateFormat( 'day-date-time' ) , $time + WUser::timezone());

				$message->userN('1235462002GHCA',array('$DATE'=>$DATE,'$JOOBIDATE'=>$JOOBIDATE));

				return 0;

			}


			$nextdate=intval( PLIBRARY_NODE_NEXTCRON ) + intval( PSCHEDULER_NODE_CRONFREQUENCY );

			if( $nextdate <=$time ) $nextdate=$time + intval( PSCHEDULER_NODE_CRONFREQUENCY );

			$libraryPref->updatePref( 'nextcron', $nextdate );

		}


		
		$schedprocessM=WModel::get( 'scheduler.processes' );

		$schedprocessM->select('pcsid',0,null,'count');

		$countpcsid=$schedprocessM->load( 'lr' );



		if( $countpcsid <=intval(PSCHEDULER_NODE_MAXPROCESS)){



 			$tasklimit=intval(PSCHEDULER_NODE_MAXTASKS) - $countpcsid;






 			
 			$schedulerM=WModel::get( 'scheduler', 'object' );
 			$schedulerM->makeLJ( 'scheduler.processes', 'schid' );
 			$schedulerM->groupBy( 'schid' );
 			$schedulerM->select( 'pcsid', 1 , 'totalcount', 'count' );



			if( empty($this->_forceTasks)){

				$schedulerM->whereE('publish',1);

				$schedulerM->where('nextdate', '<=', $time );

				$schedulerM->orderBy('priority','ASC');

				$schedulerM->setLimit( $tasklimit );

			}else{

				$schedulerM->whereE( $schedulerM->getPK(), $this->_forceTasks );

				$schedulerM->setLimit( 1 );

			}


			$tasksA=$schedulerM->load( 'ol', array( 'viewname', 'schid', 'maxprocess', 'namekey' ));


 			if( !empty($tasksA)){



 				
				
 			    if( ! ini_get('safe_mode')){ 		    		@set_time_limit( 0 );
        		}


				
				$this->_limitSeconds=intval( PSCHEDULER_NODE_TIMELIMIT ) - 5;



				
				$timelimit=$time + $this->_limitSeconds;



				
 				foreach( $tasksA as $task){


 					if( empty($task->totalcount)){
 						$task->totalcount=0;	 					}
 					if( $task->totalcount >=$task->maxprocess){

												$mail=WMail::get();
						$subject=JOOBI_SITE . ': Scheduled task ' . $task->namekey . ' get stuck.' ;
						$body="<p>Hello administrator,<br /> <br /> The scheduled task  <strong>".$task->namekey."</strong> with  <strong>Scheduler ".$task->schid."</strong> get stuck.</p>";
						$body .="<br /> It might be because the number of currently running processes exceeds its maximum number of processes allowed or the maximum number of  processes allowed has been reached.<br /> <br /> <br /> ";
						$body .="We wanted to inform you when this happens to take necessary actions.<br /> <br /> ";
						$body .="You might need to kill the currently running process for this  scheduler. To do this just delete the running process for this  scheduler.<br />";
						$body .=" Or contact Joobi Support and report this issue.<br /> <br />";
						$body .="<br /> Thank You!</div><p> </p>";

						 						continue;
 					}
 					$this->_launchTask( $task );
					$nbTasks++;



					
					if( time() >=$timelimit ) break;



 				}




				if( PSCHEDULER_NODE_SAVEREPORT){



					list($usecfin, $secfin)=explode(" ",  microtime());

					$SEC=$secfin - $secdeb;

					$msec=$usecfin - $usecdeb;

					if($msec<0){

						$SEC--;

						$msec=1 + $msec;

					}
					$MILLIS=(int) ($msec*1000);

					$NBURLSUCCESS=$this->_nbTaskssuccss;

					$NBURLLAUNCHED=$nbTasks;



					$message->addVar($NBURLLAUNCHED .' launched | '.$NBURLSUCCESS.' success');

					if( !empty($this->_tasksfailed)) $message->addVar('Tasks failed on launched: '. $this->_tasksfailed );

					$message->addVar('in '.$SEC.' s '.$MILLIS.' millis');

					$message->log('launching of tasks','scheduler_tasks_launched');



				}


 			}


 		}


 		return $nbTasks;



 	}




















 	private function _cleanUpScheduledTask($time){
				$maxexec=ini_get('max_execution_time');

								$maxtime=( !empty($maxexec) && $maxexec > 0 ) ? $maxexec * 2 : 900;

				if( $maxtime < 900 ) $maxtime=900;

				$schedProcessM=WModel::get( 'scheduler.processes' );
		$schedProcessM->where( 'created','<=', time() - $maxtime );
		$schedProcessM->delete();

		return ( $time + $maxtime );
 	}












 	private function _launchTaskDirectly($task){

 		$tasksO=WObject::get( 'scheduler.task' );
		$status=$tasksO->process( $task->schid, false, false );

		return $status;

 	}






 	private function _launchTask($task){
		static $password=null;
		static $schedulerClass=null;
		static $alreadylaunchedA=array();

		$cronparallel=WPref::load( 'PSCHEDULER_NODE_CRONPARALLEL' );
				if( empty($cronparallel)) return $this->_launchTaskDirectly( $task );


 				if( !isset($password)){

			if( !defined('PSCHEDULER_NODE_PASSWORD')) WPref::get('scheduler.node');
			$password='&password='. base64_encode( PSCHEDULER_NODE_PASSWORD );
			if( empty($this->_limitSeconds)) $this->_limitSeconds=intval( PSCHEDULER_NODE_TIMELIMIT ) - 5;

		}
				$time=time();
		$key=$time . '-' . $task->schid;
		if( isset($alreadylaunchedA[$key])){
			return false;
		}
		$alreadylaunchedA[$key]=true;
						$schedprocessM=WModel::get('scheduler.processes');
		$schedprocessM->setval('schid', $task->schid );
		$schedprocessM->setval('created', $time );
		$statusQuery=$schedprocessM->insert();

		if( !$statusQuery){
												$schedulerProcesssT=WTable::get( '#__scheduler_processes','','pcsid' );
			$schedulerProcesssT->load( 'q', 'ALTER TABLE `#__scheduler_processes` AUTO_INCREMENT=1' );
			return false;
		}
		$pcsid=$schedprocessM->lastID();

		if( empty($pcsid)){
						$schedprocessM->whereE( 'schid', $task->schid );
			$schedprocessM->delete();
			return false;
		}
		$pcsid='&pcsid=' . $pcsid;

		$urllink=JOOBI_SITE . WPage::completeURL( 'controller=scheduler&task=parallel&schid='. $task->schid. $pcsid . $password, true );

		if( !isset($schedulerClass)) $schedulerClass=WClass::get( 'scheduler.triggerurl' );
		$status=$schedulerClass->launch( $urllink, $this->_limitSeconds );

		if( $status){
				$this->_nbTaskssuccss++;
		}else{
		   	$this->_tasksfailed .=$task->viewname;
		}
 	}
}