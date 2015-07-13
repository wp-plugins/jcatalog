<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Design_Valuesorder_picklist extends WPicklist {

	function create() {


		$did = WGlobals::get( 'did');
		if ( empty($did) ) return false;


		$designPicklistValuesM = WModel::get( 'design.picklistvalues' );
		$designPicklistValuesM->makeLJ( 'design.picklistvaluestrans' , 'vid' );
		$designPicklistValuesM->whereLanguage();
		$designPicklistValuesM->select( 'name', 1 );
		$designPicklistValuesM->whereE( 'did', $did );
		$designPicklistValuesM->orderBy( 'ordering', 'ASC' );
		$allValuesA = $designPicklistValuesM->load( 'ol', 'ordering' );


		$lastElement = 0;
		if ( !empty($allValuesA) ) {
			foreach( $allValuesA as $oneValue ) {
				$this->addElement( $oneValue->ordering, $oneValue->name );
				if ( $lastElement < $oneValue->ordering ) $lastElement = $oneValue->ordering;
			}		}
		$lastElement++;
		$this->addElement( $lastElement, WText::t('1357058839QZXX') );

		if ( empty($this->defaultValue[$this->did]) ) {
			$this->setDefault( $lastElement );
		}

		return true;


	}
}