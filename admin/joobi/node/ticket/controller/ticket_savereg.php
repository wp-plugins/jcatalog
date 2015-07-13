<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_savereg_controller extends WController {











function savereg() {



	if ( !PTICKET_NODE_NOREGISTERED ) return false;


		$captchaToolsC = WClass::get( 'main.captcha' );
	if ( !$captchaToolsC->checkProcedure() ) return false;



	$trucs = WGlobals::get('trucs', array(), '', 'array');


	$ticketModelID = WModel::get('ticket', 'sid');

	$email = '';

	if (!empty($trucs)) {
		$email = $trucs[$ticketModelID]['x']['email'];
		$name = $trucs[$ticketModelID]['x']['name'];
	} else {
		return false;
	}




	
	if ( !isset($trucs[$ticketModelID]['pjid']) ) $trucs[$ticketModelID]['pjid'] = 2;


	$usersCredentialC = WUser::credential();
	$uid = $usersCredentialC->ghostAccount( $email, $name, true, null, null, true );


	$trucs[$ticketModelID]['authoruid'] = $uid;



	WGlobals::set('trucs', $trucs );



	WGlobals::setEID( 0 );



	parent::save();



	WPages::redirect('controller=ticket');



}}