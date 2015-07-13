<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Reply_model extends WModel {





private $_noSendingEmail = false;


private $_userSignature = '';





















function validate() {





	if ( empty($this->tkid) ) {

		$message= WMessage::get();

		$message->userW('1330529258DZNE');

		return false;

	}


	
	$ticketBadWordsC = WClass::get( 'ticket.badwords' );



	$descriptionTrans = $this->getChild( $this->getModelNamekey() . 'trans' , 'description' );
	$badWordsFound = $ticketBadWordsC->checkWords( $descriptionTrans );
	if ( !empty($badWordsFound) ) {
				$this->publish = 0;
	} else {
				$ticketBadWordsC->replaceExternalLinks( $descriptionTrans );
	}
			if ( $this->_new ) {
		$this->_getSignature();
	}

	$this->setChild( $this->getModelNamekey() . 'trans' , 'description', $descriptionTrans . $this->_userSignature );



	$this->_support = false ;		
	$description = $this->getChild( 'ticket.replytrans', 'description' ); 
	if ( empty($description) ) {

		
		

		$this->skipMessage();

		return false;

	}


	$strlen = strlen( $description );



	
	
	if ( $strlen > 6 ) {



		$this->setChild('ticket.replytrans', 'lgid', 1 ); 
		
		if ( !isset($this->authoruid) || empty($this->authoruid) ) {

			$this->authoruid  = WUser::get('uid');

		}


		
		
		$this->_ticketM = WModel::get('ticket');

		$this->_ticketM->whereE('tkid',$this->tkid);

		$this->_tickerObj = $this->_ticketM->load('o', array('modified', 'authoruid', 'resptime', 'assignuid', 'pjid','namekey','priority','tktypeid', 'assignbyuid', 'followup') ); 


		$this->timeresp = time() - $this->_tickerObj->modified;

		$this->returnId();



		
		$this->_namekey=$this->_tickerObj->namekey;	
		$this->_pjid=$this->_tickerObj ->pjid;		


		
		$recordIP = WPref::load( 'PTICKET_NODE_TKIP' );
		if ( $recordIP && empty($this->ip) ) {				$this->ip = WUser::get( 'ip' );
		}



		if (WGlobals::checkCandy(25) && empty($this->comment)) {		
			if (isset($this->x['status']) || !empty($this->x['status'])) {

			$this->_status = $this->x['status'];			
		}


		if (  WGlobals::checkCandy(50)  && !defined('PTICKET_NODE_TIMING') ) {

			WPref::get('ticket.node');



			$startwritingreply = WGlobals::getSession( 'tickets', 'startwritingreply' );

			$this->timing = time() - $startwritingreply;

			$this->charcount = $strlen;

			$this->wordcount = str_word_count( $description );

		}


		
		
		if ( $this->_tickerObj->authoruid != $this->authoruid ) {

			$this->_support=true;

		}


		} else {				
			$this->_support=false;

		}


	} else {

		
		$message= WMessage::get();

		$message->userW('1330529258DZNF');

		return false;

	}


		if ( WExtension::exist( 'subscription.node' ) ) {
		$subscriptionCheckC = WObject::get( 'subscription.check' );
		$subscriptionO = $subscriptionCheckC->restriction( 'ticket_maxnumber_responses' );
		if ( !$subscriptionCheckC->getStatus() ) {
			return false;
		}	}

	return true;



}


public function setSendEmail($status=true) {

	$this->_noSendingEmail = $status;

}




















function addExtra() {





	if ( $this->_noSendingEmail ) return true;



	$description = $this->getChild( 'ticket.replytrans', 'description' ); 			


	$tickettransM = WModel::get('tickettrans');

	$tickettransM->whereE( 'tkid', $this->tkid );

	$tickettransM->whereE( 'lgid', 1 );

	$title = $tickettransM->load( 'lr', 'name' );



	$ticketM = WModel::get('ticket');

	$ticketM->whereE('tkid',$this->tkid);

	$ticketM->setVal('lock',0);							
	$ticketM->setVal('read',0);

	if ($this->_tickerObj->followup) $ticketM->setVal('followup',0);			
	$ticketM->setVal( 'modified', time() );						


	if ( $this->_tickerObj->authoruid != $this->authoruid ) {

		
		$ticketM->setVal( 'assignuid', $this->authoruid );

		$ticketM->setVal( 'deadline', 4200000003 );

		$ticketM->setVal( 'status', 81 );	
	} else {

		$this->_support=false;

		
		$ticketM->setVal( 'status', 20 );

		
		if ( WGlobals::checkCandy(50) ) {

			switch ( $this->_tickerObj->resptime ) {

				case 10:

					$plus=PTICKET_NODE_TKRTFREE;

					break;

				case 20:

					$plus=PTICKET_NODE_TKRTWITHOUT;

					break;

				case 30:

					$plus=PTICKET_NODE_TKRTWITH;

					break;

			}
			$deadline = time() + $plus * 3600;

			$ticketM->setVal( 'deadline', $deadline );

		}
	}
	if (!empty($this->_status)) {					
		$ticketM->setVal( 'status', $this->_status );

	}


 	$tkid = $this->tkid;

	$ticketM->whereE('tkid',$tkid);



	
	$ticketM->setVal( 'replies', $this->_ticketM->setCalcul(1,'+','replies',null,0) );

	$ticketM->update();



	if ( WGlobals::checkCandy(50) && WPref::load( 'PTICKET_NODE_TKTRANS' ) ) {



		$user = WUser::get('lgid', $this->authoruid );

		$lgid = $user->lgid;



		








	} else {



	}


	
	if ( WGlobals::checkCandy(25) && ( WPref::load( 'PTICKET_NODE_TKEMAILREPLY' ) || WPref::load( 'PTICKET_NODE_TKEMAILASSIGN' ) ) ) {



		
		$tkprojectM=WModel::get('ticket.project');

		
		$tkprojectM->whereE('pjid',$this->_tickerObj->pjid);

		$notify = $tkprojectM->load('o',array('onreplies','toassigned','sendcopy'));



		$tkMail = WClass::get('ticket.mail');

		
		if (PTICKET_NODE_TKEMAILCOPY && $notify->sendcopy) {	
				$copyEmail = WMail::get();

				$params = new stdClass;

				
				$params->name = $description;

				$params->ticketid = $this->_tickerObj->namekey;

				$params->description = $description;

				$copyEmail->setParameters($params);

				$email=WUser::get('email', $this->authoruid);

				$copyEmail->sendNow($email,'duplicate_ticket_reply');

		}


		if ( $this->_tickerObj->authoruid != $this->authoruid ) {			
			
			if ( (!defined('PTICKET_NODE_TKEMAILREPLY')) ) WPref::get('ticket.node');

			if ( (PTICKET_NODE_TKEMAILREPLY)) {



				
				if ($notify->onreplies) {

					if (!empty($this->_tickerObj->authoruid)) {

						$this->_tickerObj->description = $description;

						$this->_tickerObj->tkid = $this->tkid;

						$this->_tickerObj->tkrid = $this->tkrid;

						$tkMail->alertTicketAuthor( $this->_tickerObj, 'reply_ticket_author' );		
					}
				}


			}


		} else {						
			
			if ($notify->toassigned) {

				$assignuid = null;

				
				$ticketMembersM = WModel::get('ticket.projectmembers');

				if (!empty($this->_tickerObj->assignbyuid)) $assignuid = $this->_tickerObj->assignbyuid;

				$ticketMembersM->whereIn('uid',array($this->_tickerObj->assignuid,$assignuid));

				$ticketMembersM->whereE('pjid',$this->_tickerObj->pjid);

			
				$notifyAssigned = $ticketMembersM->load('ol',array('notify', 'uid'));



				$this->_tickerObj->description = $description;

				$this->_tickerObj->tkid = $this->tkid;

				$this->_tickerObj->tkrid = $this->tkrid;

				$this->_tickerObj->title = $title;



				
				
				if (!empty($this->_tickerObj->assignuid)) {

					if (!empty( $notifyAssigned ) && $notifyAssigned[0]->notify) {

						$this->_tickerObj->assignuid = $notifyAssigned[0]->uid;

						$tkMail->alterProjectAssignedPersons( $this->_tickerObj, 'reply_ticket_assign' );	
					}


					
					if (isset($notifyAssigned[1])) {

						if (!defined('PTICKET_NODE_NOTIFYMODERATOR')) WPref::get('ticket.node');

						if (PTICKET_NODE_NOTIFYMODERATOR && $this->_tickerObj->assignuid != $assignuid && $notifyAssigned[1]->notify) {

							$this->_tickerObj->assignbyuid = $notifyAssigned[1]->uid;


						}
					}
				}


			}
		}
	}

	
	$this->_ticketM->whereE('tkid',$tkid);

	$pjid=$this->_ticketM->load('lr','pjid');



	$ticketProjectM=WModel::get('ticket.project');

	$ticketProjectM->whereE('pjid',$pjid);

	$ticketProjectM->setVal('ltkid',$tkid);

	$ticketProjectM->update();		
	$message = WMessage::get();

	$ID = $this->_tickerObj->namekey;

	$message->userN('1253277991HEPH',array('$ID'=>$ID));


		if ( WRoles::isNotAdmin( 'agent' ) ) {
		$ticketQueueC = WClass::get( 'ticket.queue' );
		$ticketQueueC->getMyPosition( $tkid );
	}

	return true;



}















function deleteValidate($eid=0) {



	
	$tkrid=WGlobals::get('eid');



	$ticketReplyM = WModel::get('ticket.reply');

	$ticketReplyM->whereE('tkrid',$tkrid);

	$tkreply= $ticketReplyM->load('o',array('comment','tkid'));



	
	if (empty($tkreply->comment)) {					


		$ticketM=WModel::get('ticket');

		$ticketM->whereE('tkid',$tkreply->tkid);

		$replies=$ticketM->load('lr','replies');

		$ticketM->whereE('tkid',$tkreply->tkid);



		
		$ticketM->setVal('replies', --$replies);

		$ticketM->update();

	}

	return true;


}







private function _getSignature() {

	$signature = WPref::load( 'PTICKET_NODE_SIGNATUREMODERATOR' );
	if ( $signature || WRoles::isAdmin( 'agent' ) ) {
				$ticketSignatureC = WClass::get( 'ticket.signature' );
		$this->_userSignature = $ticketSignatureC->getUserSginature( WUser::get( 'uid' ) );
		if ( !empty($this->_userSignature) ) $this->_userSignature = "<br />" . $this->_userSignature;
	}
	return true;

}

}