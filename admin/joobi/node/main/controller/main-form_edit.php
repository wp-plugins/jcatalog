<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_form_edit_controller extends WController {
function edit() {




$mainEditC = WClass::get( 'main.edit' );

if ( !$mainEditC->checkEditAccess() ) return false;





return parent::edit();



}}