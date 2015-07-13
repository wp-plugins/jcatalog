<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











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