<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Models_picklist extends WPicklist {
function create() {



	$designModelM = WModel::get( 'design.model' );

	$designModelM->makeLJ( 'design.modeltrans' );

	$designModelM->whereLanguage();

	$designModelM->select( 'name', 1 );

	$designModelM->orderBy( 'fields', 'DESC' );

	$designModelM->orderBy( 'namekey', 'ASC' );

	$allModelA = $designModelM->load( 'ol', array( 'sid', 'namekey' ) );



	$this->addElement( 0, WText::t('1414093502MVHU') );

	if ( !empty($allModelA) ) {

		foreach( $allModelA as $one ) {

			$this->addElement( $one->sid, $one->name . ' ( ' . $one->namekey . ' )' );

		}
	}


	return true;



}}