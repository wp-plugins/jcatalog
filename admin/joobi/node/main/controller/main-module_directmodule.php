<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_module_directmodule_controller extends WController {








function directmodule() {



	$directEdit = WPref::load( 'PMAIN_NODE_DIRECT_EDIT_MODULES' );

	$pref = WPref::get( 'library.node' );

	$pref->updatePref( 'direct_edit_modules', (int)!$directEdit );

	WPages::redirect( 'previous' );



	return true;



}}