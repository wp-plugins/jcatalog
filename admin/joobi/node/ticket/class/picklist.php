<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_Picklist_class extends WClasses {









function getName($namekey,$valuePick){



	static $udropM = null;

	static $did = null;

	static $udropValuesM = null;

	static $valueName = null;



	if (!isset($udropM)) $udropM = WModel::get('library.picklist');		
  	$udropM->whereE('namekey',$namekey);

  	if (!isset($did)) $did = $udropM->load('lr','did');



  	if (!isset($udropValuesM)) $udropValuesM = WModel::get('library.picklistvalues');	
  	$udropValuesM->makeLJ('library.picklistvaluestrans','vid','vid');

  	$udropValuesM->whereE('did',$did);

  	$udropValuesM->select('value',0);

  	$udropValuesM->select('name',1);

 	$udropValuesM->groupBy('vid',1);

  	if (!isset($valueName)) $valueName = $udropValuesM->load('ol');



	foreach($valueName as $index => $value){

		if ($valuePick == $valueName[$index]->value){

			$name = $valueName[$index]->name;

			return $name;

		}
	}
	return true;

}}