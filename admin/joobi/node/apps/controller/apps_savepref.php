<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Apps_savepref_controller extends WController {


	function savepref(){

				parent::savepref();

		$appSaveprefC=WClass::get( 'apps.savepref' );
		$appSaveprefC->appsSave( $this->generalPreferences );
		WPages::redirect( 'controller=apps' );
		return true;




		
		
	
	
	
																																																									


	}}