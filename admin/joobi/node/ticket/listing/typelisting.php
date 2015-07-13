<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CoreTypelisting_listing extends WListings_default{



function create() {



  	if ( ! WPref::load( 'PTICKET_NODE_TKTYPE' ) ) {				
  		
		$type= $this->getValue('type');

	  	static $udropsetM = null;			
	 	static $valueName= null;			


		
		 if ( !isset($udropsetM) && !isset($valueName) ) {

	  		$udropsetM = WModel::get('library.picklist');

			
			$udropsetM->makeLj('library.picklistvalues', 'did', 'did', 0,1);

			$udropsetM->makeLJ('library.picklistvaluestrans','vid','vid',1,2);

			$udropsetM->whereE('namekey', "ticket-all-type",0);

			$udropsetM->select('name', 2);

			$udropsetM->select('value', 1);

			$udropsetM->groupBy('vid',2);

			$udropsetM->setLimit( 500 );

			$valueName = $udropsetM->load('ol');

  		}


	  	foreach($valueName as $index => $name) {				
	  		if ($type == $valueName[$index]->value) {

	  			$this->content=$valueName[$index]->name;	
	  		}
  		}


  	} else {

  		$this->content='';			
  	}


	return true;

}}