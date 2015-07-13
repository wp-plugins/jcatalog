<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_view_menus_directedit_controller extends WController {
function directedit() {



	$prefM = WPref::get('library.node' );

	$directEdit = WPref::load( 'PMAIN_NODE_DIRECT_EDIT' );

	if ( $directEdit ) {

		$prefM->updatePref( 'direct_edit', 0 );

	} else {

		$prefM->updatePref( 'direct_edit', 1 );

	}
	

	$extensionHelperC = WCache::get();

	$extensionHelperC->resetCache( 'Preference' );

		

	return true;



}}