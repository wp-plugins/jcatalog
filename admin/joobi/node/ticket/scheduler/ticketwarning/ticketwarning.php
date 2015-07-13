<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_Ticketwarning_scheduler extends Scheduler_Parent_class {




function process() {

	if ( WGlobals::checkCandy(50) && WPref::load( 'PTICKET_NODE_TKDELAY' ) != 0 ) {

		$delay = WPref::load( 'PTICKET_NODE_TKFREQUENCY' );
		$timeBegin = $this->getCurrentRun();
		$time = $this->getLastRun();

		
		$ticketM = WModel::get('ticket');
		$ticketM->makeLJ( 'tickettrans', 'tkid');
		$ticketM->select('name', 1);
		$ticketM->whereE('lgid', 1, 1 );
		$ticketM->whereIn('comment', array(10,15),0, true,0,0,0 );		
				$ticketM->whereE( 'status', '20', 0, null, 1, 0, 0 );					$ticketM->whereE( 'status', '50', 0, null, 0, 1, 1 );					$ticketM->where( 'assignuid', '!=', 0,0);								$ticketM->where('modified', '<', $timeBegin - $delay );


















		$ticketM->orderBy( 'assignuid' );
		$ticketM->setLimit( 200 );

		$tickets = $ticketM->load( 'ol', array( 'tkid', 'namekey', 'status', 'created', 'authoruid', 'modified', 'assignuid','tktypeid','priority' ) );

				$this->lastProcess = ( ( count($tickets) < 200 ) ? true : false );


		if ( !empty($tickets) ) {

			$uids = array();
						foreach( $tickets as $ticket ) {
				$uids[$ticket->assignuid] = true;
			}			$uids = array_keys($uids);

			$allPref = WPref::load( 'PTICKET_NODE_TKLINK' );
								$pageIndex = ( $allPref ) ? 'admin' : 'home';

			static $members = array();			
			$mail = WMail::get();
			$ctr = 0;
			foreach( $tickets as $ticket ) {

				if ( empty($ticket) || empty($ticket->namekey) ) continue;

								if ( empty($ticket->assignuid) ) continue;

												$timezone = WUser::timezone($ticket->assignuid);
				if ( $ticket->created == $ticket->modified ) $ticket->lastreply = 'no reply';
				else $ticket->lastreply=date( WTools::dateFormat( 'date' ), $ticket->modified + $timezone );
				




				if ( !isset( $members[$ticket->assignuid]) ) {
					$members[$ticket->assignuid] = WUser::get( 'data', $ticket->assignuid );
				}
				if (empty($members[$ticket->assignuid])) continue;

				$member = $members[$ticket->assignuid];
				$ctr++;

								if ($pageIndex == 'admin') {
					$linkA = WPage::routeURL('controller=ticket-reply&task=listing&tkid='.$ticket->tkid.'&tktypeid='.$ticket->tktypeid.'&priority='.$ticket->priority, $pageIndex ,false, false, true,'jtickets');
					$linkC = WPage::routeURL('controller=ticket-reply&task=close&tkid='.$ticket->tkid,'admin',false, false, true,'jtickets');
				} else {										$linkA = WPage::routeURL('controller=ticket-reply&task=listing&tkid='.$ticket->tkid.'&tktypeid='.$ticket->tktypeid.'&priority='.$ticket->priority, 'home' ,false, false, true,'jtickets');
					$linkC = WPage::routeURL('controller=ticket-reply&task=close&tkid='.$ticket->tkid,'home',false, false, true,'jtickets');
				}
				$params = new stdClass;
				$params->tkid = $ticket->tkid;
				$params->ticketid = $ticket->namekey;
				$params->created = WApplication::date( WTools::dateFormat( 'date' ),$ticket->created + $timezone );
				$params->title = $ticket->name;
				$params->author = $member->name;
				$params->lastreply = $ticket->lastreply;
				$params->link = '<a href="'.$linkA.'">Click here!</a>';
				$params->linkclose = '<a href="'.$linkC.'">Click this link to close the ticket automatically</a>';

				$mail->setParameters( $params );
				$mail->keepAlive();
				if (!defined('PTICKET_NODE_AUTOREPLY')) WPref::get('ticket.node');
				if (PTICKET_NODE_AUTOREPLY) {											$senderName = WPref::load( 'PTICKET_NODE_TKESENDER' );									$senderEmail = WPref::load( 'PTICKET_NODE_TKESENDEREMAIL' );								$bounceEmail = WPref::load( 'PTICKET_NODE_TKEBOUNCE' );								}				if (PTICKET_NODE_AUTOREPLY) {
					$mail->replyTo( $bounceEmail, 'Bounce Email', false );					}
				$mail->sendNow( $member->uid, 'unsolved_ticket_warning', true );

			}
		}
	}
	return true;

}}