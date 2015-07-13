<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Ticket_CoreOwner_listing extends WListings_default{
















function create() {

	
	if (WGlobals::checkCandy(50)) {

		$read = $this->getValue('read');

		$authoruid = $this->getValue('authoruid');

		$uidLoggedIn = WUser::get('uid');	

		
		
		if (empty($read) && ($authoruid == $uidLoggedIn)) {

			
			$this->element->style = 'font-weight:bold;';		

		} else {	

			
			$this->element->style = '';

		}
	}
	

return parent::create();	

}}