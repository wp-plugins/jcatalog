<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Main_Optimize_scheduler extends Scheduler_Parent_class {



	function process() {


		$db = WPref::load( 'PMAIN_NODE_OPTIMIZEDB' );
		if ( $db ) {
						$mainDatabaseC = WClass::get( 'main.database' );
			$mainDatabaseC->optimizeDB();
		}


				if ( PMAIN_NODE_CLEARCACHE > 0 ) {

			if ( PMAIN_NODE_CLEARCACHE < ( time() - PMAIN_NODE_CLEARCACHEFREQ ) ) {

								$cC = WCache::get();
				$cC->resetCache();

				$mainP = WPref::get( 'main.node' );
				$mainP->updatePref( 'clearcachefreq', time() );

				$this->_cleanCaptchaTable();
			}
		} else {
			$this->_cleanCaptchaTable();
		}
		return true;



	}





	private function _cleanCaptchaTable() {

		if ( ! WPref::load( 'PUSERS_NODE_USECAPTCHA' ) ) return true;

		if ( ! WModel::modelExist( 'main.captcha' ) ) return true;

		$delay = time() - 1800;			$captchaM = WModel::get( 'main.captcha' );
		$captchaM->where( 'created', '<',  $delay );
		$captchaM->delete();

		return true;

	}

}