<?php 

* @link joobi.co
* @license GNU GPLv3 */





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