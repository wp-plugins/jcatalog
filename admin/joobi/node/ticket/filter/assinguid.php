<?php 

* @link joobi.co
* @license GNU GPLv3 */


class Ticket_Assinguid_filter {








function create() {

	if (!defined(PTICKET_NODE_FOLLOWUPTICKET)) WPref::get('ticket.node');

	if (PTICKET_NODE_FOLLOWUPTICKET) {				

		$assignuid = WUser::get('uid');

		return $assignuid;

	}
}}