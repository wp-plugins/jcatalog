<?php 

* @link joobi.co
* @license GNU GPLv3 */




class Ticket_Status_select_picklist extends WPicklist {








function create() {



	$this->addElement( 0, ' - ' . WText::t('1361919650QJLA') . ' - ' );

	$status = WType::get( 'ticket.publish' );

	foreach( $status->publish as $ind => $val )  {

		if ( $ind>'0' ) $this->addElement( $ind, $val );

	}


}}