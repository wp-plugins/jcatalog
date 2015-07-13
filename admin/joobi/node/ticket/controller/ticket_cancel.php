<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_cancel_controller extends WController {










function cancel(){

	

	WPages::redirect('controller=ticket-my');

	return true;

}}