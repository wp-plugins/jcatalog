<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_savepref_controller extends WController {

	function savepref() {


		parent::savepref();


		$itemPreferencesC = WClass::get('item.preferences');
		$itemPreferencesC->onSavePref( $this->generalPreferences );


		return true;



	}
}