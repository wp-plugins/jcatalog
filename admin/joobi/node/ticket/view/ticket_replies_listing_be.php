<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Ticket_Ticket_replies_listing_be_view extends Output_Listings_class {
protected function prepareView() {



	if ( !WPref::load( 'PTICKET_NODE_TKRT' ) ) {

		$this->removeElements( array( 'ticket_replies_listing_be_timeresp' ) );

	}


	return true;



}}