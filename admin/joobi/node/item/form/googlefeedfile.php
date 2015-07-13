<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'form.textonly' );
class Item_CoreGooglefeedfile_form extends WForm_textonly {


	function create() {



		$token = WPage::frameworkToken();



		$filename = 'products_feed_' . $token . '.xml';

		$path = JOOBI_DS_EXPORT . $filename;

		$urlpath =  JOOBI_URL_EXPORT . $filename;



		$fileC = WGet::file();

		$exists = $fileC->exist( $path );

		if ( $exists ) {

			$modtime = filemtime( $path );

			$this->content =  '<a href="'.$urlpath.'"> '. $filename . '</a> <em>( ' .WText::t('1310010293JWDN') . ': ' .  WApplication::date( WTools::dateFormat( 'date-time' ), $modtime ) . ' )</em>';

		}

		else $this->content = $filename . '  <em>( '. WText::t('1310010293JWDO') .' )</em>';



		return true;

	}}