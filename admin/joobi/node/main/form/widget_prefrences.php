<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.layout' );
class Main_CoreWidget_prefrences_form extends WForm_layout {

	function create() {



		$frameworkType = $this->getValue( 'namekey', 'main.widgettype' );



		$viewNamekey = str_replace( '.', '_', $frameworkType );



		$viewNamekeyModule = $viewNamekey . '_widget';

		$yid = WView::get( $viewNamekeyModule, 'yid', null, null, false );


				if ( empty($yid) ) {

			$viewNamekeyWidget = $viewNamekey . '_module';

			$yid = WView::get( $viewNamekeyWidget, 'yid', null, null, false );

		}




		if ( empty($yid) ) {


			return false;

		}


		$this->viewID = $yid;



		return parent::create();



	}
}