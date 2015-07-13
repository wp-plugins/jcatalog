<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Ticket_CoreAssignmoderator_listing extends WListings_default{










function create() {

	$categoryIDV = $this->getValue('pjid');	

	$categoryMdtrM = null;

	

	if (!isset($categoryMdtrM))	$categoryMdtrM = WModel::get('ticket.projectmembers');

	$categoryMdtrM->select('uid', 0, null,'count');

	$categoryMdtrM->whereE('pjid', $categoryIDV);

	$totalAssignedV = $categoryMdtrM->load('lr');



	$messageV = $this->element->textlink;

	if (!empty($totalAssignedV)) {

		$content = $messageV.'('.$totalAssignedV.')';

	} else {

		$content = '<span style="color:red;">'.WText::t('1271935558PJVM').'</span>';

	}
	$this->content = $content;

	return true;

}}