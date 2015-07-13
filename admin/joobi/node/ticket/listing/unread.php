<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CoreUnread_listing extends WListings_default{












	function create() {


		$lockImage = '';

		
		if ( WGlobals::checkCandy(50) ) {

			$read = $this->getValue('read');

			$status = $this->getValue('status');

			$rolid = WUser::get('rolid');

			$roles = array(4, 7, 8, 9);



		 	
			
			if (empty($read)) {

				if ( ( WRoles::isNotAdmin( 'agent' ) && $status == 81 && !in_array($rolid, $roles)))  $this->element->style = 'font-weight:bold;';





				if ( WRoles::isAdmin( 'agent' ) && (in_array($status, array(20,50)) && in_array($rolid, $roles))) {

					$this->element->style = 'font-weight:bold;'; 			 
				} else {

					$this->element->style = '';

				}
			} else {

				$this->element->style = '';

			}


			
			$islock = $this->getValue('lock');	


			if ( WRoles::isAdmin( 'agent' ) && !empty($islock) ) {
				$iconO = WPage::newBluePrint( 'icon' );
				$iconO->icon = 'lock';
				$iconO->text = WText::t('1206732412DACF');
				$lockImage = WPage::renderBluePrint( 'icon', $iconO );
			}

		}


		$this->value = $lockImage . $this->value;



		return parent::create();



	}
}