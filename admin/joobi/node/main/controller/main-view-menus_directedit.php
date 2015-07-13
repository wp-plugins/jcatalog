<?php 

* @link joobi.co
* @license GNU GPLv3 */



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