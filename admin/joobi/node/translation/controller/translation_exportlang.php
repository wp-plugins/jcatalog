<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Translation_exportlang_controller extends WController {


function exportlang(){



	$trucs=WGlobals::get( 'trucs' );
	$originlgid=$trucs['x']['olgid'];
	$destinationlgid=$trucs['x']['lgid'];
	$export=$trucs['x']['export'];
	$wid=$trucs['x']['wid'];
	$format=(!empty($trucs['x']['format'])) ? $trucs['x']['format'] : 'ini';







	$translationExportlangC=WClass::get('translation.exportlang');
	$contentExist=$translationExportlangC->getText2Translate( $originlgid, $destinationlgid, $wid, $export );


	if( $contentExist){
		if( $format=='html'){
			return $translationExportlangC->generateHtmlFile();

		}else{				return $translationExportlangC->generateIniFile();
		}	}

	$message=WMessage::get();

	$message->userN('1227580123BQHZ');

	return true;



}}