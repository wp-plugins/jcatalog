<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Apps_savepref_controller extends WController {


	function savepref(){

				parent::savepref();

		$appSaveprefC=WClass::get( 'apps.savepref' );
		$appSaveprefC->appsSave( $this->generalPreferences );
		WPages::redirect( 'controller=apps' );
		return true;




		
		
	
	
	
																																																									


	}}