<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Mailbox_CoreAssignedwidgets_listing extends WListings_default{



function create(){

        if (empty($this->value)) $this->value = 0;

        	 $this->content = WText::t('1206732392OZUO').' ('.$this->value.')';

	return true;

}}