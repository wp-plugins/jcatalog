<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Currency_Convert_class extends WClasses {

	var $error = '';	

































public function currencyConvert($cur1,$cur2,$amount,$reverseConversion=false,$addFees=true) {

		if ( empty($amount) ) return 0;

	static $curFormatC=null;

	if ( empty( $cur1 ) || empty( $cur2 ) ) {
		$message = WMessage::get();
		$message->codeE( 'One of the currency is not defined! Check your code! function currencyConvert().' );
WMessage::log( 'One of the currency is not defined! Check your code! function currencyConvert().', 'currency-node-defined' );
WMessage::log( 'Currency 1: ' . $cur1 , 'currency-node-defined' );
WMessage::log( 'Currency 2: ' . $cur2 , 'currency-node-defined' );
WMessage::log(  print_r( debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ), true ) , 'currency-node-defined' );

		return WText::t('1341596429OMYB');

	}

	if ( !is_numeric( $amount ) ) {
		if ( !isset($curFormatC) ) $curFormatC = WClass::get( 'currency.format' );
		$amount = $curFormatC->SQLizePrice( $amount );
	}
		









	
	if ( !is_numeric( $cur1 ) ) {
		$cur1 = $this->_getCurrencyID( $cur1 );
		if ( empty($cur1) ) WText::t('1341596429OMYB');

	}


	
	if ( !is_numeric( $cur2 ) ) {

		$cur2 = $this->_getCurrencyID( $cur2 );
		if ( empty($cur2) ) WText::t('1341596429OMYB');
	}


	
	if ( (int)$cur1 == (int)$cur2 ) {

		return $amount;

	}


		

	if ( $amount < 0 ) {
		$negativeNumber = true;
		$amount = -1 * $amount;
	} else {
		$negativeNumber = false;
	}

	
	if ( $reverseConversion ) {

		
		static $vendorC=null;

		if ( empty($vendorC) ) $vendorC = WClass::get('vendor.helper',null,'class',false);

		$vendcurid = $vendorC->getCurrency();



		
		if ( $vendcurid == $cur1 ) $reverseConversion = false;



		
		if ( $reverseConversion ) {

			
			$vendRate = $this->_rateQuery( $vendcurid, $cur1, 'rate' );

			if ( empty($vendRate) ) $vendRate = 1;

		}
	}



	if ( $reverseConversion ) $cur1From = $vendcurid ;

	else $cur1From =  $cur1 ;

	$curRate = $this->_rateQuery( $cur1From, $cur2 );

	if ( !empty($curRate) && !empty($curRate->rate) ) {

		
		if ( $addFees ) {

			$rate = $curRate->rate;

		} else {

			if ( !empty($curRate->fee) ) {

				$curFee = ( $curRate->exchange * $curRate->fee ) / 100;

				$valrate = $curRate->exchange - $curFee;

				$rate = $valrate;

			}
		}
	}

	
	if ( !empty( $rate ) && $rate > 0 ) {



		
		if ( $reverseConversion ) {

			if ( $cur1 == $vendcurid ) $amount *= ( 1 / $rate);

			else {

				$valAmount = $amount / $vendRate;

				$amount = $valAmount * $rate;

			}
		} else {
			$amount *= $rate;
		}



				if ( $negativeNumber ) {
			return ( -1 * $amount );
		} else {
			return $amount;
		}

	} else {
		$message = WMessage::get();
		$currencyHelper = WClass::get( 'currency.helper', null, 'class', false );
		$ORIGIN_CURRENCY = $currencyHelper->getValue( $cur1, 'title' );
		$CONVERTED_CURRENCY = $currencyHelper->getValue( $cur2, 'title' );
		$message->adminE( "The conversion rate between $ORIGIN_CURRENCY and $CONVERTED_CURRENCY is not defined." );
		return WText::t('1341596429OMYB');

	}




	return false;


}


















