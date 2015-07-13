<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Currency_Helper_class extends WClasses {















	 function getValue($curid,$columnA=array()) {



	 	if ( empty($curid) ) {	
	 		return $this->adminW( 'Please check currency parameters' );

	 	}


	 	
	 	static $currencyA=array();

	 	if ( !isset($currencyA[$curid]) ) {

	 		
	 		
	 		
	 		





		 	$currencyA[$curid] = WModel::getElementData( 'currency', $curid );


		}


	 	return ( is_array($columnA) ) ? $currencyA[$curid] : $currencyA[$curid]->$columnA;

	 }









	 function getCurrencyID($curCode) {
	 	static $currencies = array();

	 	if ( empty( $curCode ) ) return false;

	 	if ( empty( $currencies[ $curCode ] ) ) {
	 		static $currencyM = null;
	 		if ( !isset($currencyM) ) $currencyM = WModel::get( 'currency' );
	 		$currencyM->whereE( 'code', $curCode );
	 		$currencies[ $curCode ] = $currencyM->load( 'lr', 'curid' );
	 	}
	 	return $currencies[ $curCode ];
	 }












	 function isAccepted($curid,$onlyPublished=false) {

	 	static $currencyM = null;
	 	$resultA = null;


	 		 	if ( !is_array($curid) ) $curid = array($curid);

	 	$key = serialize($curid);

	 	if ( !isset($resultA[$key][$onlyPublished]) ) {

		 	if ( !isset($currencyM) ) $currencyM = WModel::get( 'currency' );
			$currencyM->whereIn( 'curid', $curid );
			if (!$onlyPublished) $currencyM->whereE( 'accepted', 1 );
			$currencyM->whereE( 'publish', 1 );
			$result = $currencyM->load( 'r', 'curid' );

			$resultA[$key][$onlyPublished] = ( !empty($result) && ( $result > 0 ) ) ? true : false;

	 	}
		return $resultA[$key][$onlyPublished];

	 }
	 






	 function setPublishAccepted($curid,$publish=1,$accepted=1) {

	 	if ( empty( $curid ) ) return false;

	 	$currencyM = WModel::get( 'currency' );

	 		 	if ( !$currencyM->exist( $curid ) ) return false;

	 	$currencyM->setVal( 'publish', $publish );
	 	$currencyM->setVal( 'accepted', $accepted );
	 	$currencyM->whereE( 'curid', $curid );
	 	return $currencyM->update();

	 }









	 public function getforNumber($number,$columnA=array()) {

	 	if ( empty($number) ) return false;

	 	$currencyA=array();

        $currencyM = WModel::get( 'currency' );
        $currencyM->whereE( 'number', $number );
		$currencyA[$number] = $currencyM->load( 'o' );


	 	return ( is_array($columnA) ) ? $currencyA[$number] : $currencyA[$number]->$columnA;
	 }
}