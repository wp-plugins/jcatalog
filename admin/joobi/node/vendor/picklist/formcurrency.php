<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Vendor_Formcurrency_picklist extends WPicklist {






function create() {



		if ( WRoles::isNotAdmin( 'storemanager' ) ) {

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


	static	$currenciesA = array();



	if ( empty($currenciesA) ) {



		if ( !isset($currencyM) ) $currencyM = WModel::get( 'currency' );


	    $currencyM->whereE( 'publish', 1 );

		$currencyM->orderBy( 'ordering' );

		$currencyM->setLimit( 500 );



		$currenciesA = $currencyM->load( 'ol', array( 'curid', 'title', 'code', 'symbol') );



	}



	
	$iptrackerInstalled = WExtension::exist( 'iptracker.node' );



	if ( $iptrackerInstalled && WGlobals::checkCandy(50) ) {

		
		$iptrackerLookupC = WClass::get('iptracker.lookup');



		$localCTYID = $iptrackerLookupC->ipInfo( null, 'currency' );



		if ( !empty($localCTYID) ) {

			if ( !empty($localCTYID[0]->curid) )  $this->setDefault( $localCTYID[0]->curid );

		}
	}






	if ( !empty($currenciesA) ) {

		foreach( $currenciesA as $currencies ) {

			$this->addElement( $currencies->curid, $currencies->title . ' ('. $currencies->symbol .')' );

		}
	}


	return true;



}}