<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Currency_conversion_updateexrate_controller extends WController {


function updateexrate() {





	$siteurl = WController::getFormValue( 'site' );
	$fee = WController::getFormValue( 'fee' );


	$result = false;



	if ( !empty($siteurl) ) {


		
		$curRateC = WClass::get( 'currency.rate' );

		$result = $curRateC->updateExchangeRate( $siteurl, null, null, null, $fee );

	}


	
	$message = WMessage::get();

	if ( $result ) {

		$message->userS('1243943350HCQU');

	} else {

		$message->userW('1243943350HCQV');

	}


	return true;

}}