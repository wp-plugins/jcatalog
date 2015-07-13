<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_reply_moveprojectsave_controller extends WController {








function moveprojectsave() {









	$eid = WGlobals::getSession( 'ticket', 'moveProjectEID', array() );



	$trucs = WGlobals::get('trucs');

	$pjid = $trucs['x']['project'];


	if ( empty($pjid) ) return true;

	if ( empty($eid) ) return true;





	$ticketProjectMemberM = WModel::get( 'ticket.projectmembers' );

	$ticketProjectMemberM->whereE('supportlevel', 1);


	$ticketProjectMemberM->whereE( 'pjid', $pjid );

	$assignuid = $ticketProjectMemberM->load('lr', 'uid');



	
	$ticketM = WModel::get('ticket');


	$ticketM->whereIn( 'tkid', $eid );

	$ticketM->setVal( 'pjid', $pjid );

	$ticketM->setVal( 'assignuid', $assignuid ); 
	$ticketM->update();



	if ( WPref::load( 'PTICKET_NODE_TKEMAILASSIGN' ) ) {



		
		$ticketM->whereIn( 'tkid', $eid );

		$ticketM->whereE( 'lgid', 1, 1 );

		$ticketM->makeLJ( 'tickettrans', 'tkid' );

		$ticketM->select( 'name', 1, 'title');

		$ticketM->select(  'description' , 1);

		$alltickets = 	$ticketM->load( 'ol', array( 'assignuid', 'pjid', 'namekey', 'tkid','priority','tktypeid' ) );



		if ( empty($alltickets) ) return true;

		$tkMail=WClass::get('ticket.mail');



		foreach( $alltickets as $oneTicket ) {



		
		$tkMail->alterProjectAssignedPersons( $oneTicket, 'new_ticket_assign' );



		}
	}


	
	$message = WMessage::get();

	$MOVEMSG = "Successfully Moved Project";

	$message->userS($MOVEMSG);

	WPages::redirect( 'controller=ticket' );

	return true;

}}