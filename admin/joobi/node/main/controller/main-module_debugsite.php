<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_module_debugsite_controller extends WController {






function debugsite() {



	$dbgqry = WPref::load( 'PLIBRARY_NODE_DBGERR' );

	$pref = WPref::get( 'library.node' );

	$pref->updateUserPref( 'dbgerr', ! $dbgqry );

	WPages::redirect( 'previous' );



	return true;


}
}