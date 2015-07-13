<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Currency_Formcurrency_picklist extends WPicklist {






	function create() {

		static 	$currenciesA = array();



		
		if ( WRoles::isNotAdmin() ) {



			$multipleCurency = WPref::load( 'PCURRENCY_NODE_MULTICUREDIT' );

			if ( !$multipleCurency ) {



			   if ( !defined('CURRENCY_USED') ) {

				    $currencyFormatC = WClass::get('currency.format',null,'class',false);

				    $currencyFormatC->set();

			   }


				$currencyHelper = WClass::get( 'currency.helper', null, 'class', false );



				$this->addElement( CURRENCY_USED, $currencyHelper->getValue( CURRENCY_USED, 'title' ) . ' ('. $currencyHelper->getValue( CURRENCY_USED, 'symbol' ) .')' );



				return true;

			}


		}




		if ( empty($currenciesA) ) {

			if ( !isset($currencyM) ) $currencyM = WModel::get( 'currency' );

		
			$currencyM->whereE( 'publish', 1 );

			$currencyM->orderBy( 'ordering' );

			$currencyM->setLimit( 500 );

			$currenciesA = $currencyM->load( 'ol', array( 'curid', 'title', 'code', 'symbol') );



		}


		if ( !empty($currenciesA) ) {

			foreach( $currenciesA as $currencies ) {

				$this->addElement( $currencies->curid, $currencies->title . ' ('. $currencies->symbol .')' );

			}
		}


		return true;


	}
}