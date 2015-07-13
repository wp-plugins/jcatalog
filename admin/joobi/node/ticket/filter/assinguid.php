<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Ticket_Assinguid_filter {








function create() {

	if (!defined(PTICKET_NODE_FOLLOWUPTICKET)) WPref::get('ticket.node');

	if (PTICKET_NODE_FOLLOWUPTICKET) {				

		$assignuid = WUser::get('uid');

		return $assignuid;

	}
}}