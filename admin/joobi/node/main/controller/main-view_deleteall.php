<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_view_deleteall_controller extends WController {

	function deleteall() {


		$mainViewC = WClass::get( 'main.view' );
		$mainViewC->uncoreView();




		$message = WMessage::get();

		$message->userN('1370648536RVAD');



		return parent::deleteall();



	}
}