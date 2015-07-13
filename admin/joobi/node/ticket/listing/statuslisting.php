<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CoreStatuslisting_listing extends WListings_default{





function create() {

	

	static $droplist = null;

	if ( empty( $droplist ) ) $droplist = WType::get( 'ticket.publish' );

	

	$this->content = $droplist->getName( $this->value );

	

	return true;

}}