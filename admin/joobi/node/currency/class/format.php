<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Currency_Format_class extends WClasses {










	function set() {

		if ( !defined( 'CURRENCY_USED' ) ) {

						$multipleCurrency = WPref::load( 'PCURRENCY_NODE_MULTICUR' );

						if ( empty($multipleCurrency) ) {
				$premiumCurrency = WPref::load('PCURRENCY_NODE_PREMIUM');
				define( 'CURRENCY_USED', $premiumCurrency );
				WGlobals::setSession( 'currency', 'currencyId', $premiumCurrency );
				return true;
			}
			if ( empty($currencyUsed) ) $currencyUsed = WGlobals::getSession( 'iptracker', 'currencyId', null );

			if ( !empty($currencyUsed) ) {

				$currencyHelperC = WClass::get( 'currency.helper', null, 'class', false );
				$accepted = false;
				if ( !empty($currencyFormatC) ) {
					$accepted = $currencyHelperC->isAccepted( $currencyUsed, true );
				}
				if ( !empty( $accepted ) ){
					define( 'CURRENCY_USED', $currencyUsed );
					WGlobals::setSession( 'currency', 'currencyId', $currencyUsed );
					return true;
				}								else $currencyUsed = null;
			}
						if ( empty( $currencyUsed ) ) {

								$localization = WGlobals::getSession( 'iptracker', 'localization', null );
				if ( !empty($localization->currency) ) {
					$currencyIdA = array();
					foreach( $localization->currency as $oneCurrency ) {
						$currencyIdA[] = $oneCurrency->curid;
					}
					$currencyHelperC = WClass::get( 'currency.helper', null, 'class', false );
					$accepted = false;
					if ( !empty($currencyFormatC) ) {
						$accepted = $currencyHelperC->isAccepted( $currencyIdA, true );
					}
					if ( !empty($accepted) ) {
						WGlobals::setSession( 'currency', 'currencyId', $accepted );
						define( 'CURRENCY_USED', $accepted );
						return true;

					}				}			}
			if ( empty( $currencyUsed ) ) {

				$premium = WPref::load( 'PCURRENCY_NODE_PREMIUM' );
				if ( !empty( $premium ) ) {
					define( 'CURRENCY_USED', $premium );
					WGlobals::setSession( 'currency', 'currencyId', $premium );
					return true;
				}
			}
						if ( !defined( 'CURRENCY_USED' ) ) {
				define( 'CURRENCY_USED', 0 );
			}

		}
		return true;

	}






	function load($curid,$returnData='object') {
		static $currencyM = null;
		static $currencyData = array();

		if ( empty($curid) ) return null;

		if ( !isset($currencyData[$curid]) ) {

			if ( !isset($currencyM) ) $currencyM = WModel::get( 'currency');

			if ( is_numeric($curid) ) {
				$currencyM->whereE( 'curid', $curid);
			} else {
				$currencyM->whereE( 'code', $curid);
			}
			$curData = $currencyM->load('o', array ( 'curid', 'code', 'symbol', 'basic', 'title' ) );

			if ( !empty($curData) ) {
				$currencyData[$curid] = $curData;
			}
		}
		if ( isset($currencyData[$curid]) ) {
			if ( $returnData!='object' ) {
				return ( isset($currencyData[$curid]->$returnData) ) ? $currencyData[$curid]->$returnData : null;
			} else {
				return $currencyData[$curid];
			}		} else {
			return null;
		}
	}










	public function displayAmount($amount,$curid=null,$type=1,$vat=null) {


		if ( WGlobals::checkCandy(25) ) {

			if (!defined('PPRODUCT_NODE_CATALOGUE') || !defined('PPRODUCT_NODE_LOGPRICE') ) WPref::get('product.node');
			if (PPRODUCT_NODE_CATALOGUE ) return '';

			$uid = WUser::get('uid');

			if (PPRODUCT_NODE_LOGPRICE && $uid == 0) return '';

		}
				if ($type == 1) {

			if (is_numeric($amount)) {
				if ($amount == 0) {
					return WText::t('1206961944PEUR');

				} else {
					if ($vat != null){
						$printedAmount = $amount+(($vat/100)*$amount);
					}					$printedAmount = WTools::format( $amount, 'currency', $curid );
				}				return $printedAmount;

			}
				}elseif ($type == 2){
			if ($amount == 0){
				return '';
			} else {
				return $amount.'%';
			}		}
	}








	public function SQLizePrice($price) {

				if ( is_numeric($price) || $price === (float)$price ) {
			return 	$price;
		}

				$price = str_replace( ' ', '', $price );

				$last3 = substr( $price, -3 );
		$start = substr( $price, 0, -3 );

				$start = str_replace( array(',','.'), '', $start );

				$countComma = substr_count( $last3, ',' );
		if ( $countComma == 1 ) {
			$last3 = str_replace( ',', '.', $last3 );
			$price = $start . $last3;
		}
		$price = $start . $last3;

		return $price;

	}


















	public function example($content='',$currid=null,$position=null,$brackets=true,$vat=null) {
		$clayout = $this->getCurrency($currid);
		$amount = $this->regionalize('12345.56', $clayout);
		if (isset($position))
			$clayout->position = $position;

		if ($vat !=null) $amount = $this->regionalize((($amount*($vat/100))+$amount), $clayout);
		$amount = $this->symbol($amount, $clayout);
		if ($brackets == true)
			if ($vat == null){
				return $content . ' ' . str_replace(array('$amount'), array($amount),WText::t('1206961945HIVT'));
			}else return $content . ' ' . str_replace(array('$amount','$vat'), array($amount,$vat),WText::t('1213180337NRCV'));
		else
			if ($vat == null){
				return $content . ' ' . $amount;
			}else return $content . ' ' . str_replace(array('$amount','$vat'), array($amount,$vat),WText::t('1213180337NRCW'));

	}
}