<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Ticket_Commentfilter_filter {












function create() {

 	$value = array( 0,1 );	


	if (WGlobals::checkCandy(50)) {

		if ( WPref::load( 'PTICKET_NODE_TKUSECOMMENT' ) ) {		
			 $value= array( 0,1,10 );

		}
	}


	return $value;

}}