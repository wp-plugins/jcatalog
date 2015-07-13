<?php 

* @link joobi.co
* @license GNU GPLv3 */

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