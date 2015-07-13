<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreFeatured_form extends WForms_default {
	function show() {



	$featured=$this->value;



	 if ($featured == 1) {

	  $featuredView = '<span style="color:green">'.WText::t('1206732372QTKI').'</span>';

	 } else {

	  $featuredView = '<span style="color:red">'.WText::t('1206732372QTKJ').'</span>';

	 }


	 $this->content = $featuredView;

	   return true;



	}}