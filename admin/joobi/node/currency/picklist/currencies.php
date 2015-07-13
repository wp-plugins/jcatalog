<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Currency_Currencies_picklist extends WPicklist {












	function create() {



		if ( $this->onlyOneValue() ) {

			if ( !empty($this->defaultValue) ) {
				$currencyM = WModel::get( 'currency');
				$currencyM->select('curid');
				$currencyM->select('title');
				$currencyM->select('symbol');
				$currencyM->rememberQuery();
				$currencyM->whereE( 'curid', $this->defaultValue );
				$currenciesO = $currencyM->load('o');

				if ( !empty($currenciesO->symbol) ) {
					$this->addElement($currenciesO->curid, $currenciesO->title .' ('. $currenciesO->symbol .')');
				} else {
					$this->addElement($currenciesO->curid, $currenciesO->title );
				}
			} else {
				$this->addElement( 0, WText::t('1252894493BAJT') );
			}

			return true;

		}

		$currencyM = WModel::get( 'currency');

		$currencyM->select('curid');

		$currencyM->select('title');

		$currencyM->select('symbol');

		$currencyM->whereE( 'publish', 1 );

		$currencyM->orderBy('curid');

		$currencies = $currencyM->load('ol');



		if ( !empty($currencies) ) {

			$defaultCurrency = 0;

			$prefCur = WPref::load( 'PCURRENCY_NODE_PREMIUM' );



			if ( !empty( $prefCur ) ) $defaultCurrency = $prefCur;



			if ( empty($defaultCurrency) && !defined('CURRENCY_USED') ) {

				$currencyFormatC = WClass::get('currency.format',null,'class',false);

				$currencyFormatC->set();

				$prefCur = CURRENCY_USED;

				$defaultCurrency = !empty($prefCur) ? CURRENCY_USED : 1;

			}


			if ( empty($defaultCurrency) ) $defaultCurrency = 1;



			$this->setDefault( $defaultCurrency );



			foreach( $currencies as $currencie ) {



				if ( !empty($currencie->symbol) ) {

					$this->addElement($currencie->curid, $currencie->title .' ('. $currencie->symbol .')');

				} else {

					$this->addElement($currencie->curid, $currencie->title );

				}


			}
		}


	}}