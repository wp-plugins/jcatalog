<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Main_Type_class extends WClasses {



	public $typeModelName = null;
	public $typeModelPK = null;

	public $itemModelName = null;
	public $itemModelPK = null;


	public $designationNode = null;

	public $cacheFolder = 'Type';






	public function resetCacheDesignation() {

		$cacheHandler = WCache::get();
		$cacheHandler->resetCache( $this->cacheFolder );

	}








	public function loadData($typeID,$return='data') {

		if ( empty( $typeID ) ) return null;
		if ( empty( $this->typeModelName ) ) return false;



		$topicTypeM = WModel::get( $this->typeModelName );
		$typeInfoO = $topicTypeM->loadMemory( $typeID );

		if ( $return=='data' ) {
						return $typeInfoO;
		} elseif ( $return =='designation' ) {
						$itemTypeT = WType::get( $this->designationNode . '.designation' );
			if ( !empty($typeInfoO->type) ) return $itemTypeT->getName( $typeInfoO->type );
			else return '';

		} elseif ( isset($typeInfoO->$return) ) {
			return $typeInfoO->$return;
		} else {
			return null;
		}
	}







	public function getDefaultType($designation='topic') {

		if ( empty( $designation ) ) $designation='topic';

		static $resultA = array();

		if ( !isset( $resultA[ $designation ] ) ) {

						$productTypeT = WType::get( $this->designationNode . '.designation' );
			$idType = $productTypeT->getValue( $designation, false );

			$productTypeM = WModel::get( $this->typeModelName );
			$productTypeM->remember( $idType, true, $this->cacheFolder );
				$productTypeM->whereE( 'type', $idType );
			$productTypeM->orderBy( 'publish', 'DESC' );
			$productTypeM->orderBy( $this->typeModelPK, 'ASC' );
			$resultA[ $designation ] = $productTypeM->load( 'lr', $this->typeModelPK );

						if ( empty($resultA[ $designation ]) ) {
								$TYPE = $designation;
				$this->userW('1410185409ETKT',array('$TYPE'=>$TYPE));
				$productTypeM = WModel::get( $this->typeModelName );
				$productTypeM->orderBy( 'core', 'DESC' );
				$productTypeM->orderBy( 'publish', 'DESC' );
				$productTypeM->orderBy( $this->typeModelPK, 'ASC' );
				$resultA[ $designation ] = $productTypeM->load( 'lr', $this->typeModelPK );
			}
		}
		return  $resultA[ $designation ];

	}








public function loadTypeFromID($eid,$return='data') {
	static $typeInfoO = array();

	if ( !isset($typeInfoO[$eid]) ) {
		$itemM = WModel::get( $this->itemModelName );
		$itemM->makeLJ( $this->typeModelName );
		$itemM->select( $this->typeModelPK, 1 );
		$itemM->checkAccess();
		$itemM->whereE( $this->itemModelPK, $eid );
		$typeInfoO[$eid] = $itemM->load( 'lr' );
				if ( !isset($typeInfoO[$eid]) ) $typeInfoO[$eid] = false;

	}
	 return $this->loadData( $typeInfoO[$eid], $return );

}







	public function loadAllTypesFromDesignation($designation) {

		if ( empty( $designation ) ) return '';
		static $resultA = array();

		$key = serialize( $designation );

		if ( !isset( $resultA[ $key ] ) ) {
			static $productTypeM = null;

						if ( is_string($designation) ) {
								$productTypeT = WType::get( $this->designationNode . '.designation' );
				$designation = $productTypeT->getValue( $designation, false );
			} elseif ( is_array($designation) ) {
				$productTypeT = WType::get( $this->designationNode . '.designation' );
				$newDisignation = array();
				foreach( $designation as $oneD ) {
					if ( is_string($oneD) ) {
						$newDisignation[] = $productTypeT->getValue( $oneD, false );
					} else {
						$newDisignation[] = $oneD;
					}				}				$designation = $newDisignation;
			}
						$productTypeM = WModel::get( $this->typeModelName );
			$productTypeM->rememberQuery( true, $this->cacheFolder );
			if ( !is_array($designation) ) $designation = array( $designation );
			$productTypeM->whereIn( 'type', $designation );
			$productTypeM->whereE( 'publish', 1 );
			$productTypeM->checkAccess();
			$resultA[ $key ] = $productTypeM->load( 'lra', $this->typeModelPK );
		}
		return $resultA[ $key ];

	}

}