<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Apps_installnow_controller extends WController {

	function installnow(){



		$libProgreC=WClass::get( 'library.progress' );
		$progressO=$libProgreC->get( 'apps' );

		$progressO->run();
		$ajaxHTML=$progressO->displayAjax();


		echo $ajaxHTML;
		$progressO->finish();
		exit();


		return true;



	}
}