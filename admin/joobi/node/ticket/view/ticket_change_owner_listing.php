<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Ticket_Ticket_change_owner_listing_view extends Output_Listings_class {
function prepareView() {



		$tkid = WGlobals::get( 'tkid_' . WModel::getID( 'ticket') );



		if ( !empty($tkid) ) WGlobals::set( 'tkid', $tkid[0] );



		return true;



	}}