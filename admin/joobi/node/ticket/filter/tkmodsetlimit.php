<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Ticket_Tkmodsetlimit_filter {







	function create(){



	        $limit = WGlobals::set('numdisplay');

	        $ticketDisplayM = WModel::get('ticket');

	        $ticketDisplayM->select('tkid');

	        $ticketDisplayM->setLimit($limit);

	        $limitedDisplay = $ticketDisplayM->load('o');

	        
	        return $limit;


	}
}