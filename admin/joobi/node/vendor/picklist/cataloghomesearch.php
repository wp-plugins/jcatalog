<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Vendor_Cataloghomesearch_picklist extends WPicklist {




function create() {



	$vendorsM = WModel::get( 'vendor' );

	$vendorsM->makeLJ( 'vendortrans', 'vendid' );

	$vendorsM->whereLanguage();


	$vendorsM->select( 'vendid', 0 );

	$vendorsM->select( 'name', 1 );

	$vendorsM->whereE( 'publish', 1 );

	$vendorsM->orderBy( 'name', 'ASC', 1 );

	$vendorsM->setLimit( 5000 );

	$vendorsA = $vendorsM->load( 'ol' );

	

	if ( count($vendorsA) > 4995 ) {

		$message = WMessage::get();

		$message->codeE( 'There are more than 5000 vendors, the list has been limited to 5000, you probably dont want this picklist if you have so many vendors has it will slow down your site considerably.' );

		return false;

	}
	

	if ( !empty($vendorsA) ) {

		$this->addElement( 0,  '- ' . WText::t('1340148798CAVD') . ' -' );	
		foreach( $vendorsA as $vendors ) {

			$this->addElement( $vendors->vendid, $vendors->name );

		}
	} else {

		return false;

	}
	

	return true;

	

}}