function acceptedCurrency($curid) {

    static $acceptedcurids  = array();

    static $currencyM = null;



    if ( empty( $curid ) ) return false;

    if ( !empty( $acceptedcurids[ $curid ] ) ) return (bool)$acceptedcurids[ $curid ];



    if ( !isset( $currencyM ) ) $currencyM = WModel::get( 'currency' );

    $currencyM->whereE( 'accepted', 1 );

    $currencyM->whereE( 'curid', $curid );

    $acceptedcurids[ $curid ] = $currencyM->load( 'lr', 'curid' );



    if ( empty( $acceptedcurids[ $curid ] ) ) return false;



    return true;

}
























function convertProductToOrder($price,$curids) {



    if ( empty( $curids ) ) return $price;



    
    foreach( $curids as $curid ) {

        if ( !is_numeric( $curid ) ) return 'Check Currency IDs';



    }


    $converted = $price;



    
    if ( $curids[0] != $curids[1] )

       $converted = $this->currencyConvert( $curids[0], $curids[1], $converted, true, true );



    
    if ( $curids[1] != $curids[2] )

       $converted = $this->currencyConvert( $curids[1], $curids[2], $converted, false, true );



    return $converted;

}























































































































	function returnCurrencyID($currency) {

		
		if ( empty($currency) ) return 0;



		
		if ( is_numeric($currency) ) return $currency;



		
		static $curFormatC=null;

		if ( !isset($curFormatC) ) $curFormatC = WClass::get( 'currency.format' );

		$curFormat = $curFormatC->load( $currency );



		
		$currencyID = ( isset($curFormat->curid) ) ? $curFormat->curid : 0;



		if ( !empty($currencyID) ) return $currencyID;

		else {

			$TEXT = $currency;

			$message = WMessage::get();

			$message->userN('1257240515GXYD');

			$message->adminN( 'Currency passed in returnCurrencyID function failed to get its ID for '. $TEXT );

			return $currency;

		}


		return true;

	}







	private function _getCurrencyID($cur1) {

		$noCurerncy = false;
		if ( !isset($curFormatC) ) $curFormatC = WClass::get( 'currency.format' );
		$curFormat = $curFormatC->load( $cur1 );

		if ( !empty($curFormat) ) {
			$cur1 = $curFormat->curid;
		} else {
			$noCurerncy = true;
		}
		if ( empty($cur1) || $noCurerncy ) {
			$message = WMessage::get();
			$message->codeE( 'The currency does not exist so we could not convert.' );
			return false;
		}
		return $cur1;

	}
















	private function _rateQuery($currencyFrom,$currencyTo,$property=null) {

		static $curRateA = array();


		
		$key = $currencyFrom .'-'. $currencyTo;

		if ( !isset($curRateA[$key]) ) {

			static $currencyConvertM=null;

			if ( !isset($currencyConvertM) ) $currencyConvertM = WModel::get( 'currency.conversion' );
		
			$currencyConvertM->whereE( 'curid', $currencyFrom );

			$currencyConvertM->whereE( 'curid_ref', $currencyTo );

			$currencyConvertM->whereE( 'publish', 1 );

			$curRateA[$key] = $currencyConvertM->load( 'o', array( 'rate', 'exchange', 'fee' ) );

		}


		return ( !isset($property) ) ? $curRateA[$key] :

				( isset( $curRateA[$key]->$property) ? $curRateA[$key]->$property : null );

	}
















	private function _checkAmount($amount,$currencyFrom) {

		
		if ( empty($amount) || ( $amount == 0 ) ) return $amount;

		if ( empty($currencyFrom) ) return $amount;



		
		$checkAmount = WTools::format( $amount, 'price', $currencyFrom );



		
		static $curFormatC=null;

		if ( !isset($curFormatC) ) $curFormatC = WClass::get( 'currency.format' );

		$checkAmount = $curFormatC->SQLizePrice( $checkAmount );



		return $checkAmount;

	}
}