<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Apps_System_plugin extends WPlugin {




function onAfterRender(){

		if( JOOBI_FRAMEWORK_TYPE !='joomla' ) return true;

	$debugTrace=WGlobals::get( 'debugTraces', '', 'global' );

	if( !empty($debugTrace)){

				if( WUser::isRegistered()){
			$debug=WPref::load( 'PLIBRARY_NODE_DBGERR' );
			$debug=$debug || WPref::load( 'PLIBRARY_NODE_DBGQRY' );
		}else{
			$debug=WPref::load( 'PLIBRARY_NODE_DBGERRGUEST' );
			$debug=$debug || WPref::load( 'PLIBRARY_NODE_DBGQRYGUEST' );
		}
		if( $debug){
			$debugHTML='<div class="clr"></div><div class="debug">';
			$debugHTML .= $debugTrace;
			$debugHTML .= '</div>';

			$body=JResponse::getBody();
			$body .=$debugHTML;
			JResponse::setBody($body);

			WGlobals::set( 'debugTraces', '', 'global', true );				
		}
	}
}
}