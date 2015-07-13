<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_Status_select_picklist extends WPicklist {








function create() {



	$this->addElement( 0, ' - ' . WText::t('1361919650QJLA') . ' - ' );

	$status = WType::get( 'ticket.publish' );

	foreach( $status->publish as $ind => $val )  {

		if ( $ind>'0' ) $this->addElement( $ind, $val );

	}


}}