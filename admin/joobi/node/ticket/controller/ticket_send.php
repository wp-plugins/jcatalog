<?php 

* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_send_controller extends WController {




function send(){



	$tkidREF=WGlobals::getSession('tickets','tkid','');

	$eids=WGlobals::getEID( true );



	$mail=WClass::get('ticket.mail');

	$mail->notification($tkidREF,$eids);







	return true;

}}