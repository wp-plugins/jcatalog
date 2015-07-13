<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_reply_moveproject_controller extends WController {








function moveproject() {





	

	$trucs = WGlobals::get('trucs');

	$ticketReplyID = WModel::get( 'ticket.reply', 'sid' );

	$eid = $trucs[$ticketReplyID]['tkid'];


	
	$ticketM=WModel::get('ticket');

	$ticketM->whereE('tkid',$eid);		
	$ticketM->setVal('lock',0);		
	$ticketM->update();			
	WGlobals::setSession( 'ticket', 'moveProjectEID', array($eid) );

	return true;



}}