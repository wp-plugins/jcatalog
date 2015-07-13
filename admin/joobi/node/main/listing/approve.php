<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















WView::includeElement( 'listing.yesno' );
class WListing_Coreapprove extends WListing_yesno {






		var	$class 	= '';
		var	$nameTag = '' ;
		var	$order = 0;
		var	$valueTo=0;
		var $elementType='';
		var $classLegend= array();

	function create() {

		
		static $userRole = null;
		if ( !isset($userRole) ) {
			$roleHelper = WRole::get();
			$userRole = WRole::hasRole( 'storemanager' );
		}
		if ( $userRole ) $this->element->infonly = false;

		if (isset($this->value) && $this->value>0) {
			$this->class 	= 'lock';
			$this->nameTag = WText::t('1310529911CSAV');
			$this->order = 1;
			$this->valueTo=0;
		} else {
						$this->class 	= 'unlock';
			$this->nameTag = WText::t('1246518570RHDZ');
			$this->order = 2;
			$this->valueTo='1';
		}
		$this->elementType = 'approve';
		$this->classLegend = array('lock','unlock');

		$this->content = $this->createHTML();

		return true;

	}






	public function advanceSearch() {

			$this->oneDropA[] = WSelect::option( 0, WText::t('1206732410ICCJ') );
			$this->oneDropA[] = WSelect::option( 10, WText::t('1310529911CSAV') );
			$this->oneDropA[] = WSelect::option( 11, WText::t('1246518570RHDZ') );

		return parent::advanceSearch();

	}

}