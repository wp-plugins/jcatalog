<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
 class Mailbox_Applyconnect_controller extends WController {




	function applyconnect() {
		parent::apply();


		$eid = WGlobals::getEID();

		if (empty($eid)) return true;


		$mymailbox = WModel::getElementData( 'mailbox', $eid );

		$mailbox = WClass::get('mailbox.handle');
		$mailbox->report = true;
		$connection = $mailbox->connect($mymailbox);

		return true;

	}
}