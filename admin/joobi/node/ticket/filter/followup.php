<?php 

* @link joobi.co
* @license GNU GPLv3 */


class Ticket_Followup_filter {








function create() {

	$followup = 0;

	if (WGlobals::checkCandy(50)) {

		if (!defined('PTICKET_NODE_FOLLOWUPTICKET')) WPref::get('ticket.node');				

		if (PTICKET_NODE_FOLLOWUPTICKETT) {		
			 $followup= 1;					

		}
	}
	return $followup;

}}