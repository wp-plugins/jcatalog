<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_reply_makeprivate_controller extends WController {



	function makeprivate() {


		$trucs = WGlobals::get('trucs');


		parent::save();



		$ticketM = WModel::get('ticket');

		$tkid = WGlobals::get('tkid');

		$private = WGlobals::get('private');

		$priority = WGlobals::get('priority');

		$type= WGlobals::get('tktypeid');

		$authoruid = WGlobals::get('authoruid');


		
		if ( WRoles::isNotAdmin( 'agent' ) ) {

			
			$uid = WUser::get( 'uid' );

			$ticketM->makeLJ( 'ticket.project' , 'pjid' );

			$ticketM->makeLJ( 'ticket.projectmembers' , 'pjid', 'pjid', 1, 2 );



			$ticketM->whereE( 'authoruid', $uid, 0, null, 1 );

			$ticketM->whereE( 'uid', $uid, 2, null, 0, 1, 1 );



			$ticketReplySID = WModel::get('ticket.reply', 'sid');





			$tkid = $trucs[$ticketReplySID]['tkid'];



		} else {	
			$ticketM->getFormData();

		}

		if ( !empty( $tkid ) ) {
			$ticketM->whereE( 'tkid', $tkid );
			$privateticket = $ticketM->load( 'lr', 'private' );

			$ticketM->whereE( 'tkid', $tkid );
			$ticketM->setVal( 'private', ! $privateticket );

			$ticketM->update();

		}


		WPages::redirect( 'controller=ticket-reply&task=listing&tkid=' . $tkid . '&private=' . $private . '&priority='.$priority.'&authoruid='.$authoruid.'&tktypeid='.$type);



		return true;



	}
}