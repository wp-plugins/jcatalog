<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Ticket_CoreClose_button extends WButtons_external {
	function create() {



		$canAccess = WGlobals::get( 'ticketAccessAuthor', false, 'global' );

		if ( ! $canAccess ) return false;



		return true;



	}}