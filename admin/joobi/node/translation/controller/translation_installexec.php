<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Translation_installexec_controller extends WController {

	function installexec(){

		$processC=WClass::get('install.process');

		$processC->instup();

	}
}