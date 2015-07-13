<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
/**
* @link joobi.co
* @copyright Copyright (c) 2007-2015 Joobi Limited All rights reserved.
* This file is released under the GPL (General Public License)
*/
class Inc_Lib_Archivetar_include {

/** Constructor */
	function __construct() {
		if ( !class_exists('Archive_Tar') ) {
//			WExtension::includes( 'lib.pear' );
			require( JOOBI_DS_INC . 'lib' . DS . 'archivetar' .DS. 'tar.php' );
		}//endif
	}//endfct
}//endclass

