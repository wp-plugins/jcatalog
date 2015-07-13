<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_Status_picklist extends WPicklist {








function create() {



	if ( $this->onlyOneValue() ) {

		if ( empty($this->defaultValue) ) return true;	
		$statusT = WType::get( 'ticket.publish' );

		$this->addElement( $this->defaultValue, $statusT->getName( $this->defaultValue ) );
		return true;

	}




	$status = WType::get( 'ticket.publish' );

	foreach( $status->publish as $ind => $val )  {

		if ( $ind > '0' ) $this->addElement( $ind, $val );

	}


	return true;



}}