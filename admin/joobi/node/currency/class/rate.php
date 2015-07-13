<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Currency_Rate_class extends WClasses {

	
	private $_convertionSiteURL = 'http://themoneyconverter.com/rss-feed/EUR/rss.xml';









public function updateExchangeRate($url,$time=null,$cur_main=null,$cur_ref=null,$fee=0) {





	$rates = null;

	$url = $this->_convertionSiteURL;

		if ( !empty($url) ) $xml = $this->_getForex( $url );
	else $xml = null;

		if ( !empty($xml) ) {

				if ( empty($cur_main) && empty($cur_ref) ) {
						static $currencyM=null;
			if ( empty($currencyM) ) $currencyM = WModel::get( 'currency' );
			$currencyM->whereE( 'publish', 1 );
			$currencies = $currencyM->load( 'ol', array( 'curid', 'code', 'title' ) );
		} else {

			$curA = array();
			$curA[] = $cur_main;
			$curA[] = $cur_ref;

						static $currencyM=null;
			if ( empty($currencyM) ) $currencyM = WModel::get( 'currency' );
			$currencyM->whereIn( 'curid', $curA );
			$currencyM->whereE( 'publish', 1 );
			$currencies = $currencyM->load( 'ol', array( 'curid', 'code', 'title' ) );
		}
		if ( !empty($currencies) ) {
						if ( WPref::load( 'PCURRENCY_NODE_CONVERSIONHISTORY' ) ) $curHistoryUsed = true;
			else $curHistoryUsed = false;

			$exchangeRatesA = $this->_getExchangeRate( $currencies, $xml );

			if ( !empty($exchangeRatesA) ) {
				$passedFee = $fee;
				static $curconverionM=null;
				if ( empty($curconversionM) ) $curconversionM = WModel::get( 'currency.conversion' );

				$exchange = 0;
				foreach( $currencies as $curMain ) {
					foreach( $currencies as $curRef ) {
						$fee = $passedFee;

												$curconversionM->whereE( 'curid', $curMain->curid );
						$curconversionM->whereE( 'curid_ref', $curRef->curid );
						$curr = $curconversionM->load( 'o', array( 'curid','fee') );
												if ( $curMain->curid == $curRef->curid ) $fee = 0;

												$exchange = $this->_calculateExchange( $exchangeRatesA, $currencies, $curMain, $curRef );
						if ( empty($exchange) ) return false;

						if ( !empty($fee)) $rate = $exchange + ( $exchange * ( $fee / 100 ) );
						else $rate = $exchange;

						if ( !empty($exchange) ) {
														$curconversionM->setVal( 'exchange', $exchange );
							$curconversionM->setVal( 'rate', $rate );
							$curconversionM->setVal( 'fee', $fee );
							$curconversionM->setVal( 'publish', 1 );

							if ( empty($time) || ( $time == 0 ) ) $curconversionM->setVal( 'modified', time() );
							else $curconversionM->setVal( 'modified', $time );

							if ( !empty($curr->curid) ) {
								$curconversionM->whereE( 'curid', $curMain->curid );
								$curconversionM->whereE( 'curid_ref', $curRef->curid );
								$curconversionM->update();
							} else {
								$curconversionM->setVal( 'name', $curMain->title .' => '. $curRef->title );
								$curconversionM->setVal( 'alias', $curMain->title .' => '. $curRef->title );
								$curconversionM->setVal( 'curid', $curMain->curid );
								$curconversionM->setVal( 'curid_ref', $curRef->curid );
								$curconversionM->insert();
							}
							if ( $curHistoryUsed ) $this->_rateHistory( $exchange, $curMain, $curRef, $url );
						}
					}				}			}		}	}
	return true;
}






function viewRateHTML($url) {

	$url = $this->_convertionSiteURL;

		if ( !empty($url) ) $xml = $this->_getForex($url);
	else $xml = null;

		if ( !empty($xml) ) $exchangeRates = $this->_getXMLRates( $xml );

		static $currencyM=null;
	if ( empty($currencyM) ) $currencyM = WModel::get( 'currency' );

	$HTML = '<table border="0">';
	if ( !empty($exchangeRates) )
	{
		foreach( $exchangeRates as $rates )
		{
			$HTML .= '<tr><td><br></td>';
						if ( !empty($rates) ) foreach( $rates as $key=>$rate ) $HTML .= '<tr><td>'. $key .'</td><td>'. $rate .'</td></tr>';
			$HTML .= '</tr>';
		}
	} else {

		$HTML .= '<tr><td>'. WText::t('1246516643YYN') .'</td></tr>';
	}	$HTML .= '</table>';

	return $HTML;

}






private function _getForex($url) {

	$data = $this->_getContentPage( $url );

	if ( empty($data) ) {
	  $message = WMessage::get();
	  if (empty($errors)) $errors = 'No data received for '.$url;
	  else $message->userE($errors);
	  return false;
	}

	$xmlHandler = WClass::get( 'library.parser' );
	$xmlParsedArray = $xmlHandler->parse( $data );
	if (!$xmlParsedArray) return false;

	return $xmlParsedArray;

}






private function _getExchangeRate($currencies,$xml) {

		static $codeA=array();
	foreach( $currencies as $curCode ) $codeA[] = $curCode->code;

		static $exchangeRatesA=array();
	static $exchangeRates=array();
	if ( empty($exchangeRates) ) $exchangeRates = $this->_getXMLRates( $xml );
	$getCodeA = array();

		foreach( $exchangeRates as $exchangeRate ) {

		if ( isset($exchangeRate['code']) ) $currencyCode = $exchangeRate['code'];
		elseif ( isset($exchangeRate['currency']) ) $currencyCode = $exchangeRate['currency'];
		else $currencyCode = null;

		if ( !empty($currencyCode) ) {
			if ( in_array( $currencyCode, $codeA ) ) {
				$exchangeRatesA[$currencyCode] = $exchangeRate['rate'];
				$getCodeA[] = $currencyCode;
			}		}	}
			foreach( $codeA as $codes  )
	{
		if ( !in_array( $codes, $getCodeA ) ) $exchangeRatesA[$codes] = 0;
	}
	return $exchangeRatesA;

}





private function _getXMLRates($xmlParsedArrays) {

	return $this->_getXMLRatesThemoneyConverter( $xmlParsedArrays );

}






private function _getCodeFromString($currency) {

	$a = explode( '/', $currency);
	return $a[0];
}





private function _getRateFromString($rate) {

	$tmp = str_replace( '1 Euro = ', '', $rate );
	$explode = explode( ' ',$tmp );
	return $explode[0];

}





private function _getXMLRatesThemoneyConverter($xmlParsedArrays) {
	$xmlRateA=array();

	if ( empty($xmlParsedArrays[0]['children'][0]['children']) ) return false;
	$itemsA = $xmlParsedArrays[0]['children'][0]['children'];
	foreach( $itemsA as $oneCurrency ) {
		if ( empty( $oneCurrency['nodename'] ) || 'item' != $oneCurrency['nodename'] ) continue;
		if ( empty($oneCurrency['children']) ) continue;

		$data = $oneCurrency['children'];
		$newRate = array();
		foreach( $data as $oneEntity ) {

			switch( $oneEntity['nodename'] ) {
				case 'title':
					$currencySymbol = $this->_getCodeFromString( $oneEntity['nodevalue'] );
										if ( strlen($currencySymbol) == 3 ) {
						$newRate['code'] = $currencySymbol;
					}					break;
				case 'pubDate':
					$releaseDate = $oneEntity['nodevalue'];
					$myTime = strtotime( $releaseDate );
					$Three3days = 359200;
					if ( ($myTime + $Three3days) < time() ) {
						$message = Wmessage::get();
						$message->codeE( 'The feed is out of date' );
					}					break;
				case 'description':
					$newRate['description'] = $oneEntity['nodevalue'];
					$newRate['rate'] = $this->_getRateFromString( $oneEntity['nodevalue'] );
					break;
				default:
			}
		}
		if ( empty($newRate['code']) || empty($newRate['rate']) ) continue;

		$xmlRateA[] = $newRate;

	}
	return $xmlRateA;
}















private function _rateHistory($exchange,$curMain,$curRef,$url) {
		static $exchangeSiteID=null;
	if ( empty($exchangeSiteID) ) {
		$exchangeM = WModel::get( 'currency.exchangesite' );
		$exchangeM->whereE( 'url' , $url );
		$exchangeM->whereE( 'publish', 1 );
		$exchangeSiteID = $exchangeM->load( 'r', 'exsiteid' );
	}
		static $curConHistoryM=null;
	if ( empty($curConHistoryM) ) $curConHistoryM = WModel::get( 'currency.conversionhistory' );

	$curConHistoryM->setVal( 'alias', $curMain->title .' => '. $curRef->title );
	$curConHistoryM->setVal( 'exchange', $exchange );
	$curConHistoryM->setVal( 'modified', time() );
	$curConHistoryM->setVal( 'curid', $curMain->curid );
	$curConHistoryM->setVal( 'curid_ref', $curRef->curid );
	$curConHistoryM->setVal( 'exsiteid', $exchangeSiteID );
	$curConHistoryM->insert();

	return true;
}








private function _calculateExchange($exchangeRatesA,$currencies,$curMain,$curRef) {
	static $vendCurid=null;

	$exchange = false;

		if ( empty($vendCurid) ) {
		$currencyHelperC = WClass::get( 'currency.helper' );
		$vendCurid = $currencyHelperC->getCurrencyID( 'EUR' );	
	}
	if ( empty($vendCurid) ) return false;

	
	
				$curMainRate = $this->_cleanRate( $exchangeRatesA[$curMain->code] );
		$curRefRate = $this->_cleanRate( $exchangeRatesA[$curRef->code] );

				if ( $curMain->curid == $curRef->curid )  $exchange = 1;
		else {

						
				if ( $curRef != $vendCurid ) {
					if ( !empty($curMainRate) ) $exchange = ( 1 / $curMainRate ) * $curRefRate;
					else $exchange = 0;
				} else {
					$curCon = $mainRate * $curMainRate;
					if ( !empty($curCon) && ( $curCon != 0 ) ) $exchange = 1 / $curCon;
					else $exchange = 0;
				}

		}

	return $exchange;

}






	private function _cleanRate($receivedRate) {

		return str_replace( array( ',', ' ' ), '', $receivedRate );

	}






private function _getMainRate($exchangeRatesA,$currencies,$mainCode) {

	if ( empty($mainCode) ) $mainCode = $this->_getMainCode( $currencies );
	if ( empty($mainCode) ) return false;

			if ( isset( $exchangeRatesA[$mainCode] ) ) {
		$mainRate = $exchangeRatesA[$mainCode];
		$mainRate = str_replace( array( ',', ' ' ), '', $mainRate );
	} else $mainRate = 1;

		if ( empty($mainRate)) $mainRate = 1;
	else {
				if ( $mainRate != 1 ) $mainRate = 1 / $mainRate;
	}
	return $mainRate;

}






private function _getMainCode($currencies,$vendid=1) {
	static $vendCurid=null;

		$code = null;
	if ( empty($vendCurid) ) {
		$vendorC = WClass::get( 'vendor.helper',null,'class',false );
		if ( !empty($vendorC) ) $vendCurid = $vendorC->getCurrency();
	}
	if ( empty($vendCurid) ) $vendCurid = WUser::get( 'curid' );
	if ( empty($vendCurid) ) return false;

		if ( !empty($currencies) ) {
		foreach( $currencies as $currency ) {
			if ( $currency->curid == $vendCurid ) $code = $currency->code;
		}	}
	return $code;

}








 	private function _getContentPage($URL) {

		if  ( in_array('curl', get_loaded_extensions() ) ) {
			$ch = curl_init( $URL );
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		} elseif ( ini_get('allow_url_fopen') ) {							ob_start();
			$data = file_get_contents($URL);
			$errors = ob_get_clean();
			return $data;
		} else {
			$message = WMessage::get();
			$message->adminE( 'Could not connect to the URL, check your PHP configuration: '.$URL  );
		}
		return false;

 	}
}