<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreSelectlanguage_form extends WForms_default {
function create() {



	$params = new stdClass;



	$this->value = WUser::get('lgid');


	$params->default = $this->value; 
 	$params->outputType = 0; 
 	$params->nbColumn = 1; 
 	$params->map = $this->map; 
 	$modelPickList = WView::picklist( 'translation_language_exportable', null, $params );

 	$values = $modelPickList->getValues();

 	if ( empty($values) ) return false;



 	if ( !empty( $this->value ) && !array_key_exists( $this->value, $values )  ) {

		$this->content = WModel::get( $this->value, 'namekey' );

 	} else {

 		$this->content = $modelPickList->display();

 	}

	return true;

}}