<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CorePrioritylisting_listing extends WListings_default{






function create() {

  
	
	$priority = $this->getValue('priority');

	static $udropsetM = null;

	static $valueName = null;



  	if (!isset($udropsetM) && !isset($valueName)) {

  		$udropsetM = WModel::get('library.picklist');

		
		$udropsetM->makeLj('library.picklistvalues', 'did', 'did', 0,1);

		$udropsetM->makeLJ('library.picklistvaluestrans','vid','vid',1,2);

		$udropsetM->whereE('namekey', "ticket-priority",0);

		$udropsetM->select('value', 1);

		$udropsetM->select('name', 2);

		$udropsetM->groupBy('vid',2);

		$udropsetM->setLimit( 500 );

		$valueName = $udropsetM->load('ol');

  	}


	foreach($valueName as $index => $value) {

		if ($priority == $valueName[$index]->value) {

			$this->content=$valueName[$index]->name;

		}
	}


	return true;

}}