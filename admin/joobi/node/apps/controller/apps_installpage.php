<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Apps_installpage_controller extends WController {

	function installpage(){



				$app=WGlobals::get( 'app' );

		$addPage=WGlobals::get( 'addPage' );

		if( empty( $needPage )){
			$appPref=WPref::get( $app . '.application' );
			$appPref->updatePref( 'install_page', 2 );				WPref::override( strtoupper($app) . '_APPLICATION_INSTALL_PAGE', 2 );
		}
		if( $addPage){
			
						WApplication_wp4::renderFunction( "install", "install", $app );

		}
						WPages::redirect( 'controller=' . $app );	

		return true;



	}
}