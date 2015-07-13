<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Item_Itemtype_edit_picklist extends WPicklist {


function create() {

	
	
	if ( $this->onlyOneValue() ) {

		$itemTypeM = WModel::get( 'item.type' );
		$itemTypeM->makeLJ( 'item.typetrans', 'prodtypid' );
		$itemTypeM->select( 'name', 1 );
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

	}


	$itemTypeM = WModel::get( 'item.type' );


	$itemTypeM->makeLJ( 'item.typetrans', 'prodtypid' );

	$itemTypeM->select( 'name', 1 );



	$itemType = WGlobals::get( 'itemtype', '', 'global' );	
	if ( empty($itemType) )	$itemType = WGlobals::get( 'controller' );
	if ( !is_numeric($itemType) ) {
		$productDesignationT = WType::get( 'item.designation' );
		$myType = $productDesignationT->getValue( $itemType );
	} else {
		$myType = $itemType;
	}


	
	if ( !empty($myType) ) {

		$itemTypeM->whereE( 'type', $myType );

	}




	$itemTypeM->makeLJ( 'item.typetrans', 'prodtypid' );

	$itemTypeM->whereLanguage(1);

	$itemTypeM->select( 'name', 1 );

	$itemTypeM->whereE( 'publish', 1 );



	












	$itemTypeM->checkAccess( 0, 0, 0, 0, 'rolid_edit' );


	$itemTypeM->orderBy( 'ordering' );

	$itemTypeM->orderBy( 'type' );
	$itemTypeM->setLimit( 500 );

	$productTypesA = $itemTypeM->load( 'ol', array( 'prodtypid', 'namekey', 'type' ) );



	if ( empty( $productTypesA ) ) {

		$message = WMessage::get();

		$message->userE('1341269697SNUR');

		return false;

	}


	if ( count($productTypesA) == 1 ) {



		$formInstance = WView::form( $this->formName );

		$formInstance->hidden( $this->name, $productTypesA[0]->prodtypid, false, true );



		return false;





	}


	if ( !empty( $productTypesA ) ) {



		
		




		$defaultText = '';

		foreach( $productTypesA as $productType ) {

			$productTypeID = $productType->prodtypid;

			$productTypeName = $productType->name;








			if ( !empty($defaultprodtypid) && $defaultprodtypid == $productTypeID ) $defaultText = $productTypeName;

			
			$this->addElement( $productTypeID, $productTypeName );

		}


		if ( !empty($defaultText) ) WGlobals::set( 'titleheader', $defaultText );

	}

	return true;


}
}