<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_view_save_controller extends WController {
function save() {



	
	$mainEditC = WClass::get( 'main.edit' );

	if ( !$mainEditC->checkEditAccess() ) return false;

	

	return parent::save();



}}