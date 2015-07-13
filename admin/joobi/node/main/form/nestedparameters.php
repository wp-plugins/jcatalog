<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.layout' );
class Main_Corenestedparameters_form extends WForm_Corelayout {
function create() {



	
	$namekey = $this->getValue( 'namekey', 'main.widgettype' );



	$viewNamekey = str_replace( '.', '_', $namekey );

	$viewNamekeyTag = $viewNamekey . '_widget';





	
	$yid = WView::get( $viewNamekeyTag, 'yid', null, null, false );



	if ( empty($yid) ) {

		
		$viewNamekeyTag = $viewNamekey . '_module';



		
		$yid = WView::get( $viewNamekeyTag, 'yid', null, null, false );



	}




	if ( !empty($yid) ) {

		$this->viewID = $yid;

		return parent::create();

	} else {


		return false;

	}


}}