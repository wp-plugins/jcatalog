<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Latereply_scheduler extends Scheduler_Parent_class {








function process() {



	$notify = WPref::load( 'PTICKET_NODE_LATEREPLYNOTIFY' );



	if ( !$notify ) return true;

	$delay = WPref::load( 'PTICKET_NODE_LATEREPLYDELAY' );



	










	if ( !empty( $delay ) ) {


		$delayCheck = $delay * 3600;



		$ticketM = WModel::get( 'ticket' );

		$ticketM->whereE( 'latereply', 0 );
		$ticketM->where( 'status', '>=', 20 );

		$ticketM->where( 'status', '<=', 50 );
		$ticketM->where( 'modified', '<', $this->getCurrentRun() - $delayCheck );

		$ticketM->whereIn('comment', array(10,15), 0, true, 0, 0, 0 );

		$ticketM->setLimit( 50 );			$ticketM->orderBy( 'modified', 'ASC' );

		$lateTicketsA = $ticketM->load( 'ol', array( 'tkid', 'namekey', 'status', 'created', 'authoruid', 'modified') );


				$this->lastProcess = ( ( count($lateTicketsA) < 50 ) ? true : false );


		if ( !empty($lateTicketsA) ) {



			$tickets2Colose = array();

			foreach( $lateTicketsA as $ticket ) {

				$linkA = WPage::routeURL( 'controller=ticket-reply&task=listing&tkid=' . $ticket->tkid, 'home', false, false, true, 'jtickets' );

				$mail = WMail::get();
				$params = new stdClass;
				$params->link2Ticket = '<a href="' . $linkA . '">' . WText::t('1389884098SHJK') . '</a>';
				$params->ticketid = $ticket->namekey;
				$params->link = $params->link2Ticket;	
				$mail->setParameters( $params );
				$mail->keepAlive();
				$mail->sendNow( $ticket->authoruid, 'ticket_latereply', true );


				$tickets2Colose[] = $ticket->tkid;


			}

			
			$ticketM->whereIn( 'tkid', $tickets2Colose );

			$ticketM->setVal( 'latereply', 1 );

			$ticketM->update();

		}

	}


	return true;





}}