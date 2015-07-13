<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_filter_form_view extends Output_Forms_class {

	public static $customFieldInfoA = array();
	public static $vendorsFieldInfoA = array();
	private $_smartfilter = false;

function prepareView() {

		$viewElementA = $this->elements;

				$catalogAdvsearchC = WClass::get( 'catalog.advsearch' );
		$elementA = $catalogAdvsearchC->getAllAdvSearch( true );
		if ( empty($elementA) ) return true;

		$widgetM = WModel::get( 'main.widget' );
		$widgetM->whereSearch( 'namekey', 'catalog.advancesearch.module' );
		$widgetO = $widgetM->load( 'o', array( 'namekey', 'params' ) );
		WTools::getParams( $widgetO );

		unset( $this->elements );
		$this->elements = array();

				if ( empty($widgetO) ) {
			$this->userN('1412810068PUSV');
			return true;
		}
		$acceptedA = array();
		$newFieldsA = array();
		$allFieldsA = array();
		foreach( $widgetO as $key => $oneWidget ) {

			$spolitA = explode( '_', $key );
			$source = array_shift( $spolitA );

			if ( $oneWidget && $source == 'search' ) {
				$keep = implode( '_', $spolitA );
				$acceptedA[$keep] = true;



			}
		}
				$this->_loadCustomFieldsInformation( array_keys( $acceptedA ) );
		
		$count = 0;
		foreach( $elementA as $oneElement ) {

			$map = $oneElement->map;
			$subMap = substr( $map, 2, -1 );
			$explodeMapA = explode( '_', $subMap );

			$source = array_shift( $explodeMapA );
			if ( $source != 'source' ) continue;
			$keepMeToo = implode( '_', $explodeMapA );

			if ( empty( $acceptedA[$keepMeToo] ) ) continue;

			$newElementTab = clone( $viewElementA[0] );
			$newElementFilter = clone( $viewElementA[1] );

			$count = count( $this->elements ) + 1;
			$newElementTab->name = $oneElement->name;
			$newElementTab->fid = $count;

			$newElementFilter->fid = $count+1;
			$newElementFilter->parent = $count;
			$newElementFilter->item = $oneElement;
			$newElementFilter->newMap = $keepMeToo;

			$this->elements[] = $newElementTab;
			$this->elements[] = $newElementFilter;

		}
		return true;

	}










	private function _loadCustomFieldsInformation($elementToLoadA,$vendors=false) {

		if ( empty($elementToLoadA) ) return false;

		if ( $vendors ) {
			$dbtid = WModel::get( 'vendors', 'dbtid' );
			$PorpertyType = '_vendorsFieldInfoA';
		} else {
			$dbtid = WModel::get( 'item', 'dbtid' );
			$PorpertyType = '_customFieldInfoA';
		}
		$designViewfieldsM = WModel::get( 'design.modelfields' );
		$designViewfieldsM->makeLJ( 'library.model', 'sid', 'sid', 0, 1 );
		$designViewfieldsM->makeLJ( 'library.table', 'dbtid', 'dbtid', 1, 2 );
		$designViewfieldsM->whereE( 'advsearchable', 1, 0 );
		$designViewfieldsM->whereE( 'publish', 1, 0 );
		$designViewfieldsM->whereIn( 'column', $elementToLoadA, 0 );
		$designViewfieldsM->whereE( 'dbtid', $dbtid, 2 );
		$designViewfieldsM->makeLJ( 'design.modelfieldstrans', 'fdid', 'fdid', 0, 3 );
		$designViewfieldsM->whereLanguage( 3 );
		$designViewfieldsM->makeLJ( 'design.fields', 'fieldid', 'fieldid', 0, 4 );

		if ( $this->_smartfilter && !$vendors ) {
			$allCurrentTypesA = array();
						$type = WGlobals::get( 'type' );
			if ( empty($type) ) {
				$prodtypid = WGlobals::get( 'prodtypid' );
				if ( !empty($prodtypid) ) $allCurrentTypesA[] = $prodtypid;
			} else {
								$productTypeM = WModel::get( 'item.type' );
				$productTypeM->whereE( 'type', $type );
				$productTypeM->whereE( 'publish', 1 );
				$productTypeM->whereE( 'searchable', 1 );
				$productTypeM->checkAccess();
				$allCurrentTypesA = $productTypeM->load( 'lra', 'prodtypid' );
			}
			if ( !empty( $allCurrentTypesA ) ) {
				$designViewfieldsM->makeLJ( 'design.modelfieldstype', 'fdid', 'fdid', 0, 5 );
				$designViewfieldsM->whereIn( 'typeid', $allCurrentTypesA, 5 );
				$designViewfieldsM->groupBy( 'fdid' );
			}
		}

		$designViewfieldsM->select( array( 'column', 'namekey', 'params' ), 0 );
		$designViewfieldsM->select( 'name', 3 );
		$designViewfieldsM->select( 'listing', 4 );

		$customFieldInfoA = $designViewfieldsM->load( 'ol' );

		if ( empty($customFieldInfoA) ) return false;


		foreach( $customFieldInfoA as $oneField ) {

		if ( $vendors ) {

			self::$vendorsFieldInfoA[$oneField->column] = $oneField;

		} else {

			self::$customFieldInfoA[$oneField->column] = $oneField;

		}
		}
	}

}