<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WListing_Corefilesize extends WListings_default{




	function create() {
		$size = $this->value;
		if ($size > 999 && $size < 1000000) {
			$size = round($size/1000, 2);
			$postfix = ' KB';
		}elseif ($size > 999999 && $size < 1000000000){
			$size = round($size/1000000, 2);
			$postfix = ' MB';
		}elseif ($size > 999999999){ 			$size = round($size/1000000000, 2);
			$postfix = ' GB';
		}else $postfix = ' B';

		if ( $size > 1000 ) $size = number_format($size, 2, '.', ',');

		$this->value = $size . $postfix;
		return parent::create();
	}
}

