<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Main_Update_class extends WClasses {






	public function checkDistribChoice() {


		$distribserver =  WPref::load( 'PAPPS_NODE_DISTRIBSERVER' );

		if ( $distribserver == 99 ) {

						$lastCehckTime = WPref::load( 'PAPPS_NODE_DISTRIBSERVERTIME' );
			$week = 604800;

			if ( ( $lastCehckTime + $week ) < time() ) {
				
				$appsPref = WPref::get( 'apps.node' );
				$appsPref->updatePref( 'distribserver', 1 );

				$cacheHandler = WCache::get();
				$cacheHandler->resetCache( 'Preference' );

			}
		}

	}





	public function backgroundPackageDownload() {

		$eid = WExtension::get( JOOBI_MAIN_APP . '.application', 'wid' );
		
				WGlobals::set( 'update', 'all' );
		WGlobals::set( 'wid', $eid );
		WGlobals::setSession( 'installProcess', 'what', 'multiple' );

		$libProgreC = WClass::get( 'library.progress' );
		$progressO = $libProgreC->get( 'apps' );

				$progressO->run( 'initialize' );
		$progressO->finish();

				$progressO->run( 'downloadPackage' );

		return $progressO->completeProcess();


	}

}