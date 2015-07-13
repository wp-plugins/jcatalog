<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Currency_conversion_cancel_controller extends WController {

	function cancel() {




		$curid = WController::getFormValue( 'curid' );



		WPages::redirect( 'controller=currency-conversion&task=listing&curid='. $curid );

		return true;


	}

}