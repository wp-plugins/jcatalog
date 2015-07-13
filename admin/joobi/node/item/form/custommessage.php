<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreCustommessage_form extends WForms_default {


function create() {


	if ( !empty($this->data->prdgeneral) ) return false;



	$text = '<span style="color:red;font-weight:bold;">' . WText::t('1418159973LMLX') . '</span>';



	$this->content = $text;



	return true;



}




function show() {

	return $this->create();

}}