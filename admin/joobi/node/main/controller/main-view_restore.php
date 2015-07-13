<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_view_restore_controller extends WController {

	function restore() {

		$mainViewC = WClass::get( 'main.view' );
		$mainViewC->reRestoreView();

		return true;

	}
}