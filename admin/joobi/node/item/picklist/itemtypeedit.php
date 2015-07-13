<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_Itemtypeedit_picklist extends WPicklist {

function create() {

	
	
	static $vendorHelperC = null;

	if ( empty( $vendorHelperC ) ) $vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );

	$vendid = ( $vendorHelperC ) ? $vendorHelperC->traceVendor() : 0;



	static $itemTypeM = null;

	if ( empty( $itemTypeM ) ) $itemTypeM = WModel::get( 'item.type' );


	$itemTypeM->makeLJ( 'item.typetrans', 'prodtypid' );

	$itemTypeM->select( 'name', 1 );



	
	if ( $this->onlyOneValue() ) {	
		
		$task = WGlobals::get('task');

		if ( empty($this->defaultValue) && $task=='add' ) $this->defaultValue = WGlobals::get('prodtypid');

		
		if ( empty($this->defaultValue) ) {

			
			
			$itemTypeC = WClass::get('item.type');

			$this->defaultValue = $itemTypeC->getDefaultType( WGlobals::get('controller') );



		}



		$itemTypeM->rememberQuery();

		$itemTypeM->whereE( 'prodtypid', $this->defaultValue );

		$productTypeName = $itemTypeM->load('lr');

		$this->addElement( $this->defaultValue, $productTypeName );

		return true;

	} else {

		static $productTypesA = array();

		
		if ( WGlobals::get('task', 'listing' ) == 'listing' ) {

			$defaultprodtypid = WGlobals::get( 'prodtypid' );

		}


		if ( !isset( $productTypesA[$vendid] ) ) {



			



















			$itemTypeM->makeLJ( 'item.typetrans', 'prodtypid' );

			$itemTypeM->whereLanguage(1);

			$itemTypeM->select( 'name', 1 );

			$itemTypeM->whereE( 'publish', 1 );





			if ( WRoles::isNotAdmin() ) {

				if ( !empty( $vendid ) ) {

					$itemTypeM->whereE( 'vendid', 0, 0, null, 1 );

					$itemTypeM->whereE( 'vendid', $vendid, 0, null, 0, 1, 1 );

				} else $itemTypeM->whereE( 'vendid', 0 );

			} else {

				if ( ! WRole::hasRole( 'vendor' ) ) {

					$message = WMessage::get();

					$message->exitNow( 'Unauthorized access 334' );

				} else {

					if ( !empty( $vendid ) ) {

						$itemTypeM->whereE( 'vendid', 0, 0, null, 1 );

						$itemTypeM->whereE( 'vendid', $vendid, 0, null, 0, 1, 1 );

					} else $itemTypeM->whereE( 'vendid', 0 );

				}
			}


			$itemTypeM->checkAccess( 0, 0, 0, 0, 'rolid_edit' );

			$itemTypeM->orderBy( 'ordering' );

			$itemTypeM->orderBy( 'type' );

			$itemTypeM->setLimit( 500 );

			$productTypesA[$vendid] = $itemTypeM->load( 'ol', array( 'prodtypid', 'namekey', 'type' ) );

		}


	}


	if ( empty( $productTypesA[$vendid] ) ) {


		return false;

	}



	if ( count($productTypesA[$vendid]) == 1 ) {



		$formInstance = WView::form( $this->formName );

		$formInstance->hidden( $this->name, $productTypesA[$vendid][0]->prodtypid, false, true );



		return false;



	} else {

		$this->addElement( 0, '- ' . WText::t('1298350868MINX') . ' -' );

	}


	if ( !empty( $productTypesA[$vendid] ) ) {



		
		
		$prodDesignationT = WType::get( 'item.designation' );



		$firstWord = null;

		$previousWord = null;

		$defaultText = '';


		foreach( $productTypesA[$vendid] as $productType ) {


			$productTypeID = $productType->prodtypid;

			$productTypeName = $productType->name;

			$designationName = $prodDesignationT->getTranslatedName( $productType->type );



			$firstWord = $designationName;

			if ( $firstWord != $previousWord  ) {

				$this->addElement( -1, '-- '. $firstWord );

				$previousWord = $firstWord;

			}

			if ( !empty($defaultprodtypid) && $defaultprodtypid == $productTypeID ) $defaultText = $productTypeName;

			
			$this->addElement( $productTypeID, $productTypeName );

		}


		if ( !empty($defaultText) ) WGlobals::set( 'titleheader', $defaultText );

	}
	return true;



}}