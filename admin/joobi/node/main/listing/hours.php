<?php 

* @link joobi.co
* @license GNU GPLv3 */



class WListing_Corehours extends WListings_default{

	function create() {


		if ( empty($this->value) || $this->value == 0 ) return false;

		$time = round( $this->value / 3600 );
		if ( empty($time) ) return false;


		$this->content = $time;
		$this->content .= ' ' . WText::t('1206732357ILFL');

		return true;


	}
}