<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_view_restore_controller extends WController {

	function restore() {

		$mainViewC = WClass::get( 'main.view' );
		$mainViewC->reRestoreView();

		return true;

	}
}