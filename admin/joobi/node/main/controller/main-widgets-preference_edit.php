<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_widgets_preference_edit_controller extends WController {
function edit() {



	$libraryCMSMenuC = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );

	$status = $libraryCMSMenuC->editExtensionPreferences();



	if ( empty($status) ) return false;



	return parent::edit();



}}