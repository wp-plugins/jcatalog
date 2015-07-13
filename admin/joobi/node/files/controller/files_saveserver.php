<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Files_saveserver_controller extends WController {
	function saveserver() {

	
		$trucs = WGlobals::get('trucs');

		$uploadFile = $trucs['x'];	
				
		$uploadFiles->directory = $uploadFile['directory']; 	
		$uploadFiles->extension = $uploadFile['extension']; 	
		$uploadFiles->keepfile = $uploadFile['tkeepfile']; 	
		$uploadFiles->secure = $uploadFile['secure'];
		$uploadFiles->showUploadedFiles = 1; 
		$uploadFiles->controller = ( !empty($this->controller) )? $this->controller : 'files';
	    $uploadFiles->index = ( !empty($this->index) )? $this->index : 'default';
		 	
		$filesMediaC = WClass::get( 'files.media' );	 
		$status = $filesMediaC->uploadDirectory($uploadFiles);
		
		WPages::redirect('controller='.$uploadFiles->controller.'&task=listing', '', $uploadFiles->index);
				return $status;
			

	}}