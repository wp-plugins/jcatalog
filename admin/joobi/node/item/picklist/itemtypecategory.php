<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_Itemtypecategory_picklist extends WPicklist {

function create() {



	
	
	static $vendorHelperC = null;

	if ( empty( $vendorHelperC ) ) $vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );

	$vendid = ( $vendorHelperC ) ? $vendorHelperC->traceVendor() : 0;



	static $itemTypeM = null;

	if ( empty( $itemTypeM ) ) $itemTypeM = WModel::get( 'item.type' );




	static $productTypesA = array();

		
		if ( WGlobals::get('task', 'listing' ) == 'listing' ) {

			$defaultprodtypid = WGlobals::get( 'prodtypid' );

		}


		if ( !isset( $productTypesA[$vendid] ) ) {



			$itemTypeM->makeLJ( 'item.typetrans', 'prodtypid' );

			$itemTypeM->select( 'name', 1 );



			
			$controller = WGlobals::get( 'controller' );

			if ( $controller != 'product' && $controller != 'item-category' ) {

				if ( $controller == 'subscription-created' ) $controller = 'subscription';

				$controller = ucFirst($controller);

				$productDesignationT = WType::get( 'item.designation' );

				$onlyOneType = $productDesignationT->inNames( $controller );

				if ( $onlyOneType ) $itemTypeM->whereE( 'type', $productDesignationT->getValue($controller) );

			}


			$itemTypeM->makeLJ( 'item.typetrans', 'prodtypid' );

			$itemTypeM->whereLanguage(1);

			$itemTypeM->select( 'name', 1 );





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
					}				}			}


			$itemTypeM->checkAccess();

			$itemTypeM->checkAccess( 0, 0, 0, 0, 'rolid_edit' );

			$itemTypeM->orderBy( 'ordering' );

			$itemTypeM->orderBy( 'type' );
			$itemTypeM->setLimit( 500 );

			$productTypesA[$vendid] = $itemTypeM->load( 'ol', array( 'prodtypid', 'namekey', 'type' ) );

		}




	if ( empty( $productTypesA[$vendid] ) ) {

		return false;
	}


	$total = count($productTypesA[$vendid]);



	$this->addElement( 0, '- ' . WText::t('1327708944HAPH') . ' -' );	




	if ( !empty( $productTypesA[$vendid] ) ) {



		
		
		$prodDesignationT = WType::get( 'item.designation' );



		$firstWord = null;

		$previousWord = null;

		$defaultText = '';

		foreach( $productTypesA[$vendid] as $productType ) {

			$productTypeID = $productType->prodtypid;

			$productTypeName = $productType->name;

			$designationName = $prodDesignationT->getTranslatedName( $productType->type );


			if ( $total > 1 ) {

				$firstWord = $designationName;

				if ( $firstWord != $previousWord  ) {

					$this->addElement( -1, '-- '. $firstWord );

					$previousWord = $firstWord;

				}


			}


			if ( !empty($defaultprodtypid) && $defaultprodtypid == $productTypeID ) $defaultText = $productTypeName;

			
			$this->addElement( $productTypeID, $productTypeName );

		}


		if ( !empty($defaultText) ) WGlobals::set( 'titleheader', $defaultText );

	}
	return true;



}}