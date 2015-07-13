<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Design_Models_picklist extends WPicklist {
function create() {



	$designModelM = WModel::get( 'design.model' );

	$designModelM->makeLJ( 'design.modeltrans' );

	$designModelM->whereLanguage();

	$designModelM->select( 'name', 1 );

	$designModelM->whereE( 'fields', 1 );

	$allModelA = $designModelM->load( 'ol', 'sid' );



	$this->addElement( 0, WText::t('1357138790PDJD') );

	if ( !empty($allModelA) ) {

		foreach( $allModelA as $one ) {

			$this->addElement( $one->sid, $one->name );

		}
	}


	return true;



}}