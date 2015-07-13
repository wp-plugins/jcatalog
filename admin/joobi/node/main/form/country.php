<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');














class WForm_Corecountry extends WForms_default {




	function create() {
				return true;
	}



	function show() {

		if ( ! WExtension::exist('iptracker.node') || WGlobals::checkCandy(50,true) ) return parent::show();

		$countriesHelperC = WClass::get( 'countries.helper', null, 'class', false );
		if ( !empty($countriesHelperC) ) $this->content .= $countriesHelperC->getCountryFlag( $this->getValue( 'ctyid', 'address' ) );

		return parent::show();
	}

}