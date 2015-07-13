<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_projectmembers_change_controller extends WController {












function change() {





	
	$pjid = WGlobals::get( 'pjid' );

	$supportLevel = WGlobals::get( 'level' );

	$uid = WGlobals::get( 'uid' );



	
	WGlobals::set( 'uid', null );

	WGlobals::set( 'level', null );



	$value = $supportLevel + 1;

	if ( $value > WPref::load('PTICKET_NODE_SUPPORTLEVEL' ) ) $value = 1;



	$ticketPropjectMembersM = WModel::get( 'ticket.projectmembers' );

	
	$ticketPropjectMembersM->whereE( 'uid', $uid );

	$ticketPropjectMembersM->whereE( 'pjid', $pjid );

	$ticketPropjectMembersM->setVal( 'supportlevel', $value );

	
	$ticketPropjectMembersM->update();



	return true;

}





















































}