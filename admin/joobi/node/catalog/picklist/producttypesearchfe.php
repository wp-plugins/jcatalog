<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Catalog_Producttypesearchfe_picklist extends WPicklist {
	function create() {

		
		


		
		$itemType = WGlobals::get( 'type' );

		if ( !empty($itemType) ) return false;



			$productTypeM = WModel::get( 'item.type' );


			$productTypeM->makeLJ( 'item.typetrans', 'prodtypid' );

			$productTypeM->select( 'name', 1 );

			$productTypeM->whereE( 'searchable', 1 );



			if ( $this->onlyOneValue() ) {
				$productTypeM->rememberQuery();

				$productTypeM->whereE( 'prodtypid', $this->defaultValue );

				$productTypeName = $productTypeM->load('lr');

				$this->addElement( $this->defaultValue, $productTypeName );

				return true;

			} else {

				
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


























				$productTypeM->checkAccess();
				$productTypeM->orderBy( 'ordering' );

				$productTypeM->orderBy( 'type' );

				$productTypeM->setLimit( 500 );

				$productTypesA = $productTypeM->load( 'ol', array( 'prodtypid', 'namekey', 'type' ) );

			}




		if ( empty( $productTypesA ) ) {

			$message = WMessage::get();

			$message->userE('1298350868MINW');

			return false;

		}


		if ( count($productTypesA) == 1 ) {

			$formInstance = WView::form( $this->formName );

			$formInstance->hidden( $this->name, $productTypesA[0]->prodtypid, false, true );

			return false;

		} else {

			$this->addElement( 0, '- ' . WText::t('1304253944ERYB') . ' -' );



		}


		if ( !empty( $productTypesA ) ) {



			
			
			$prodDesignationT = WType::get( 'item.designation' );



			$firstWord = null;

			$previousWord = null;

			foreach( $productTypesA as $productType ) {

				$productTypeID = $productType->prodtypid;

				$productTypeName = $productType->name;

				$designationName = $prodDesignationT->getTranslatedName( $productType->type );



				
				$this->addElement( $productTypeID, $productTypeName );

			}
		}


		return true;

	}}