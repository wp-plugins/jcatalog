<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'form.textarea' );
class Apps_CoreTransarea_form extends WForm_textarea {

	function create(){



		$wid=WGlobals::getEID();

		$lgid=WGlobals::get( 'trlgid' );



		$translationExportlangC=WClass::get('translation.exportlang');

		$translationExportlangC->getText2Translate( $lgid, $lgid, $wid, false );

		$this->value=$translationExportlangC->createLanguageString();



		return parent::create();



	}

}