<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Viewlistings_model extends WModel {
function addValidate() {



	
	if ( empty($this->namekey) ) {



		$namekey = WView::get( $this->yid, 'namekey' );

		if ( empty($namekey) ) return false;

		$namekey .= '_' . $this->map;

		$this->namekey = $namekey;

	}




	return true;



}




function validate() {



	
	
	$YIDRolid = WView::get( $this->yid, 'rolid' );

	$roleC = WRole::get();

	$acceptedR = $roleC->compareRole( $this->rolid, $YIDRolid );



	if ( !$acceptedR ) $this->rolid = $YIDRolid;



	return true;



}}