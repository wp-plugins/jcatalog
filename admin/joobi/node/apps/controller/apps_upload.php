<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Apps_upload_controller extends WController {


	function upload(){


		$appsUploadC=WClass::get( 'apps.upload' );
		$status=$appsUploadC->uploadINstallPackage();


		if(!$status) return true;

		WGlobals::setSession( 'webapps', 'widgetinstall', true );

		WPages::redirect('controller=apps&task=install&run=1');



	}


}