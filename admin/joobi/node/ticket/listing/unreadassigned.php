<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Ticket_CoreUnreadassigned_listing extends WListings_default{










function create() {

	
	if (WGlobals::checkCandy(50)) {

		$read = $this->getValue('read');

		$assignuid = $this->getValue('assignuid');

		$uidLoggedIn = WUser::get('uid');

		$status = $this->getValue('status');	



		
		
		if (empty($read) && ($assignuid == $uidLoggedIn) && in_array($status, array(50, 20))) {

			
			$this->element->style = 'font-weight:bold;';		

		} else {	

			
			$this->element->style = '';

		}
	}
	

return parent::create();	

}}