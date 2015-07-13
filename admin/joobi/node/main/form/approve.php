<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















WView::includeElement( 'form.yesno' );
class WForm_Coreapprove extends WForm_yesno {

		protected $defaultValues = array(  1, 0 );
	protected $defaultImages = array( 'unlock', 'lock' );
	protected $defaultLabel = array();




	function create() {
		$yes = WText::t('1246518570RHDZ');
		$no = WText::t('1310529911CSAV');
		$this->defaultLabel = array( $yes, $no );
		return parent::create();

	}





	function show() {
		$yes = WText::t('1246518570RHDZ');
		$no = WText::t('1310529911CSAV');
		$this->defaultLabel = array( $yes, $no );
		return parent::show();
	}


}

