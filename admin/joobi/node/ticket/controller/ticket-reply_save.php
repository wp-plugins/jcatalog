<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_reply_save_controller extends WController {

	function save() {
		parent::save();
		WPages::redirect('controller=ticket');
		return true;
	}
}