<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');





class Item_Producttypelistbe_picklist extends WPicklist {


function create() {

	
	
	static $vendorHelperC = null;

	if ( empty( $vendorHelperC ) ) $vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );

	$vendid = ( $vendorHelperC ) ? $vendorHelperC->traceVendor() : 0;



	static $productTypeM = null;

	if ( empty( $productTypeM ) ) $productTypeM = WModel::get( 'item.type' );


	$productTypeM->makeLJ( 'item.typetrans', 'prodtypid' );

	$productTypeM->select( 'name', 1 );



	if ( $this->onlyOneValue() ) {	


		
		$task = WGlobals::get('task');

		if ( empty($this->defaultValue) && $task=='add' ) $this->defaultValue = WGlobals::get('prodtypid');

		
		if ( empty($this->defaultValue) ) {

			
			
			$itemTypeC = WClass::get('item.type');

			$this->defaultValue = $itemTypeC->getDefaultType( WGlobals::get('controller') );



		}

		$productTypeM->rememberQuery();

		$productTypeM->whereE( 'prodtypid', $this->defaultValue );

		$productTypeName = $productTypeM->load('lr');

		$this->addElement( $this->defaultValue, $productTypeName );

		return true;



	} else {

		static $productTypesA = array();

		
		if ( WGlobals::get('task', 'listing' ) == 'listing' ) {

			$defaultprodtypid = WGlobals::get( 'prodtypid' );

		}


		if ( !isset( $productTypesA[$vendid] ) ) {



			
			$controller = WGlobals::get( 'controller' );

			if ( $controller != 'product' && $controller != 'item-category' ) {

				if ( $controller == 'subscription-created' ) $controller = 'subscription';

				$controller = ucFirst($controller);

				$productDesignationT = WType::get( 'item.designation' );

				$onlyOneType = $productDesignationT->inNames( $controller );

				if ( $onlyOneType ) $productTypeM->whereE( 'type', $productDesignationT->getValue($controller) );

			}


			$productTypeM->makeLJ( 'item.typetrans', 'prodtypid' );

			$productTypeM->whereLanguage(1);

			$productTypeM->select( 'name', 1 );

			$productTypeM->whereE( 'publish', 1 );







			if ( WRoles::isNotAdmin() ) {
				if ( !empty( $vendid ) ) {
					$itemTypeM->whereE( 'vendid', 0, 0, null, 1 );
					$itemTypeM->whereE( 'vendid', $vendid, 0, null, 0, 1, 1 );
				} else $itemTypeM->whereE( 'vendid', 0 );
			} else {
				if ( ! WRole::hasRole( 'vendor' ) ) {
					$message = WMessage::get();
					$message->exitNow( 'Unauthorized access 331' );
				} else {
					if ( !empty( $vendid ) ) {
						$itemTypeM->whereE( 'vendid', 0, 0, null, 1 );
						$itemTypeM->whereE( 'vendid', $vendid, 0, null, 0, 1, 1 );
					} else $itemTypeM->whereE( 'vendid', 0 );
				}			}

			$productTypeM->checkAccess();

			$productTypeM->orderBy( 'ordering' );
			$productTypeM->orderBy( 'type' );

			$productTypeM->setLimit( 500 );

			$productTypesA[$vendid] = $productTypeM->load( 'ol', array( 'prodtypid', 'namekey', 'type' ) );

		}


	}


	if ( empty( $productTypesA[$vendid] ) ) {

		$message = WMessage::get();

		$message->userE('1298350868MINW');

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