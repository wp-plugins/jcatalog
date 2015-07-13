<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');





class Email_Queue_class extends WClasses {





	private $_queueToDeleteA=array();













	public function processQueue($report=false){

		




		
		$emailQueueM=WModel::get( 'email.queue' );


		$emailQueueM->where( 'senddate', '<', time());

		$emailQueueM->whereE( 'publish', 1 );

		$emailQueueM->whereE( 'status', 1 );

		$emailQueueM->orderBy( 'priority', 'ASC' );

		$emailQueueM->orderBy( 'senddate', 'ASC' );


		$max=WPref::load( 'PEMAIL_NODE_QUEUE_MAX_EMAIL' );

		if( $max < 1 ) $max=60;

		$emailQueueM->setLimit( $max );

		$allQueueA=$emailQueueM->load( 'ol' );



		if( empty( $allQueueA )){

			return $this->_finishedProcessingQueue();

		}




		
		WTools::increasePerformance();

		@ini_set( 'default_socket_timeout', 10 );

		@ignore_user_abort( true );



		$this->_queueToDeleteA=array();



		
		


		
		$mail=WMail::get();

		$emailQueueparamsO=WObject::get( 'email.queueparams' );

		foreach( $allQueueA as $oneQueue){



			if( !empty($oneQueue->params)){

		 		$emailQueueparamsO->setSQLParams( $oneQueue->params );

		 		$emailQueueparamsO->decodeQueue();

		 		$params=$emailQueueparamsO->getMailParams();

		 		$freqeuncyO=$emailQueueparamsO->getMailFrequency();

			 	if( !empty($params)) $mail->setParameters( $params );

			}


		 	$status=$mail->sendNow( $oneQueue->uid, $oneQueue->mgid, $report );



		 	if( $status){

			 	
			 	if( !empty($freqeuncyO)){

			 		$this->_manageFrequency( $oneQueue, $freqeuncyO );

			 	}else{

			 		
			 		$this->_queueToDeleteA[]=$oneQueue->qid;

			 	}


		 	}else{


		 	}




		}


		$this->_deleteQueue();



		return $this->_finishedProcessingQueue();



	}




















	private function _finishedProcessingQueue(){

		return true;

	}
















	private function _manageFrequency($oneQueue,$frequencyO){



		if( empty($frequencyO) || empty($oneQueue)) return false;



		if( !empty($frequencyO->period)){

			


			if( !empty($frequencyO->endDate)){



				if(( time() + $frequencyO->period ) > $frequencyO->endDate){

					$this->_queueToDeleteA[]=$oneQueue->qid;

					return false;

				}


			}


			
			$newSendDate=$oneQueue->senddate + $frequencyO->period;

			$emailQueueM=WModel::get( 'email.queue' );


			$emailQueueM->whereE( 'qid', $oneQueue->qid );

			$emailQueueM->setVal( 'senddate', $newSendDate );

			$emailQueueM->update();



		}


	}














	private function _deleteQueue(){



		if( empty( $this->_queueToDeleteA )) return false;



		$emailQueueM=WModel::get( 'email.queue' );

		$keep=WPref::load( 'PEMAIL_NODE_KEEP_EMAIL' );

		if( $keep){

			$emailQueueM->whereIn( 'qid', $this->_queueToDeleteA );

			$emailQueueM->setVal( 'status', 9 );

			$emailQueueM->update();

		}else{



			
			


	
			
			$emailQueueM->noValidate();

	
			return $emailQueueM->delete( $this->_queueToDeleteA );

		}


	}


}
