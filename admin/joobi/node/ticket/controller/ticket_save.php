<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Ticket_save_controller extends WController {






	function save() {

		parent::save();

		WPages::redirect('controller=ticket-my');

		return true;

	}
}