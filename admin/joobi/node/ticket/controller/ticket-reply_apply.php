<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Ticket_reply_apply_controller extends WController {









function apply() {


	$trucs = WGlobals::get('trucs' );

	$ticketSID = WModel::getID('ticket.reply');

	$tkid = $trucs[$ticketSID]['tkid'];

	$type = WGlobals::get('tktypeid' );

	$priority = WGlobals::get('priority' );



	parent::apply();



	WPages::redirect( 'controller=ticket-reply&task=listing&private=false&tkid='.$tkid.'&tktypeid='.$type.'&priority='.$priority );



	return true;

}}