<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_Setlimit_filter {



function create(){



        $limit = WGlobals::set('numdisplay');

        $ticketDisplayM = WModel::get('ticket');

        $ticketDisplayM->select('tkid');

        $ticketDisplayM->setLimit($limit);

        $limitedDisplay = $ticketDisplayM->load('o');


}

}