<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_applypref_controller extends WController {
function applypref() {


	parent::savepref();


	$itemPreferencesC = WClass::get( 'item.preferences' );
	$itemPreferencesC->onSavePref(  $this->generalPreferences  );

	WPages::redirect( 'controller=item&task=preferences' );


	return true;



}}