<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Translation_installexec_controller extends WController {

	function installexec(){

		$processC=WClass::get('install.process');

		$processC->instup();

	}
}