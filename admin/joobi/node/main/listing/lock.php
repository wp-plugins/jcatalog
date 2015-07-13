<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















WView::includeElement( 'listing.yesno' );
class WListing_Corelock extends WListing_yesno {






		var	$class 	= '';
		var	$nameTag = '' ;
		var	$order = 0;
		var	$valueTo=0;
		var $elementType='';
		var $classLegend= array();

	function create() {

				static $userRole = null;
		if ( !isset($userRole) ) {
			$userRole = WRole::hasRole( 'sadmin' );
		}

		if ( isset($this->value) && $this->value>0 ) {
			$this->class = 'disabled';
			$this->nameTag = WText::t('1206732411EGRI');
			$this->order = 1;
			$this->valueTo= 1;
		} else {
						$this->class 	= 'enabled';
			$this->nameTag = WText::t('1401377882ETOG');
			$this->order = 2;
			$this->valueTo= 0;
		}
		$this->elementType = 'lock';
		$this->classLegend = array( 'disabled', 'enabled' );

		$this->content = $this->createHTML();

		return true;

	}






	public function advanceSearch() {

			$this->oneDropA[] = WSelect::option( 0, WText::t('1206732410ICCJ') );
			$this->oneDropA[] = WSelect::option( 10, WText::t('1206732411EGRI') );
			$this->oneDropA[] = WSelect::option( 11, WText::t('1401377882ETOH') );

		return parent::advanceSearch();

	}

}