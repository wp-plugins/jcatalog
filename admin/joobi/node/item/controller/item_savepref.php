<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_savepref_controller extends WController {

	function savepref() {


		parent::savepref();


		$itemPreferencesC = WClass::get('item.preferences');
		$itemPreferencesC->onSavePref( $this->generalPreferences );


		return true;



	}
}