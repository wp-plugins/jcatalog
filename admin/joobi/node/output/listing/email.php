<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WListing_Coreemail extends WListings_default{

	


	function create(){

		$eids=$this->eid();

		$idLabel=is_array($eids) ? implode($eids):$eids;

		if( empty($this->element->truncate)) $this->element->truncate=0;

		$outputEMailC=WClass::get( 'output.emailclock' );
		$this->value=$outputEMailC->cloakmail( $idLabel, $idLabel, $this->value, $this->element->truncate );

		return parent::create();
	}
}

