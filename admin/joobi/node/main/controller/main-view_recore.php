<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Main_view_recore_controller extends WController {

	function recore() {



		$mainViewC = WClass::get( 'main.view' );

		$mainViewC->recoreView();



		return true;



	}
}