<?php 

* @link joobi.co
* @license GNU GPLv3 */



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