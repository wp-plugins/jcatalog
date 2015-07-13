<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_reply_assignticket_controller extends WController {






	function assignticket() {

				$trucs = WGlobals::get('trucs');
		$ticketSID = WModel::get('ticket', 'sid');

		$comment = WController::getFormValue( 'comment' );

		$tkid = $this->_eid[0];
		$uid = $trucs[$ticketSID]['x']['uid'];					$priorityV = @$trucs[$ticketSID]['priority'];
		$type = @$trucs[$ticketSID]['tktypeid'];
		$userNameLoggedIn = WUser::get('name');					$userIdLoggedIn = WUser::get('uid');				
		if ( !empty($tkid) && !empty($uid) ) {

						if ( !empty($comment) ) {
				$agent = WRole::getRole( 'agent' );
				$ticketReplyM = WModel::get( 'ticket.reply' );
				$ticketReplyM->tkid = $tkid;
				$ticketReplyM->publish = 1;
				$ticketReplyM->rolid = $agent;
				$ticketReplyM->comment = 1;							$ticketReplyM->setChild( 'ticket.replytrans', 'description', $comment ); 				$ticketReplyM->setChild( 'ticket.replytrans', 'lgid', 1 ); 				$ticketReplyM->setSendEmail();
									$ticketReplyM->save();

			}
			


			$priorityC = WClass::get( 'ticket.picklist' );
			$priority = $priorityC->getName('ticket-priority', $priorityV);	
						$ticketM = WModel::get( 'ticket' );
			$ticketM->makeLJ(  'tickettrans', 'tkid' );
			$ticketM->select( 'created', 0, 'created' );
			$ticketM->select( 'namekey', 0, 'ticketid' );
			$ticketM->select( 'name', 1, 'title' );
			$ticketM->select( 'description', 1, 'description' );
			$ticketM->select( 'authoruid', 0 );
			$ticketM->makeLJ(  'ticket.projecttrans', 'pjid' );
						$ticketM->select( 'name', 2, 'category' );
			$ticketM->select( 'pjid', 0);
			$ticketM->whereE('tkid',$tkid);
			$ticketInfo = $ticketM->load('o' );

			$ticketInfo->created = WApplication::date( WTools::dateFormat( 'day-date-time' ) , $ticketInfo->created );

			$allPref = WPref::load('PTICKET_NODE_TKLINK' );

			$pageIndex = ( $allPref ) ? 'admin' : 'home';


			$ticketMembersM = WModel::get( 'ticket.projectmembers' );
			$ticketMembersM->whereE('pjid', $ticketInfo->pjid);
			$ticketMembersM->whereE('uid', $uid);
			$notify = $ticketMembersM->load('lr','notify');

						$linkA = WPage::routeURL( 'controller=ticket-reply&tkid='.$tkid.'&priority='.$priorityV.'&tktypeid='.$type.'&authoruid='.$ticketInfo->authoruid, $pageIndex );	
			$mail = WMail::get();

						if ( $notify ) {
												$ticketInfo->link = '<a href="'.$linkA.'">' . WText::t('1389884098SHJK') . '</a>';					$ticketInfo->comment = $comment;										$ticketInfo->priority = $priority;										$ticketInfo->assignedby =  $userNameLoggedIn;

				$mail->setParameters( $ticketInfo );

				



				if ( WPref::load('PTICKET_NODE_AUTOREPLY' ) ) {
					$bounceEmail = WPref::load( 'PTICKET_NODE_TKEBOUNCE' );									$mail->replyTo( $bounceEmail, 'Bounce Email', false );						}
				$mail->sendNow( $uid, 'support_required_notification', true );

			}
			$ticketM = WModel::get('ticket');

						$followup = 0;

			if ( WPref::load( 'PTICKET_NODE_FOLLOWUPTICKET' ) ) $followup = 1;
						$inform = WPref::load( 'PTICKET_NODE_INFORMODERATOR' );
			if ($inform) {

								$ticketM->whereE('tkid', $tkid);
				$assignbyuid = $ticketM->load( 'lr', 'assignbyuid' );

				if (empty($assignbyuid)) {						$ticketM->setVal( 'assignbyuid', $userIdLoggedIn);					} else {														$emailParams = new stdClass;
					$emailParams->ticketid = $ticketInfo->ticketid;
					$emailParams->title = $ticketInfo->title;
					$emailParams->description = $ticketInfo->description;
					$emailParams->link = '<a href="'.$linkA.'">' .WText::t('1244448970SMQL'). '!</a>';
					$emailParams->newmoderator =  WUser::get( 'name', $uid );

					$mail->setParameters($emailParams);
					$mail->sendNow( $assignbyuid, 'inform_assigned_moderator', false );
				}
			} else {
							}
		   			$ticketM->whereE('tkid', $tkid );
			$ticketM->setVal( 'assignuid', $uid);
			$ticketM->setVal( 'status', '50' );					$ticketM->setVal('priority',$priorityV);
			$ticketM->setVal('lock',0);		        	$ticketM->setVal('read', 0);		        	$ticketM->setVal('followup',$followup);			$ticketM->setVal('tktypeid',$type);
			$ticketM->update();			
			$notifyassignedcustome = WPref::load( 'PTICKET_NODE_NOTIFYASSIGNEDCUSTOMER' );
						if ( $notifyassignedcustome ) {
				$emailParams = new stdClass;
				$emailParams->ticketid = $ticketInfo->ticketid;
				$linkA = WPage::linkHome( 'controller=ticket-reply&tkid='.$tkid.'&priority='.$priorityV.'&tktypeid='.$type.'&authoruid='.$ticketInfo->authoruid, $pageIndex );	
				$emailParams->link = '<a href="'.$linkA.'">' . WText::t('1244448970SMQL') . '!</a>';

				$mail->setParameters( $emailParams );
				$mail->sendNow( $ticketInfo->authoruid, 'inform_assigned_customer' );

			}


						$message = WMessage::get();						$message->userS('1262854806NJTU');

		}

		WPages::redirect( 'controller=ticket' );

		return true;

	}
}