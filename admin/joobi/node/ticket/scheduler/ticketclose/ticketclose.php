<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Ticketclose_scheduler extends Scheduler_Parent_class {








function process() {



	if (!defined('PTICKET_NODE_CLOSEDELAY') ) WPref::get('ticket.node');

	
	$delay = PTICKET_NODE_CLOSEDELAY;					


	if ( !PTICKET_NODE_CLOSEDELAY ) return true; 				


	









	if ( WGlobals::checkCandy(50) && !empty( $delay ) ) {

		$delayClose = PTICKET_NODE_CLOSEDELAY * 86400;			


		$ticketM = WModel::get('ticket');

		$ticketM->whereE( 'status', '81' );				
		$ticketM->where( 'modified', '<', $this->getCurrentRun() - $delayClose );

		$ticketM->whereIn('comment', array(10,15),0, true,0,0,0 );

		$ticketM->setLimit( 200 );

		$tickets = $ticketM->load( 'ol', array( 'tkid', 'namekey', 'status', 'created', 'authoruid', 'modified') );


				$this->lastProcess = ( ( count($tickets) < 200 ) ? true : false );


		if ( !empty($tickets) ) {



			$tickets2Colose = array();

			$allTicketID = array();

			$TicketT = WText::t('1206964391FHVU');

			$linkT = WText::t('1206961869IGNO');

			
			foreach( $tickets as $ticket ) {

				if ( PTICKET_NODE_NOTIFYCLOSE ) {

					$addT = $TicketT . ': ' . $ticket->namekey . '<br />';

					$linkA = WPage::routeURL('controller=ticket-reply&task=listing&tkid='.$ticket->tkid, 'home',false,false, true,'jtickets' );

					$addT .= $linkT . ': <br /><a href="'.$linkA.'">' . WText::t('1389884098SHJK') . '</a><br /><br />';

					if ( !empty($ticket->authoruid) ) {

						$allTicketID[$ticket->authoruid] = $addT;

					}
				}


				$tickets2Colose[] = $ticket->tkid;



			}


			
			$ticketM->whereIn( 'tkid', $tickets2Colose );

			$ticketM->setVal( 'status', 125 );

			$ticketM->update();



			
			if ( PTICKET_NODE_NOTIFYCLOSE ) {

				$mail = WMail::get();

				foreach( $allTicketID as $authorID => $IDs ) {

					$params = new stdClass;

					$params->ticketids = $IDs;

					$params->message =null;

					
					if ( WPref::load( 'PTICKET_NODE_TKRATINGUSE' ) ) {

						$params->message = 'Would you mind to rate our support if you consider this issue solved?';

					}
					
					$mail->setParameters( $params );

					$mail->keepAlive();

					if (!defined('PTICKET_NODE_AUTOREPLY')) WPref::get('ticket.node');

					if (PTICKET_NODE_AUTOREPLY) {			
						$senderName = PTICKET_NODE_TKESENDER;		
						$senderEmail = PTICKET_NODE_TKESENDEREMAIL;	
						$bounceEmail = PTICKET_NODE_TKEBOUNCE;		



						$mail->replyTo( $bounceEmail, 'Bounce Email', false );			
					}
					if (!empty($authorID))$mail->sendNow( $authorID, 'ticket_auto_close', true );

				}
			}


		}
	}


	return true;





}}