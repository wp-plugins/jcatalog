<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Mail_class extends WClasses {












public function alterProjectAssignedPersons($ticket,$emailName) {


	if ( PTICKET_NODE_TKEMAILASSIGN ) {	

		
		if ( empty($ticket->assignuid) ) return true;


		$assUID=$ticket->assignuid;


		$mail = WMail::get();

		$params = new stdClass;

		$params->ticketid =  '['.$ticket->namekey.']';

		if ( isset($ticket->priority) ) {		
			$priority =  $ticket->priority;



			





			$picklist = WClass::get('ticket.picklist');

			$params->priority = $picklist->getName('ticket-priority',$ticket->priority); 


		}


		if ( isset($ticket->title) ) $params->title =  $ticket->title;

		$params->description =  $ticket->description;



		
		static $ticketProjectM = null;

		static $categoryName = null;

		if ( isset($ticket->pjid) && !empty($ticket->pjid) ) {

			if (!isset($ticketProjectM))	$ticketProjectM = WModel::get( 'ticket.projecttrans' );

			$ticketProjectM->whereE( 'pjid', $ticket->pjid );

			$ticketProjectM->whereE( 'lgid', 1 );

			if (!isset($categoryName))	$categoryName = $ticketProjectM->load('lr', 'name');

		}

		$params->category = $categoryName;

		
		$extraLink = ( isset($ticket->tkrid) ) ? '#'.$ticket->tkrid : '';



		if (!empty($ticket->type) ) $type = $ticket->type;
		else $type=0;



		
		if ( !empty($assUID) ) {

			$emailallassigned = WPref::load( 'PTICKET_NODE_EMAILALLASSIGNED' );

			if ( $emailallassigned ) {

								$ticketReplyM = WModel::get( 'ticket.reply' );
				$ticketReplyM->whereE( 'tkid', $ticket->tkid );
				$ticketReplyM->groupBy( 'authoruid' );
				$authoruidA = $ticketReplyM->load( 'ol', array( 'authoruid' ) );

				if ( !empty($authoruidA) ) {
					$haveAssigned = false;
					foreach( $authoruidA as $oneReply ) {
						if ( $oneReply->authoruid == $ticket->authoruid ) continue;
						if ( $oneReply->authoruid == $assUID ) $haveAssigned = true;
						$this->_sendNotification2Admin( $ticket, $params, $type, $extraLink, $emailName, $oneReply->authoruid );

					}
					if ( !$haveAssigned ) {
						$this->_sendNotification2Admin( $ticket, $params, $type, $extraLink, $emailName, $assUID );
					}
				} else {
										$this->_sendNotification2Admin( $ticket, $params, $type, $extraLink, $emailName, $assUID );
				}
			} else {
				$this->_sendNotification2Admin( $ticket, $params, $type, $extraLink, $emailName, $assUID );
			}
		} else {



			$linkA = WPage::routeURL( 'controller=ticket-reply&tkid='.$ticket->tkid.'&priority='.$priority.'&type='.$type.$extraLink , 'home' );

			$params->link = '<a href="'.$linkA.'">' . WText::t('1389884098SHJK') . '</a>';

			$mail->setParameters( $params );

			$mail->sendAdmin( 'ticket_no_assigned_person' );


		}

	}

	return true;


}












	private function _sendNotification2Admin($ticket,$params,$type,$extraLink,$emailName,$assUID) {

				$priority = $ticket->priority;
				WPref::get( 'ticket.node' );
		$allPref = PTICKET_NODE_TKLINK;

		$pageIndex = ( $allPref ) ? 'admin' : 'home';

		$linkA = WPage::routeURL( 'controller=ticket-reply&tkid='.$ticket->tkid.'&priority='.$priority.'&type='.$type. $extraLink , $pageIndex );
		$params->link = '<a href="'.$linkA.'">' . WText::t('1389884098SHJK') . '</a>';

		$mail = WMail::get();
		$mail->setParameters( $params );
		



		if (PTICKET_NODE_AUTOREPLY) {
			$bounceEmail = PTICKET_NODE_TKEBOUNCE;							$mail->replyTo( $bounceEmail, 'Bounce Email', false );				}
		$mail->sendNow( $assUID, $emailName, true );


	}











	function alertTicketAuthor($ticket,$emailName) {

	
	
		$assUID = $ticket->authoruid;



		
		$extralink = '';

		if ( PTICKET_NODE_NOREGISTERED ) {

			if ( !WUser::isRegistered($assUID)   ) {

				$dataM = WUser::get('data', $assUID );

				$extralink = '&guid=' . $dataM->activation;



			}
		}
		
		if ( !empty($assUID)  && PTICKET_NODE_TKEMAILCONF ) {

			$mail = WMail::get();

			
			$params = new stdClass;

			$params->ticketid =  '['.$ticket->namekey.']';					
			if ( isset($ticket->title) ) $params->title =  $ticket->title;			
			$params->description =  $ticket->description;					
			if (isset($ticket->tkrid)||!empty($ticket->tkrid)) {				
				$params->tkreplyid = $ticket->tkrid;					
			}
			$extraLink = ( isset($ticket->tkrid) ) ? '#'.$ticket->tkrid : '';

			$linkA = WPage::routeURL( 'controller=ticket-reply&tkid='.$ticket->tkid .$extralink, 'home' );



			$params->link = '<a href="'.$linkA.'">' . WText::t('1389884098SHJK') . '</a>';

			$mail->setParameters( $params );



			if (!defined('PTICKET_NODE_AUTOREPLY')) WPref::get('ticket.node');

			if (PTICKET_NODE_AUTOREPLY) {								
				$bounceEmail = PTICKET_NODE_TKEBOUNCE;						
				$mail->replyTo( $bounceEmail, 'Bounce Email', false );			
			}








			$mail->sendNow( $assUID, $emailName, true );



		}

		return true;


	}
}