<?php 

* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_cancelreg_controller extends WController {








function cancelreg(){

	

	WPages::redirect('controller=ticket');

	return true;

}

}