<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Ticket_assign_supportlevel_view extends Output_Forms_class {
protected function prepareView() {



		$ticketType = WPref::load( 'PTICKET_NODE_TKTYPE' );

		if ( $ticketType )  $this->removeElements( 'ticket_assign_supportlevel_ticket_type' );

		return true;



	}}