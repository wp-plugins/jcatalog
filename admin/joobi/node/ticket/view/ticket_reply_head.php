<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Ticket_reply_head_view extends Output_Listings_class {
protected function prepareView() {



	if ( !WPref::load( 'PTICKET_NODE_TKRT' ) ) {

		$this->removeElements( array( 'ticket_reply_head_ticket_resptime', 'ticket_reply_head_ticket_deadline' ) );

	}


	return true;



}}