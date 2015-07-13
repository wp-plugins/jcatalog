<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
 class Mailbox_Process_controller extends WController {




	function process() {
		$eid = WGlobals::getEID();

		if ( empty($eid) ) return true;

				if ( WGlobals::checkCandy(25,true) ) {
			$message = WMessage::get();
			$message->userE('1241989376CCKC');
			return true;
		}

		$mymailbox = WModel::getElementData( 'mailbox', $eid );

		$mailboxC = WClass::get('mailbox.handle');
		$mailboxC->report = true;
		$mailboxC->processMailbox( $mymailbox );

		return true;
	}
 }