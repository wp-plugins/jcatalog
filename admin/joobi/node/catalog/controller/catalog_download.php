<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_download_controller extends WController {


	function download() {


		
		$trucs = WGlobals::get( 'trucs' );

		$modelID = WModel::getID( 'item' );



		$pid = ( isset($trucs[$modelID]['pid']) ) ? $trucs[$modelID]['pid'] : 0;

		$status = 1;



		$pid = ( !empty($pid) ) ? $pid : WGlobals::getEID();



		if ( empty($pid) ) return false;




		$catalogDownloadC = WClass::get( 'catalog.download' );
		$catalogDownloadC->downloadFile( $pid );



		return true;


	}}