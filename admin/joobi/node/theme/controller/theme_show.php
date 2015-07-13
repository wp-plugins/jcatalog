<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Theme_show_controller extends WController {
function show(){

	

	
	$eid=WGlobals::getEID();

	$themeM=WModel::get('theme');

	$themeM->whereE( 'tmid', $eid );

	$core=$themeM->load( 'lr', 'core' );

	

	if( $core){

		$message=WMessage::get();

		$message->userW('1329173545MEGR');

		

	}
	return true;

}}