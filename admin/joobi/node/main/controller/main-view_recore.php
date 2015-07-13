<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_view_recore_controller extends WController {

	function recore() {



		$mainViewC = WClass::get( 'main.view' );

		$mainViewC->recoreView();



		return true;



	}
}