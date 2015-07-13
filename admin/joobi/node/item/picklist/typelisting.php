<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_Typelisting_picklist extends WPicklist {


function create() {


	if ( $this->onlyOneValue() ) {



		
		
		static $vendorHelperC = null;

		if ( !isset( $vendorHelperC ) ) $vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );

		$vendid = ( $vendorHelperC ) ? $vendorHelperC->traceVendor() : 0;



		static $itemTypeM = null;

		if ( empty( $itemTypeM ) ) $itemTypeM = WModel::get( 'item.type' );

		$itemTypeM->makeLJ( 'item.typetrans', 'prodtypid' );

		$itemTypeM->select( 'name', 1 );

		$itemTypeM->whereE( 'prodtypid', $this->defaultValue );
		$itemTypeM->rememberQuery();

		$itemTypeName = $itemTypeM->load('lr');

		$this->addElement( $this->defaultValue, $itemTypeName );

		return true;



	} else {

		$myController = WGlobals::get( 'controller' );
				if ( $myController == 'catalog' ) $myController = '';


		$itemQueryC = WClass::get( 'item.query' );

		$itemTypesA = $itemQueryC->getAllTypes( true, $myController );



	}

	if ( empty( $itemTypesA ) ) {

		return false;

	}


	if ( count($itemTypesA) == 1 ) {

		$formInstance = WView::form( $this->formName );

		$formInstance->hidden( $this->name, $itemTypesA[0]->prodtypid, false, true );

		return false;

	} else {

		$this->addElement( 0, '- ' . WText::t('1298350868MINX') . ' -' );

	}



	if ( !empty( $itemTypesA ) ) {



		
		
		$prodDesignationT = WType::get( 'item.designation' );



		$firstWord = null;

		$previousWord = null;

		foreach( $itemTypesA as $itemType ) {

			$itemTypeID = $itemType->prodtypid;

			$itemTypeName = $itemType->name;

			$designationName = $prodDesignationT->getTranslatedName( $itemType->type );
			$firstWord = $designationName;

			if ( $firstWord != $previousWord  ) {

				$this->addElement( -1, '-- '. $firstWord );

				$previousWord = $firstWord;

			}


			
			$this->addElement( $itemTypeID, $itemTypeName );

		}
	}


	return true;


}
}