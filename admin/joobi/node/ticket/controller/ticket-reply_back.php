<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_reply_back_controller extends WController {








function back(){

	$ticketMId = WModel::getID( 'ticket.reply' );	


	$trucs=WGlobals::get('trucs');		
	$tkid=$trucs[$ticketMId]['tkid'];		


	
	$ticketM=WModel::get('ticket');


	$ticketM->whereE('tkid',$tkid);

	$ticket=$ticketM->load('o',array('private','lock'));



	
	$ticketM->whereE('tkid',$tkid);

	$ticketM->setVal('lock',0);

	$ticketM->update();



	
	WPages::redirect('controller=ticket');



return true;

}

















































































}