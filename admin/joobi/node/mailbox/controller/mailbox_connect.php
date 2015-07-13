<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
 class Mailbox_Connect_controller extends WController {




	function connect() {

		$eid = WGlobals::getEID();

		if (empty($eid)) return true;


		$mymailbox = WModel::getElementData( 'mailbox', $eid );

		$mailbox = WClass::get('mailbox.handle');
		$mailbox->report = true;
		$connection = $mailbox->connect($mymailbox);

		if ($connection){
			$connection->checkAllMessages( 1 );
			if ( $connection->getMessage() ) {
				$message = WMessage::get();
				$SUBJECT = $connection->getSubject();
				$CONTENT = $connection->getBody();
				$SENDER = $connection->getInformation('sender_name').' | '.$connection->getInformation('sender_email');
				$message->userN('1241989376CCKB',array('$SUBJECT'=>$SUBJECT,'$SENDER'=>$SENDER,'$CONTENT'=>$CONTENT));
			}		}
	}
}