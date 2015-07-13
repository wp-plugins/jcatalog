<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Vendor_Itemcurrency_picklist extends WPicklist {






function create() {



	static $currenciesA = array();



	if ( empty($currenciesA) ) {



		$multipleCurrency = WPref::load('PCURRENCY_NODE_MULTICUREDIT');



		$curid = $this->getValue( 'curid' );



		$currencyM = WModel::get( 'currency' );

		
		if ( !$multipleCurrency && !empty( $curid ) ) {



			$currenciesA = $currencyM->load( $curid );

			$currenciesA = array( $currenciesA );



		} else {




		    $currencyM->whereE( 'publish', 1 );

			$currencyM->orderBy( 'ordering' );

			$currencyM->setLimit( 500 );



			$currenciesA = $currencyM->load( 'ol', array( 'curid', 'title', 'code', 'symbol') );



		}


	}


	foreach( $currenciesA as $currencies ) {

		$this->addElement( $currencies->curid, $currencies->title . ' ('. $currencies->symbol .')' );

	}


	return true;

}}