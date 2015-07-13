<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Catalog_Itemsorting_picklist extends WPicklist {


function create() {



	
	$choicesorting = WGlobals::get( 'choicesorting' );

	if ( empty($choicesorting) ) $choicesorting = WGlobals::get( 'homeItemsSorting', '', 'global' );



	if ( $choicesorting == 'none' ) return false;



	if ( WRoles::isAdmin( 'storemanager' ) ) { 
		$availableItemsA = array('featured','sold','rated','hits','reviews','newest','highprice','lowprice','alphabetic','reversealphabetic','oldest','endingsoon','recentlyviewed','mytopviewed','recentlyupdated','availabledate', 'justsold');

	} else {	
		$itemSortingPicklist = WGlobals::get( 'itemsSortingPicklist', WPref::load( 'PCATALOG_NODE_ITMAVAILSORT' ), 'global' );

		$availableItemsA = WTools::pref2String( $itemSortingPicklist );

	}


	
	if ( !empty($choicesorting) ) {

		$availableItemsA[]= $choicesorting;

		$this->setDefault( $choicesorting );

	}


	
	$mypicklist = array();


	if ( in_array( 'newest', $availableItemsA ) ) {
		$mypicklist['newest'] = WText::t('1304918557EIYL');
	}

	if ( in_array( 'oldest', $availableItemsA ) ) {
		$mypicklist['oldest'] = WText::t('1307606755CNOQ');
	}
	if ( in_array( 'featured', $availableItemsA ) ) {

		$mypicklist['featured'] = WText::t('1256629159GBCH');

	}


	if ( in_array( 'sold', $availableItemsA ) ) {

		$mypicklist['sold'] = WText::t('1304527165QGOS');

	}


	if ( in_array( 'rated', $availableItemsA ) ) {

		$mypicklist['rated'] = WText::t('1257243215EFTI');

	}


	if ( in_array( 'hits', $availableItemsA ) ) {

		$mypicklist['hits'] = WText::t('1242282415NZTN');

	}


	if ( in_array( 'reviews', $availableItemsA ) ) {

		$mypicklist['reviews'] = WText::t('1257243215EFTU');

	}


	if ( in_array( 'highprice', $availableItemsA ) ) {

		$mypicklist['highprice'] = WText::t('1305198010FCNE');

	}


	if ( in_array( 'lowprice', $availableItemsA ) ) {

		$mypicklist['lowprice'] = WText::t('1305198010FCNF');

	}

	if ( in_array( 'endingsoon', $availableItemsA ) ) {
		$mypicklist['endingsoon'] = WText::t('1412376020TDFY');
	}

	if ( in_array( 'justsold', $availableItemsA ) ) {

		$mypicklist['justsold'] = WText::t('1308888986AJEG');

	}


	if ( in_array( 'alphabetic', $availableItemsA ) ) {

		$mypicklist['alphabetic'] = WText::t('1219769904NDIK');

	}
	if ( in_array( 'reversealphabetic', $availableItemsA ) ) {

		$mypicklist['reversealphabetic'] = WText::t('1307606756SRYP');

	}

	if ( WPref::load( 'PITEM_NODE_RECENTLYVIEWED' ) && in_array( 'recentlyviewed', $availableItemsA ) ) {
		$mypicklist['recentlyviewed'] = WText::t('1420549772RZVB');
	}
	if ( WPref::load( 'PITEM_NODE_RECENTLYVIEWED' ) && in_array( 'mytopviewed', $availableItemsA ) ) {
		$mypicklist['mytopviewed'] = WText::t('1420549772RZVC');
	}
	if ( in_array( 'recentlyupdated', $availableItemsA ) ) {
		$mypicklist['recentlyupdated'] = WText::t('1307606756SRYQ');
	}

	if ( in_array( 'availabledate', $availableItemsA ) ) {
		$mypicklist['availabledate'] = WText::t('1415146133GKRN');
	}

	if ( in_array( 'random', $availableItemsA ) ) {

		$mypicklist['random'] = WText::t('1241592274CBNQ');

	}


	$count = count( $mypicklist );

	if ( empty($count) ) return false;

	elseif ( $count==1 ) {	
		if ( isset($mypicklist[$choicesorting]) ) return false;

	}


	foreach( $mypicklist as $key => $value ) {

		$this->addElement( $key, $value );

	}




	return true;

}}