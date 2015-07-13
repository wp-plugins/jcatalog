<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Currency_CoreWebsitelink_listing extends WListings_default{




function create()

{

	$this->content = '<a href="'. $this->value .'" target="_blank">'. $this->value .'</a>';

	return true;

}













}