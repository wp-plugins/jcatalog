<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Theme_Theme_js_files_view extends Output_Listings_class {
function prepareQuery(){

	$tmid=WGlobals::getEID();



	$themeC=WClass::get('theme.helper');

	$objData=$themeC->getFiles( $tmid, 'js', true );



	if( !empty($objData)) $this->addData( $objData );

	else return false;



	return true;

}}