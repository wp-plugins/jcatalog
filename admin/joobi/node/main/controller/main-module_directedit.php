<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_module_directedit_controller extends WController {








function directedit() {



	$directEdit = WPref::load( 'PMAIN_NODE_DIRECT_EDIT' );

	$pref = WPref::get( 'library.node' );

	$pref->updatePref( 'direct_edit', (int)!$directEdit );





	WPages::redirect('previous');



	return true;



}}