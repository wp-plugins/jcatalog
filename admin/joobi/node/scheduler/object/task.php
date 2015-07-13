<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_Task_object {







 	 function process($schid,$password='',$pcsid=''){

 	 	$nbTaskLaunched=0;
 	 	$status=true;

 	 	if( false !==$password){
			$decodepass=base64_decode($password);

			if( !defined('PSCHEDULER_NODE_PASSWORD')) WPref::get( 'scheduler.node' );
						$usePwd=PSCHEDULER_NODE_USEPWD;
	 	 	if( $usePwd && empty($decodepass) || ( $decodepass !=PSCHEDULER_NODE_PASSWORD )){
	 	 		return false;
	 	 	}
	 	 	$useProcesses=true;

 	 	}else{

 	 		 	 		static $alreadyDoneSchedulerA=array();

 	 		if( isset($alreadyDoneSchedulerA[$schid])) return true;
 	 		else $alreadyDoneSchedulerA[$schid]=true;

 	 		$useProcesses=false;
 	 	}
 	 	if( !empty($schid)){

 	 		$schedulerM=WModel::get('scheduler');
 	 		$schedulerM->makeLJ('apps','wid');
			$schedulerM->select('namekey',1);
 	 		$schedulerM->whereE('schid',$schid);
 	 		$task=$schedulerM->load( 'o', array('schid','wid','maxtime','maxprocess','lastdate','frequency','nextdate','ptype','cron','params','viewname', 'namekey'));

 	 		if( !empty($task)){

	 							WLoadFile( 'scheduler.class.parent');

								$time=time();
               	if( !empty($task->maxtime)) $maxseconds=($task->maxtime - 5);
               	elseif( !empty($task->frequency)) $maxseconds=($task->frequency - 5);
               	else {	               		$maxseconds=50;
               	}
				$maxtime=$time + $maxseconds;
				$task->maxtime=$maxtime;
				$task->time=$time;
				$nextDateMemory=0;

				if( $useProcesses){
										$schedprocessM=WModel::get( 'scheduler.processes' );
					$schedprocessM->select('pcsid', 0 , null, 'count');
					$schedprocessM->whereE( 'schid', $task->schid );
					$countpcsid=$schedprocessM->load('lr');
				}
				if( !$useProcesses || $countpcsid <=$task->maxprocess){

					$pos=strrpos( $task->namekey, '.' );
					$ADDON=substr( $task->namekey, 0, $pos );
					$chedulerAddonC=WAddon::get( $ADDON, null, 'scheduler' );
					if( !method_exists( $chedulerAddonC, 'process' )){
						$message=WMessage::get();
						$reportMsg='<br/><span="color:red">'.str_replace(array('$ADDON'), array($ADDON),WText::t('1232547382ELZS')).'</span>';
						$message->codeE('Can not load the scheduler '.$ADDON);
						return false;
					}
															WPref::get( $task->wid );
					$averagePRocessTime=0;
					while( time() <=$maxtime - $averagePRocessTime){
						$startRunTaskTime=time();
						switch ($task->ptype){
							case 2 : 								$cronparser=WClass::get('scheduler.cronparser');
								$cronparser->lastRun=$task->nextdate;
								if($cronparser->checkCron($task->cron,false)){									$task->nextdate=$cronparser->calcNextRun($task->cron);
									$cronparser->lastRun=$startRunTaskTime;
									$normalNextRun=$cronparser->calcNextRun($task->cron);
									if($task->nextdate<$startRunTaskTime || $task->nextdate>$normalNextRun){
										$task->nextdate=$normalNextRun;
									}								}else{
																		$task->nextdate=$startRunTaskTime+18000;
								}								break;

							case 3 : 								$scheduler->setVal( 'publish', 0 );
								$task->nextdate=0;
								break;

							default :
								$task->nextdate=$task->nextdate + $task->frequency;
								if($task->nextdate < $startRunTaskTime || $task->nextdate > $startRunTaskTime + $task->frequency){ $task->nextdate=$startRunTaskTime + $task->frequency; }
								break;
						}
												if( !empty( $task->nextdate )){
							$schedulerM->setVal('nextdate',$task->nextdate );
							$schedulerM->setVal('lastdate',time());
							$schedulerM->whereE('schid',$task->schid);
							$schedulerM->setLimit(1);
							$schedulerM->update();
							$nextDateMemory=$task->nextdate;
						}
						$chedulerAddonC->setTask($task);
						$chedulerAddonC->params=$task->params;
						WTools::getParams( $chedulerAddonC, 'params' );

																		$status=$chedulerAddonC->process();
						$nbTaskLaunched++;
												if( !$status ) break;

												if( $chedulerAddonC->lastProcess()) break;

												$averagePRocessTime=time() - $startRunTaskTime;

					}
										if( empty($nextDateMemory) || $nextDateMemory !=$task->nextdate){
												if( !empty( $task->nextdate )) $schedulerM->setVal('nextdate',$task->nextdate);
						$schedulerM->setVal( 'lastdate', time());
							$schedulerM->whereE( 'schid' , $task->schid );
						$schedulerM->setLimit(1);
						$schedulerM->update();
					}
				}else{

										$nbTaskLaunched=0; 				}
 	 		}
 	 	}
		if( !empty($pcsid)){
						if( !isset($schedprocessM)) $schedprocessM=WModel::get( 'scheduler.processes' );
			$schedprocessM->whereE('pcsid', $pcsid );
			$schedprocessM->delete();
		}
 	 	return ( $status ? $nbTaskLaunched : $status );

 	 }
}