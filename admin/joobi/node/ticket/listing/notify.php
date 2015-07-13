<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_CoreNotify_listing extends WListings_default{












function create(){



	
	$notify=$this->getValue( 'notify' );		
	$uid=$this->getValue('uid');			
	$pjid=$this->getValue('pjid');			
	$projTitle=WGlobals::get('titleheader');

	$level=$this->getValue('supportlevel');		


	
	 $link=WPage::routeURL('controller=ticket-projectmembers&task=notify&uid='.$uid.'&pjid='.$pjid.'&notify='.$notify.'&titleheader='.$projTitle);



	
	if ( empty($level) ) {
		$iconO = WPage::newBluePrint( 'icon' );
		$iconO->icon = 'cancel';
		$iconO->text = WText::t('1206732372QTKJ');
		$this->content = WPage::renderBluePrint( 'icon', $iconO );


	}elseif( $notify ) {

		$iconO = WPage::newBluePrint( 'icon' );
		$iconO->icon = 'sendmessage';
		$iconO->text = WText::t('1395500429FBNF');
		$sendE = WPage::renderBluePrint( 'icon', $iconO );


	    $this->content='<a href="'.$link.'">'.$sendE. '</a>';



    } else {

		$iconO = WPage::newBluePrint( 'icon' );
		$iconO->icon = 'dontsendmessage';
		$iconO->text = WText::t('1395500429FBNG');
		$sendE = WPage::renderBluePrint( 'icon', $iconO );


	  	$this->content='<a href="'.$link.'">'.$sendE. '</a>';



 	}

	return true;


}
}