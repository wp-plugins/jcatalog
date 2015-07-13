<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Ticket_CoreFollowup_listing extends WListings_default{







function create() {



	$isfollowup = $this->getValue('followup');	
	$islock = $this->getValue('lock');		
	$assignbyuid = $this->getValue('assignbyuid');	
	$userIdLoggedIn = WUser::get('uid');		

	$iconO = WPage::newBluePrint( 'icon' );
	$iconO->icon = 'lock';
	$iconO->text = WText::t('1206732411EGRI');
	$lockImage = WPage::renderBluePrint( 'icon', $iconO );

	$iconO = WPage::newBluePrint( 'icon' );
	$iconO->icon = 'warning';
	$iconO->text = WText::t('1219844525HQBL');
	$followUp = WPage::renderBluePrint( 'icon', $iconO );


	
	if ($islock && $isfollowup && ($userIdLoggedIn == $assignbyuid) ) {


		$this->content = $lockImage . $followUp;


	}elseif ($isfollowup && ($userIdLoggedIn == $assignbyuid)) {	
		$this->content = $followUp;

	}elseif ($islock) {						
		$this->content = $lockImage;

	}


	return true;


}}