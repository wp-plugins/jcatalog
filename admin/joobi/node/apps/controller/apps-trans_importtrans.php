<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_trans_importtrans_controller extends WController {

	function importtrans(){


		$trucs=WGlobals::get( 'trucs' );



		$appsSID=WModel::getID( 'apps' );


		if( empty($trucs['x']['trlgid'])){
			return false;
		}


		$translationExportlangC=WClass::get( 'translation.exportlang' );

		
		$contentTranslations=$translationExportlangC->generateManualContent( WController::getFormValue( 'transcontent' ), $trucs[$appsSID]['wid'], $trucs['x']['trlgid'] );



		$translationImportlangC=WClass::get( 'translation.importlang' );

		$translationImportlangC->importDictionary( $contentTranslations, true );
	


		$translationProcessC=WClass::get( 'translation.process' );

		$translationProcessC->setDontForceInsert( false );

		$translationProcessC->handleMessage=false;

		$translationProcessC->triggerPopulate();



		$message=WMessage::get();

		$message->userS('1357567981LCEH');


				$extensionHelperC=WCache::get();
		$extensionHelperC->resetCache();

		WPages::redirect( 'controller=apps-trans' );


		return true;


	}
}