<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Vendor_Listpublishvendors_picklist extends WPicklist {


function create() {

	
	
	static $vendorHelperC = null;

	if ( empty( $vendorHelperC ) ) $vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );

	$vendid = ( $vendorHelperC ) ? $vendorHelperC->traceVendor() : 0;



	static $vendorM=null;

	if ( !isset($vendorM) ) $vendorM = WModel::get( 'vendor' );
	$vendorM->makeLJ( 'users', 'uid', 'uid', 0, 1 );
	$vendorM->makeLJ( 'vendortrans', 'vendid', 'vendid', 0, 2 );
	$vendorM->whereLanguage( 2 );
	$vendorM->select( 'name', 1, 'memname' );

	$vendorM->select( 'name', 2, 'name' );
	$vendorM->whereE( 'publish', 1 );

	if ( !empty( $vendid ) ) $vendorM->whereE( 'vendid', $vendid );

	$vendorM->orderBy( 'name', 'ASC', 1 );

	$vendorM->setLimit( 10000 );

	$vendorsA = $vendorM->load( 'ol', array( 'vendid' ) );

	

	if ( count($vendorsA) > 1 ) {

		$text = WText::t('1298350804GFLC');

		$this->addElement( 0, $text );

	}
		

	if ( !empty($vendorsA) ) {

		$firstLetter = null;

		$previousLetter = null;

		foreach( $vendorsA as $vendors ) {

			$text = isset( $vendors->memname ) ? $vendors->memname : null;

			

			$firstLetter = !empty( $text ) ? strtolower( substr( $text, 0, 1 ) ) : '#';

			if ( $firstLetter != $previousLetter  ) { 

				$this->addElement( -1, '-- '. strtoupper( $firstLetter ) .' ----' );

				$previousLetter = $firstLetter;

			}
			

			if ( !empty($vendors->name) ) $text .= ' ( '. $vendors->name .' )';

			$this->addElement( $vendors->vendid, $text );

		}
	} else { 

		$text = WText::t('1298350804GFLD');

		$this->addElement( 1, $text );

	}
	

	return true;

}}