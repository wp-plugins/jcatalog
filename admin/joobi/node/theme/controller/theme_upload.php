<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Theme_upload_controller extends WController {


	function upload(){



		$appsUploadC=WClass::get( 'apps.upload' );

		$status=$appsUploadC->uploadINstallPackage();



		if(!$status) return true;




		if( !defined('JOOBI_INSTALLING')) define( 'JOOBI_INSTALLING', 1 );





		return true;



	}}