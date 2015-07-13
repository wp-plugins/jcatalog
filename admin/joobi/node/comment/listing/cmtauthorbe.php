<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_CoreCmtauthorbe_listing extends WListings_default{












function create() {

	
	$date=$this->getValue('created');

	$date= WApplication::date( WTools::dateFormat( 'date-time' ), $date);		
	$name = $this->getValue('name');		


	
	$content='By: <span  style="color:#A9A9A9; font-weight:bold;">' .$name. '</span>

		on <font style="color:#A9A9A9; font-weight:bold;font-size:x-small">'.$date.' </font>';

	$this->content=$content;

	return true;

}}