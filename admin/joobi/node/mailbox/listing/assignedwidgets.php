<?php 

* @link joobi.co
* @license GNU GPLv3 */







class Mailbox_CoreAssignedwidgets_listing extends WListings_default{



function create(){

        if (empty($this->value)) $this->value = 0;

        	 $this->content = WText::t('1206732392OZUO').' ('.$this->value.')';

	return true;

}}