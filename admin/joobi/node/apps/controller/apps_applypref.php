<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Apps_applypref_controller extends WController {

	function applypref(){



		parent::savepref();



		$appSaveprefC=WClass::get( 'apps.savepref' );
		$appSaveprefC->appsSave( $this->generalPreferences );


		WPages::redirect( 'controller=apps&task=preferences' );

		return true;



	}
}