<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_module_directedit_controller extends WController {








function directedit() {



	$directEdit = WPref::load( 'PMAIN_NODE_DIRECT_EDIT' );

	$pref = WPref::get( 'library.node' );

	$pref->updatePref( 'direct_edit', (int)!$directEdit );





	WPages::redirect('previous');



	return true;



}}