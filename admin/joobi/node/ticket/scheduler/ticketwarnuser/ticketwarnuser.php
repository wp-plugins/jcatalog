<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Ticket_Ticketwarnuser_scheduler extends Scheduler_Parent_class {










function process() {



	if (!defined('PTICKET_NODE_WARNDELAY') ) WPref::get('ticket.node');

	$delay = PTICKET_NODE_WARNDELAY;

	if ( !PTICKET_NODE_WARNDELAY ) return true; 					





	if ( WGlobals::checkCandy(50) && !empty( $delay ) ) {

		
		$delayClose = PTICKET_NODE_WARNDELAY * 86400;



		$ticketM = WModel::get('ticket');

		$ticketM->makeLJ( 'tickettrans');

		$ticketM->whereE( 'lgid', 1, 1 );

		$ticketM->select( array( 'name', 'description' ), 1 );

		$ticketM->whereIn('comment', array(10,15),0, true,0,0,0 );		
		$ticketM->whereE( 'status', '81' );					
		$ticketM->where( 'modified', '<', $this->getCurrentRun() - $delayClose );



		
	


		$ticketM->setLimit( 200 );

		$tickets = $ticketM->load( 'ol', array( 'tkid', 'status', 'authoruid', 'namekey' ) );


				$this->lastProcess = ( ( count($tickets) < 200 ) ? true : false );


		if ( !empty($tickets) ) {



			$mail = WMail::get();

			foreach( $tickets as $ticket ) {

				
				$params = new stdClass;

				$params->ticketid = '['.$ticket->namekey.']';

				$params->delaywarning = PTICKET_NODE_WARNDELAY;

				$params->closein = PTICKET_NODE_CLOSEDELAY - PTICKET_NODE_WARNDELAY;

				$params->title = $ticket->name;

				$params->description = $ticket->description;



				$linkV = WPage::routeURL('controller=ticket-reply&task=listing&tkid='.$ticket->tkid,'home',false, false, true,'jtickets');

				$params->link = '<a href="'.$linkV.'">' . WText::t('1389884098SHJK') . '</a>';



				$linkC = WPage::routeURL('controller=ticket-reply&task=close&tkid='.$ticket->tkid,'home',false, false, true,'jtickets');

				$params->linkclose = '<a href="'.$linkC.'">Click here to automatic close the ticket</a>';



				
				$mail->setParameters( $params );

				$mail->keepAlive();

				if (!defined('PTICKET_NODE_AUTOREPLY')) WPref::get('ticket.node');

				if (PTICKET_NODE_AUTOREPLY) {						
					$senderName = PTICKET_NODE_TKESENDER;				
					$senderEmail = PTICKET_NODE_TKESENDEREMAIL;			
					$bounceEmail = PTICKET_NODE_TKEBOUNCE;				
				}
				if (PTICKET_NODE_AUTOREPLY) {


					$mail->replyTo( $bounceEmail, 'Bounce Email', false );			
				}
				if (!empty($ticket->authoruid)) $mail->sendNow( $ticket->authoruid, 'ticket_user_warning', true );



			}
		}
	}




	return true;





}}