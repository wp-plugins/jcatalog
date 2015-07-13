<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_module_query_controller extends WController {







	function query() {


			$dbgqry = WPref::load( 'PLIBRARY_NODE_DBGQRY' );

	WMessage::log( ' Main_module_query_controller 1 ', 'long-time-error-query-turn-on' );
	WMessage::log( $dbgqry , 'long-time-error-query-turn-on' );


		$pref = WPref::get( 'library.node' );

		$pref->updateUserPref( 'dbgqry', ! $dbgqry );

	WMessage::log( ' Main_module_query_controller 1 ', 'long-time-error-query-turn-on' );
	WMessage::log( ! $dbgqry , 'long-time-error-query-turn-on' );

		WPages::redirect( 'previous' );



		return true;


	}
}