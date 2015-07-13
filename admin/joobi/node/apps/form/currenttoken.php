<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Apps_CoreCurrenttoken_form extends WForms_default {
	function create(){



		
		$appsInfoC=WCLass::get( 'apps.info' );

		$token=$appsInfoC->getPossibleCode();


		if( empty($token) || $token===true ) return false;

		$this->content=$token;



		return true;



	}}