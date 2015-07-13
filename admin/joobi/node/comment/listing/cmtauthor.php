<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_CoreCmtauthor_listing extends WListings_default{




function create() {



	
	$date=$this->getValue('created');

	$date= WApplication::date( WTools::dateFormat( 'date-time' ), $date);		
	$name = $this->getValue('username');		


	
	$this->content = WText::t('1213117657LKZK').': <span class="reviewName"> ' .$name. ' </span>';

	$this->content .= WText::t('1272278972GKNC').'<span class="reviewDate"> '.$date.' </span>';

	

	return true;

}}