<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Advfilter_class extends WClasses {

	private static $_compileFiltersOnlyOnce = false;

	private static $_newFitlerA = array();

	private static $_uniqueString = '';







	public function getItemFitlers() {

		if ( self::$_compileFiltersOnlyOnce ) return self::$_newFitlerA;

		self::$_compileFiltersOnlyOnce = true;
				$AllAdvCatalogA = WGlobals::getSession( 'advCatalog' );
		$advSearchA = WGlobals::get( 'advCatalog' );
		$advSearchResetA = WGlobals::get( 'advCatalogReset' );

		if ( !empty($AllAdvCatalogA) ) {

			$combinedReferenceA = array();
									foreach( $AllAdvCatalogA as $lid => $searchObjectO ) {
				$combinedReferenceA[$searchObjectO->column] = $lid;
			}
						self::$_newFitlerA = array();
			$_uniqueStringA = array();
			$transSID = WModel::get( 'itemtrans', 'sid' );
			$vendorTransSID = WModel::get( 'vendortrans', 'sid' );
			foreach( $AllAdvCatalogA as $lid => $searchObjectO ) {

				if ( empty($searchObjectO) ) continue;
				if ( !empty($advSearchResetA[$lid]) ) {
					WGlobals::getUserState( 'advCtlg_val_' . $lid, $lid, 0, '', 'advCatalog' );
					continue;
				}

				$searchObjectO->lid = $lid;
				$searchObjectO->type = $searchObjectO->typeNode . '.' . $searchObjectO->typeName;
				$searchObjectO->map = $searchObjectO->column;
				$searchObjectO->sid = $searchObjectO->modelID;
				$searchObjectO->translation = ( in_array( $searchObjectO->sid, array($transSID, $vendorTransSID) )  ? true : false );

				$typeValue = '';
				if ( !empty( $searchObjectO->combined ) ) {
					$lidToUse = $combinedReferenceA[$searchObjectO->combined];
					$value = ( isset($advSearchA[$lidToUse]) ? $advSearchA[$lidToUse] : null );
				} else {
					$value = ( isset($advSearchA[$lid]) ? $advSearchA[$lid] : null );
					$lidToUse = $lid;
				}
				$searchObjectO->value = WGlobals::getUserState( 'advCtlg_val_' . $lidToUse, $lidToUse, $value, $typeValue, 'advCatalog' );

				self::$_newFitlerA[] = $searchObjectO;
				if ( !empty($searchObjectO->value) ) $_uniqueStringA[] = $searchObjectO->column;

			}
			if ( !empty( $_uniqueStringA ) ) self::$_uniqueString = '-' . implode( '-', $_uniqueStringA );

		}
		return self::$_newFitlerA;

	}





	public function getUniqueString() {

		if ( empty( self::$_uniqueString ) ) $this->getItemFitlers();

		return self::$_uniqueString;

	}

}