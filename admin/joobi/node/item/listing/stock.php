<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreStock_listing extends WListings_default{










function create() {

	static $deliveryType =null;

	if ( !isset($deliveryType) ) {
		$deliveryType = WPref::load('PPRODUCT_NODE_DELIVERYTYPE');
	}	if ( !empty( $deliveryType ) && $deliveryType == 1 ) return false;

	if ($this->value > 0) {

		$this->content = $this->value.' '.WText::t('1206961954EAMT');

	}elseif ( $this->value < 0 ) {

		return false;

		$this->content = WText::t('1206961954EAMU');

	} else {

		$this->content = '<b><blink>'.WText::t('1227580983RNJM').'</b></blink>';

	}
	return true;

}}