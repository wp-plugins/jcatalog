<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WView::includeElement( 'form.select' );
class Main_CoreRptjdoctype_form extends WForm_select {








	function create() {



		$trucs = WGlobals::get('trucs');



		$jdoctype = (!empty( $trucs['x']['jdoctype'] ) ? $trucs['x']['jdoctype'] : WGlobals::get('jdoctype') );



		if ( empty($jdoctype) ) {

			
			$jdoctype = WGlobals::getSession( 'graphFilters', 'jdoctype' );

			if ( empty($jdoctype) ) $jdoctype = 220;	
		}


		WGlobals::setSession( 'graphFilters', 'jdoctype', $jdoctype );



		$this->value = $jdoctype;

		WPage::addJSLibrary( 'validation' );



		return parent::create();

	}}