<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');







class Ticket_reply_savereg_controller extends WController {








function savereg() {



	if ( !PTICKET_NODE_NOREGISTERED ) return false;

		$captchaToolsC = WClass::get( 'main.captcha' );
	if ( !$captchaToolsC->checkProcedure() ) return false;





	$trucs = WGlobals::get('trucs', array(), '', 'array');

	$ticketModelID = WModel::get('ticket.reply', 'sid');

	$email = $trucs[$ticketModelID]['x']['email'];

	$email = trim( $email );



	$ticketUserM = WModel::get('ticket.user');

	
	$ticketUserM->whereE( 'email' , $email );

	$uid = $ticketUserM->load('lr', 'uid');



	if ( empty($uid) ) {	


		$message = WMessage::get();

		$message->historyE('1274840559DZKC');

		return false;



	}


	$trucs[$ticketModelID]['authoruid'] = $uid;

	WGlobals::set('trucs', $trucs );



	WGlobals::setEID( 0 );



	parent::save();



	WPages::redirect('controller=ticket');



}}