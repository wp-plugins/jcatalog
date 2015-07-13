<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_view_save_controller extends WController {
function save() {



	
	$mainEditC = WClass::get( 'main.edit' );

	if ( !$mainEditC->checkEditAccess() ) return false;

	

	return parent::save();



}}