<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');








class Item_Termsconditions_class extends WClasses {

	function createListofTerms() {
	
				$itemTypeInfoA = array();
		$itemInfoA = array();
		if ( !$this->_getTermsInformation( $itemTypeInfoA, $itemInfoA ) ) return false;

				$WhichTerms2UseA = $this->_defineWhichTerms2Load( $itemTypeInfoA, $itemInfoA );
		
				$termsInfoO = new stdClass;
		if ( !empty($WhichTerms2UseA) && is_array($WhichTerms2UseA) ) {
						$itemTermsM = WModel::get( 'item.terms' );
			$itemTermsM->makeLJ( 'item.termstrans', 'termid');
			$itemTermsM->whereLanguage();
			$itemTermsM->select( 'name', 1 );
			$itemTermsM->whereIn( 'termid', $WhichTerms2UseA );
			$itemTermsM->whereE( 'publish', 1 );
			$termsInfoO = $itemTermsM->load( 'ol', 'termid' );	
			
			return $termsInfoO;
		}		
		return $termsInfoO;
		
	}
	





	
	private function _defineWhichTerms2Load($itemTypeInfoA,$itemInfoA) {

		$propertyYesNoA = array( 'requiretermsatcheckout' ); 
		$propertyOtherA = array( 'termslicense' ); 
		
				$useMeTypeA = array();
		foreach( $itemTypeInfoA as $oneType ) {
			$useMeTypeA[$oneType->prodtypid] = $oneType;
		}		
		$WhichTerms2UseA = array();
				foreach( $itemInfoA as $oneItem ) {
			
			$itemTypeInfoO = $useMeTypeA[$oneItem->prodtypid];
			
			$terms = new stdClass;
			foreach( $propertyYesNoA as $property ) {
				if ( empty($oneItem->$property) ) continue;
				
				$terms->$property = $oneItem->$property;
								
								if ( $terms->$property == 5 ) {
					$terms->$property = !empty($itemTypeInfoO->$property) ? $itemTypeInfoO->$property : '';
				}	
				if ( $terms->$property == 2 ) $terms->$property = constant( 'PCATALOG_NODE_' . strtoupper( $property ) );
				
			}
			foreach( $propertyOtherA as $property ) {
				if ( !isset($oneItem->$property) ) continue;
				$terms->$property = $oneItem->$property;
								if ( empty($terms->$property) ) continue;
				
								if ( $terms->$property == 'type' ) {
					$terms->$property = !empty($itemTypeInfoO->$property) ? $itemTypeInfoO->$property : '';
				}	
				if ( $terms->$property == 'general' ) $terms->$property = constant( 'PCATALOG_NODE_' . strtoupper( $property ) );
				
			}			
			if ( !empty($terms->termslicense) && !empty($terms->requiretermsatcheckout) ) $WhichTerms2UseA[] = $terms->termslicense;
			
		}			
		return $WhichTerms2UseA;
		
	}	
	





	
	private function _getTermsInformation(&$itemTypeInfoA,&$itemInfoA) {
		
		$basketC = WClass::get('basket.previous',null,'class',false);
		$basket = $basketC->getBasket();
		
		if ( !empty($basket->Products) ) {
			$allPIDs = array();
			$allprodtypids = array();
			foreach( $basket->Products as $oneProduct ) {
				if ( empty($oneProduct->pid) || empty($oneProduct->pid) ) continue;
				$allPIDs[$oneProduct->pid] = true;
				$allprodtypids[$oneProduct->prodtypid] = true;
			}		}
				if ( empty($allPIDs) || empty($allprodtypids) ) return false;
				
						$productM = WModel::get( 'product' );
		$productM->whereIn( 'pid', array_keys($allPIDs) );
		$allPorductsDataA = $productM->load( 'ol', array( 'pid', 'prodtypid', 'params') );
		if ( !empty($allPorductsDataA) ) $itemInfoA = $this->_convertParamsInArray( $allPorductsDataA );
		
				$itemTypeM = WModel::get( 'item.type' );
		$itemTypeM->whereIn( 'prodtypid', array_keys($allprodtypids) );
		$allItemsTypeDataA = $itemTypeM->load( 'ol', array( 'prodtypid', 'params') );
		if ( !empty($allItemsTypeDataA) ) $itemTypeInfoA = $this->_convertParamsInArray( $allItemsTypeDataA );
		
		if ( empty($allItemsTypeDataA) || empty($allPorductsDataA) ) return false;
		else return true;
		
	}	
	
	private function _convertParamsInArray($objList) {
		
		$newObjListA = array();
		foreach( $objList as $oneElement ) {
			WTools::getParams( $oneElement, 'params' );
			$newObjListA[] = $oneElement;
		}		
		return $newObjListA;
		
	}	

}