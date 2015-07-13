<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Comment_CoreVotes_listing extends WListings_default{

function create() {

    $usefulclick = NULL;

	$usefulclick = $this->getValue('usefulclick');				
	if (empty($usefulclick)) {

			$content = '<span style="color:gray">'.WText::t('1251795312BCNY').'</span>';

	}else {

		$content = 'No. of votes: '.$usefulclick;

	}

	$this->content = $content;


    return true;

}}