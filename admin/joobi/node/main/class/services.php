<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');



class Main_Services_class extends WClasses {









 	public function getCredentials() {



 		$data = new stdClass;

 		$appsInfoC = WClass::get( 'apps.info' );

 		$data->token = $appsInfoC->getValidToken( true );

 		if ( empty($data->token) ) {

 			$this->userE('1398110833SALX');

 			return false;

 		}


 		$data->url = $appsInfoC->myURL();



 		return $data;



 	}




}


