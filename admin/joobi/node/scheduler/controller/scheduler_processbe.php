<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_processbe_controller extends WController {




	function processbe(){

		$schedulerTasksO=WObject::get( 'scheduler.task' );
		$eid=WGlobals::getEID();

		if( WRoles::isNotAdmin() || empty($eid)) return false;

		$keypass=WPref::load( 'PSCHEDULER_NODE_PASSWORD' );

				$schedprocessM=WModel::get('scheduler.processes');
		$schedprocessM->setval('schid', $eid );
		$schedprocessM->setval('created', time());
		$schedprocessM->insert();

		$pcsid=$schedprocessM->lastID();

		$nbResults=$schedulerTasksO->process( $eid, base64_encode( $keypass ), $pcsid );

		$message=WMessage::get();
		if( !empty($nbResults)){
			$message->userS('1298294163YKW',array('$nbResults'=>$nbResults));
		}else{
			if( $nbResults===false ) $message->userE('1300773865DUMM');
			$message->userN('1298294164ESOK');
		}
		return true;

	}
}