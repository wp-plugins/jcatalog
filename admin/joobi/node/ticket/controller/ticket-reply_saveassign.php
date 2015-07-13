<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Ticket_reply_saveassign_controller extends WController {














function saveassign() {

	
	$modelID = $this->sid;

	$trucs = WGlobals::get('trucs');

	$returnid = WGlobals::get('returnid');

	$realURL = base64_decode($returnid);

	$replyTransID = WModel::getID('ticket.replytrans');

	$description = $trucs[$replyTransID][description];


	if (empty($description)) {

		WPages::redirect($realURL);

	} else {

		parent::save();

	}




	$tkid = $trucs[$modelID]['tkid'];



	
	$ticketM = WModel::get('ticket');

	$ticketM->whereE('tkid', $tkid);

	$ticketInfo = $ticketM->load('o', array('tktypeid', 'priority'));





	$link = 'controller=ticket-reply&task=assign&tkid='.$tkid.'&tktypeid='.$ticketInfo->tktypeid.'&priority='.$ticketInfo->priority;



	WPages::redirect($link);

	return true;

}}