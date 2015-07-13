<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class WListing_Coredays extends WListings_default{

	function create() {


		if ( empty($this->value) || $this->value == 0 ) return false;

		$time = round( $this->value / 86400 );
		if ( empty($time) ) return false;


		$this->content = $time;
		$this->content .= ' ' . WText::t('1206732357ILFK');

		return true;


	}
}