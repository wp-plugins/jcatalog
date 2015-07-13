<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_sendnote_controller extends WController {




function sendnote() {

	$tkidREF=WGlobals::get('tkid',null,'get' );

	

	if ($tkidREF!='') WGlobals::setSession( 'tickets', 'tkid', $tkidREF);

	





	return true;

}}