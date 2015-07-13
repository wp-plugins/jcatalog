<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















WView::includeElement( 'listing.yesno' );
class WListing_Coreprivate extends WListing_yesno {


	function create() {

				if ( isset($this->value) && $this->value>0 ) {
			$this->class 	= 'lock';
			$this->nameTag = WText::t('1219769905FKPR');
			$this->order = 1;
			$this->valueTo=0;
		} else {
						$this->class 	= 'unlock';
			$this->nameTag = WText::t('1224166212FTLB');
			$this->order = 2;
			$this->valueTo='1';
		}
		$this->elementType = 'core';
		$this->classLegend = array('lock','unlock');

		$this->content = $this->createHTML();

		return true;

	}




	public function advanceSearch() {

			$this->oneDropA[] = WSelect::option( 0, WText::t('1206732410ICCJ') );
			$this->oneDropA[] = WSelect::option( 10, WText::t('1219769905FKPR') );
			$this->oneDropA[] = WSelect::option( 11, WText::t('1224166212FTLB') );

		return parent::advanceSearch();

	}
}