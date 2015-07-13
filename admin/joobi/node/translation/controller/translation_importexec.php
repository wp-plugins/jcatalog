<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Translation_Importexec_controller extends WController {

	






	function importexec(){

		$translationProcessC=WClass::get('translation.process');
		$translationProcessC->setDontForceInsert( true );

		$translationProcessC->importexec();

	}	
}