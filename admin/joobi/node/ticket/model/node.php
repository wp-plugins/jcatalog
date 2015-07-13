<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Node_model extends WModel {




















function addValidate() {




	if ( WPref::load( 'PTICKET_NODE_TKTYPE' ) && empty($this->tktypeid) ) {

		$message= WMessage::get();

		$message->historyE('1230530175HBUQ');

	}


	$uidLogged = WUser::get('uid');	
	$trucs = WGlobals::get('trucs');

	$ticketModelID = WModel::getID('ticket');



	if ( empty($this->authoruid) ) {


		$uid = $uidLogged;

		
		
		if ( !empty($uid) ) {			
			$this->authoruid = $uid;

		} else {

			











			if ( ! WUser::isRegistered() && !empty($trucs['x']['email']) ) { 
				







				$xTrucs = $trucs['x'];

				$userInfo = null;

				$username = $xTrucs['name'];

				$email = $xTrucs['email'];

				$ticketMembersM = WModel::get('users');

	
	
				$ticketMembersM->whereE('email', $email );

				$userInfo = $ticketMembersM->load('o', array('uid', 'username', 'email'));



				if (empty($userInfo)) {

					$message = WMessage::get();

					$message->historyE('1298350701PQGH');

					return false;



	
	
	
	
	
	
	
	
	


	
	
	
				}
				$this->authoruid = $authoruid;

			} else {

				$this->authoruid = $uidLogged;

				
				


			}


		}


	}




	
	$recordIP = WPref::load( 'PTICKET_NODE_TKIP' );

	if ( $recordIP && empty($this->ip) && $this->tktypeid != 50 ) {

		$this->ip = WUser::get( 'ip' );

	}




	
	if ( !empty($this->pjid) && !isset($this->assignuid) ) {

		if ( WGlobals::checkCandy(50) ) {

			$ticketProjectMemberM = WModel::get( 'ticket.projectmembers' );

			
			$ticketProjectMemberM->orderBy('supportlevel' );

			$ticketProjectMemberM->whereE( 'pjid', $this->pjid );

			$this->assignuid = $ticketProjectMemberM->load('lr', 'uid');



			
			if ( empty($this->assignuid) ) {

				$ticketProjectM = WModel::get( 'ticket.project' );

				
				$ticketProjectM->whereE('pjid', $this->pjid );

				$this->assignuid = $ticketProjectM->load('lr', 'uid' );

			}
		} else {	
			$ticketProjectM = WModel::get( 'ticket.project' );

			
			$ticketProjectM->whereE('pjid', $this->pjid );

			$this->assignuid = $ticketProjectM->load('lr', 'uid' );

		}
	}


	$this->generateKey( $this->authoruid );

	$this->namekey = strtoupper( $this->namekey );



	
	$useProject = WPref::load( 'PTICKET_NODE_TKUSEPROJECT' );



	if ( $useProject || empty($this->pjid) ) {

				$maincategoryO = WModel::getElementData( 'ticket.project', 'maincategory' );
		$this->pjid = $maincategoryO->pjid;

		if ( empty( $this->pjid) ) $this->pjid = 2;

		$this->assignuid = 0;



	}


	





































































	$exists = WExtension::exist( 'license.node' );

	if ( !empty( $this->stid ) && $exists ) {

		$ticketPlanC = WClass::get( 'license.plan' );

		$this->lcid = $ticketPlanC->getPriorityBasedOnPlan( $this->stid, $this->priority );

	}


		if ( WExtension::exist( 'subscription.node' ) ) {
		$subscriptionCheckC = WObject::get( 'subscription.check' );
		$subscriptionO = $subscriptionCheckC->restriction( 'ticket_maxnumber' );
		if ( !$subscriptionCheckC->getStatus() ) {
			return false;
		}	}

		if ( !isset($this->private) ) {
		$this->private = WPref::load( 'PTICKET_NODE_TKPRIVATE' );		}

		if ( empty($this->status) ) {
		$this->status = 20;					}

		if ( empty($this->type)) {
		$this->tktypeid = 110;					}

		if ( empty($this->priority) ) {
		$this->priority = 10;			}
	return true;



}









function validate() {



	
	$ticketBadWordsC = WClass::get( 'ticket.badwords' );

	$nameTrans = $this->getChild( $this->getModelNamekey() . 'trans' , 'name' );

	$badWordsFound = $ticketBadWordsC->checkWords( $nameTrans );

	$this->setChild( $this->getModelNamekey() . 'trans' , 'name', $nameTrans );

	if ( !empty($badWordsFound) ) {

		
		$this->publish = 0;

	} else {

		$descriptionTrans = $this->getChild( $this->getModelNamekey() . 'trans' , 'description' );

		$badWordsFound = $ticketBadWordsC->checkWords( $descriptionTrans );

		if ( !empty($badWordsFound) ) {

			
			$this->publish = 0;

		} else {

			
			$ticketBadWordsC->replaceExternalLinks( $descriptionTrans );

		}


		$this->setChild( $this->getModelNamekey() . 'trans' , 'description', $descriptionTrans );



	}




	
	if ( WGlobals::checkCandy(50) ) {

		$this->_level = true;



	}


	return true;



}




















function addExtra() {



	
	$message= WMessage::get();

	$ticketID = $this->namekey;

	$message->userN('1230530175HBUR',array('$ticketID'=>$ticketID));



	
	if ( WGlobals::checkCandy(25) ) {




		$this->title = $this->getChild('tickettrans','name'); 
		$this->description = $this->getChild('tickettrans','description'); 


		
		static $tkprojectM = null;

		static $notifyC = null;


		if ( !isset($tkprojectM) ) {

			$tkprojectM = WModel::get( 'ticket.project' );

			$tkprojectM->whereE( 'pjid', $this->pjid );

			$notifyC = $tkprojectM->load( 'o', array( 'oncreation', 'toassigned', 'sendcopy' ) );

		} else {
			$notifyC = new stdClass;
			$notifyC->oncreation = false;
		}


		
		if ( WPref::load( 'PTICKET_NODE_TKEMAILCONF' ) ) {

			if ( !empty($notifyC->oncreation) ) {					
				$tkMail=WClass::get('ticket.mail');

				$tkMail->alertTicketAuthor( $this, 'new_ticket_author' );

			}


		}


		
		if ( WPref::load( 'PTICKET_NODE_TKEMAILASSIGN' ) ) {



			if ( !empty($notifyC->toassigned) ) {



				if ( WGlobals::checkCandy(50) ) {			
					
					static $ticketMembersM = null;

					static $notifyM = null;



					if (!isset($ticketMembersM)) {

						$ticketMembersM = WModel::get('ticket.projectmembers');

						$ticketMembersM->whereE('uid',$this->assignuid);

						$ticketMembersM->whereE('pjid',$this->pjid);

						$notifyM = $ticketMembersM->load('lr','notify');

					}


					
					if ( $notifyM ) {

						$tkMail=WClass::get('ticket.mail');

						$tkMail->alterProjectAssignedPersons( $this, 'new_ticket_assign' );

					}
				} else {							
					$tkMail->alterProjectAssignedPersons( $this, 'new_ticket_assign' );

				}


			}


		}




		$pjid=$this->pjid;

		$this->_getLatestTicket($pjid);	


		
		$ticketProjectM = WModel::get( 'ticket.project' );

		
		$ticketProjectM->whereE( 'pjid', $pjid );

		$ticketProjectM->setVal( 'tickets', $ticketProjectM->setCalcul( 1,'+', 'tickets' , null, 0) );

		$ticketProjectM->update();

	}




	
	if ( WRoles::isNotAdmin( 'agent' ) ) {

		$ticketQueueC = WClass::get( 'ticket.queue' );

		$ticketQueueC->getMyPosition( $this->tkid );

	}


	return true;



}












function editExtra() {

	if ( WGlobals::checkCandy(50) ) {

		$pjid = $this->pjid;

		$this->_getLatestTicket( $pjid );

	}
	return true;

}












	public function getPossibleTypes() {



		$allFields = WPref::load( 'PDESIGN_NODE_FIELDALLTYPE' );





		$productTypeM = WModel::get( 'ticket.type' );

		$productTypeM->makeLJ( 'ticket.typetrans' );

		$productTypeM->whereLanguage();

		$productTypeM->select( 'name', 1 );


		if ( !$allFields ) {

			
			$namekey = $this->getModelNamekey();



			$productTypeT = WType::get('ticket.designation');

			$designation = $productTypeT->getValue( $namekey, false );



			$productTypeM->whereE( 'type', $designation );



		}


		$productTypeM->whereE( 'publish', 1 );


		$resultA = $productTypeM->load( 'ol', 'tktypeid' );


		$count = count( $resultA );

		if ( $count < 2 ) return false;



		$typeA = array();

		foreach( $resultA as $oneType ) {

			$typeA[$oneType->tktypeid] = $oneType->name;

		}


		return $typeA;

	}












	public function getItemTypeColumn() {

		return 'tktypeid';

	}
















private function _getLatestTicket($pjid) {


	$tkid=$this->tkid;



	$ticketM=WModel::get('ticket');

	
	$ticketM->select('private');

	$ticketM->whereE('tkid',$tkid);

	$private=$ticketM->load('lr','private');


		if ( !$private ) {

			$ticketProjectM=WModel::get('ticket.project');

		
			$ticketProjectM->whereE('pjid',$pjid);

			$ticketProjectM->setVal('ltkid',$tkid);

			$ticketProjectM->update();

		}

	return true;


}


























































function generateKey($uid=null) {



	$time = time() - 1229873219;

	if ( !isset($uid) ) $uid = WUser::get('uid');

	$string = strtolower( base_convert( ( $time ),10,36) .'-'. base_convert( ( $uid ),10,36) );



	$this->namekey = $string;

	return;



}}