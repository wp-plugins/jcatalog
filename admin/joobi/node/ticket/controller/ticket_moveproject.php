<?php 

* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_moveproject_controller extends WController {




function moveproject() {





	

	$eid = WGlobals::getEID( true );



	WGlobals::setSession( 'ticket', 'moveProjectEID', $eid );



	return true;



}





















}