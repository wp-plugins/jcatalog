<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Mailbox_Emptytrashbox_scheduler extends Scheduler_Parent_class {




	function process(){

					$pref = WPref::get( 'mailbox.node' );
		$delFrequency = (int)$pref->getPref( 'trashdelmsg', 0 );

		if ( !empty($delFrequency) ){
						$mailboxMessagesM=WModel::get( 'mailbox.messages' );
			$mailboxMessagesM->noValidate();
			$mailboxMessagesM->where( 'created', '<', time() - $delFrequency*86400 );
			$mailboxMessagesM->whereE( 'box', 30 );
			$mailboxMessagesM->delete();


		}
		return true;

	}
}