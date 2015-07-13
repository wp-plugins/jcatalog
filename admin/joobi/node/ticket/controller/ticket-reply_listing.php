<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_reply_listing_controller extends WController {


function listing() {



	$tkid = WGlobals::get('tkid',null,'get' );

	
	$uid = WUser::get( 'uid' );

	


	if ( !empty($tkid) ) WGlobals::setSession( 'tickets', 'tkid', $tkid );



	if ( WPref::load( 'PTICKET_NODE_TIMING' ) ) WGlobals::setSession( 'tickets', 'startwritingreply', time() );



	$ticketM = WModel::get('ticket');


	$ticketM->whereE('tkid', $tkid );

	$ticketInfo = $ticketM->load('o',array('private', 'read', 'authoruid', 'assignuid', 'status' ) );	

	if ( !empty($ticketInfo->private) && $ticketInfo->authoruid != $uid ) {
				if ( ! WRole::hasRole( 'agent' ) ) {
			WPages::redirect( 'controller=ticket' );
		}	}


	
	if (WGlobals::checkCandy(50)) {

		
		$ticketM = WModel::get( 'ticket' );
		$ticketM->whereE('tkid',$tkid);

		$ticketM->setVal('lock',1);

		if ( empty($ticketInfo->read) ) {

			
			
			if ( !empty($ticketInfo->assignuid)
			&& ( ( !empty($ticketInfo->status) && $ticketInfo->status == 81 && $ticketInfo->authoruid == $uid ) || $ticketInfo->assignuid == $uid) ) {
				$ticketM->setVal( 'read', 1 );
			}
		}
		
		$ticketM->update();

	}


	
	if ( WRoles::isAdmin( 'agent' ) ) {

				$this->setView( 'ticket_reply_be');

	}else {

		
		
		$uid = WUser::get( 'uid' );


		if ( WUser::isRegistered() ) {	


			$ticketM = WModel::get( 'ticket' );

			$ticketM->whereE( 'tkid', $tkid );

			$ticketM->makeLJ( 'ticket.project' , 'pjid' );

			$ticketM->makeLJ( 'ticket.projectmembers' , 'pjid', 'pjid', 1, 2 );



			$ticketM->whereE( 'authoruid', $uid, 0, null, 1 );

			$ticketM->whereE( 'uid', $uid, 2, null, 0, 1, 1 );




			$canAccess = $ticketM->exist();


						WGlobals::set( 'ticketAccessAuthor', $canAccess, 'global' );

			
			if ( $canAccess) {

								$this->setView( 'ticket_reply_fe' );

			} elseif ( WGlobals::checkCandy(50) && WPref::load( 'PTICKET_NODE_TKRREPLY' ) ) { 
				$this->setView( 'ticket_reply_fe' );

			}elseif ( !$ticketInfo->private ) {

				
				
			
								$this->setView( 'ticket_show_fe' );

			} else {

				
				$message= WMessage::get();

				$message->userW('1242098029MCXQ');

			}




		} elseif ( WGlobals::checkCandy(50) && !$ticketInfo->private ) {	
			
			$guid = WGlobals::get( 'guid', '');




			if ( !empty($guid) ) {



				$tools = WUser::session();

				$uid = $tools->setGuest();



			}


			WPref::load( 'PTICKET_NODE_NOREGISTERED' );

			
			if (PTICKET_NODE_NOREGISTERED ) {

								$this->setView( 'ticket_reply_fe_noregistered');

			} else {

								$this->setView( 'ticket_show_fe_noregistered');
			}


		} else { 
			if ( !defined('PUSERS_NODE_FRAMEWORK_FE') ) WPref::get( 'users.node', false, true, false );
			$usersAddon = WAddon::get( 'users.'. PUSERS_NODE_FRAMEWORK_FE );
			$usersAddon->goLogin();


			return true;

		}


	}


	return true;


}
}