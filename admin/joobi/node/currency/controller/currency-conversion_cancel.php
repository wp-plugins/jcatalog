<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Currency_conversion_cancel_controller extends WController {

	function cancel() {




		$curid = WController::getFormValue( 'curid' );



		WPages::redirect( 'controller=currency-conversion&task=listing&curid='. $curid );

		return true;


	}

}