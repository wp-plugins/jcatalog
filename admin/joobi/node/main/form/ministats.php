<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















WView::includeElement( 'form.layout' );
class WForm_Coreministats extends WForm_layout {	




	function create() {

		WGlobals::set( 'reportHeaderType', 'main_report_header_mini', 'global' );
		WGlobals::set( 'presetdate', 42 );
		WGlobals::set( 'interval', 15 );
		WGlobals::set( 'nested_jdoctype', 220 );
		WGlobals::set( 'graphWidth', 400, 'global' );
		WGlobals::set( 'showTitleHeader', false, 'global' );

		return parent::create();

	}
}

