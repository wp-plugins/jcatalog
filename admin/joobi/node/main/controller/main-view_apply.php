<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_view_apply_controller extends WController {
function apply() {



	
	$mainEditC = WClass::get( 'main.edit' );

	if ( !$mainEditC->checkEditAccess() ) return false;

	

	return parent::apply();



}}