<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Mailbox_handled_purge_controller extends WController {








	function purge() {





		$mailboxHandledM = WModel::get( 'mailbox.handled' );

		$mailboxHandledM->emptyTable();



		$message = WMessage::get();

		$message->userS('1241989381TANT');



		return true;



	}}