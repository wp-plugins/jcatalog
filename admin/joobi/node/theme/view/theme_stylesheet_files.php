<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Theme_Theme_stylesheet_files_view extends Output_Listings_class {
function prepareQuery(){

	$tmid=WGlobals::getEID();



	$themeC=WClass::get('theme.helper');

	$objData=$themeC->getFiles( $tmid, 'css', true );



	if( !empty($objData)) $this->addData( $objData );

	else return false;



	return true;

}}