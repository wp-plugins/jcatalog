<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Normalsearch_class extends WClasses {





	function query() {


				$searchItem = WController::getFormValue( 'search' );
		if ( $searchItem == WText::t('1206732365OQJI') . '...' ) $searchItem = '';
		$searchItem = trim( $searchItem );

		$vendid = WController::getFormValue( 'vendid' );
		$prodtypid = WController::getFormValue( 'prodtypid' );
		$catid = WController::getFormValue( 'catid' );
		$searchlocation = WController::getFormValue( 'location' );

		$zipcode = WController::getFormValue( 'zipcode' );
		if ( $zipcode == WText::t('1398702488PGTJ') ) $zipcode = '';

		$country = WController::getFormValue( 'country' );
		$searchradius = WController::getFormValue( 'radius' );

		$catidPrint = '';
		$vendidPrint = '';
		$prodtypidPrint = '';
		$searchradius = '';
		$itemSearch = '';
		$zipCodePrint = '';
		$countryPrint = '';
		$searchPrint = '';
		$radiusPrint = '';
		$locationPrint = '';



		if ( !empty($searchlocation) ) $locationPrint = '&location=' . $searchlocation;
		if ( !empty($zipcode) ) $zipCodePrint = '&zipcode=' . $zipcode;
		if ( !empty($country) ) $countryPrint = '&country=' . $country;

		if ( !empty($catid) ) $catidPrint = '&catid=' . $catid;
		if ( !empty($vendid) ) $vendidPrint = '&vendid=' . $vendid;
		if ( !empty($prodtypid) ) $prodtypidPrint = '&prodtypid=' . $prodtypid;
		if ( !empty($searchItem) ) $searchPrint = '&search=' . $searchItem;

		WPages::redirect( 'controller=catalog-results' . $searchPrint . $locationPrint . $catidPrint . $vendidPrint . $prodtypidPrint . $itemSearch . $zipCodePrint . $countryPrint );


		return true;

	}








}