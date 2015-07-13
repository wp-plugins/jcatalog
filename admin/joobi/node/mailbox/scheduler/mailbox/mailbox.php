<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




class Mailbox_Mailbox_scheduler extends Scheduler_Parent_class {

	function process() {

				WPref::get('mailbox.node');

				if ( WGlobals::checkCandy(25,true) ){
			$this->addReport( 'You need to upgrade to the Commercial version to handle the messages' );
			return false;
		}
		$mailboxC = WClass::get( 'mailbox.handle' );
		$mailboxC->report = false;
		$mailboxC->maxTime = $this->getMaxTime();
		$mailboxC->processMailbox();

		$this->addReport( $mailboxC->getReports() );

		return true;

	}
}