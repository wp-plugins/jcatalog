<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_Ticket_listing_be_view extends Output_Listings_class {
protected function prepareView() {



	if ( ! WPref::load( 'PTICKET_NODE_TKRT' ) ) {

		$this->removeElements( array( 'ticket_listing_be_response_time', 'ticket_listing_be_ticket_resptime', 'ticket_listing_be_ticket_deadline' ) );

	}


	return true;



}}