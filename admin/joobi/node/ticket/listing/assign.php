<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_CoreAssign_listing extends WListings_default{












function create() {


	$assign='No';							


	$projectname=WGlobals::get('titleheader');			




	$pjidREF = WGlobals::get( 'pjid');				
	$uid = $this->getValue('uid');				
	$pjid = $this->getValue('pjid');				
	$supportlevel = $this->getValue('supportlevel');		
	$rolid = $this->getValue('rolid');			


	if ($pjid==$pjidREF) {						
		$assign='Yes';

	}


	if ($assign=='No') {

		$assign='<span style="color:red">'.WText::t('1206732372QTKJ').'</span>';

	}else {

		$assign='<span style="color:green">'.WText::t('1206732372QTKI').'</span>';

	}


	
	$link = WPage::routeURL('controller=ticket-projectmembers&task=assign').'&uid='.$uid.'&pjid='.$pjidREF.'&level='.$supportlevel.'&role='.$rolid.'&titleheader='.$projectname;

	$this->content = '<a href="'. $link .'">' .$assign.'</a>';



	return true;

}}