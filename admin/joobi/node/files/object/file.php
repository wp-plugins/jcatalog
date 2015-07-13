<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




class Files_File_object {

	public $name = ''; 	public $type = ''; 	public $fileID = ''; 	public $basePath = '';		public $path = '';

	public $thumbnail = false;	
	public $secure = false; 	
	public $storage = null;	





	public function fileURL() {

		$fileInstance = WGet::file( $this->storage );
		if ( empty($fileInstance) ) return false;

		$fileInstance->setFileInformation( $this );
		return $fileInstance->fileURL();
	}
}