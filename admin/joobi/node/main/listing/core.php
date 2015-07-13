<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















WView::includeElement( 'listing.yesno' );
class WListing_Corecore extends WListing_yesno {

	function create() {

		


		if ( !empty($this->value) ) {
			$this->class = 'lock';
			$this->nameTag = WText::t('1206732412DACF');
			$this->order = 1;
			$this->valueTo = 0;
		} else {
						$this->class = 'unlock';
			$this->nameTag = WText::t('1240888718QMAD');
			$this->order = 2;
			$this->valueTo = 1;
		}
		$this->elementType = 'core';
		$this->classLegend = array( 'lock', 'unlock' );

		$this->content = $this->createHTML();

		return true;

	}
}


