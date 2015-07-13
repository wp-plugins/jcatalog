<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Design_Typeid_picklist extends WPicklist {

function create() {

	$fdid = $this->getValue( 'fdid' );
	if ( empty($fdid) ) return false;

	$sid = $this->getValue( 'sid' );
	if ( empty($sid) ) return true;
		$modelM = WModel::get( $sid );
	$namekey = $modelM->getModelNamekey();
	$mainModel = $modelM->getModelInfo( 'mainmodel' );
		if ( !empty($mainModel) && $mainModel != $namekey ) {
		$modelM = WModel::get( $mainModel );
	}
	$allTypesA = $modelM->getPossibleTypes();
	if ( empty($allTypesA) ) {
		return false;
	}

		$modelFieldTypeM = WModel::get( 'design.modelfieldstype' );
	$modelFieldTypeM->whereE( 'fdid', $fdid );
	$modelFieldTypeM->select( 'typeid' );
	$allFieldAndTypeA = $modelFieldTypeM->load( 'lra' );

	if ( !empty($allFieldAndTypeA) ) {
		$defaultA = array();
		foreach( $allFieldAndTypeA as $oneDe ) {
			if ( empty($oneDe) ) continue;
			$defaultA[] = $oneDe;
		}		$this->setDefault( $defaultA, true );
	}

	$this->addElement( 0, WText::t('1251298684SHUH') );

	foreach( $allTypesA as $key => $val ) {

		$this->addElement( $key, $val );

	}
	return true;

}
}