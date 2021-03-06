<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');










class Files_Helper_class extends WClasses{

	private static $_fileA = array();






	public function getInfo($filid) {			static $fileM=null;

		if ( !isset(self::$_fileA[$filid]) ) {

			if ( empty($fileM) ) $fileM = WModel::get( 'files' );
			$fileM->remember( $filid, true );
			if ( is_numeric($filid) ) {
				$fileM->whereE( 'filid', $filid );
			} else {
				$fileM->whereE( 'name', $filid );
			}			$fileO = $fileM->load( 'o' );

			
			if ( !empty($fileO) ) $fileO->filename = $fileO->name . '.' . $fileO->type;
			else $fileO = true;
			self::$_fileA[$filid] = $fileO;

		}
		return ( self::$_fileA[$filid] === true ? null : self::$_fileA[$filid] );

	}








	public function setInfo($name,$extension,$path='') {

		$fileO = new stdClass;
		$fileO->name = $name;
		$fileO->type = $extension;
		$fileO->path = $path;

		self::$_fileA[$name] = $fileO;

	}






	public function getURL($filid) {

		$fileO = $this->getInfo( $filid );

		$fileC = WGet::file( $fileO->storage );
		$fileC->setFileInformation( $fileO );
		$url = $fileC->fileURL();

		return $url;

	}






	public function getPath($filid) {

		$fileO = $this->getInfo( $filid );

 		$path = ( !empty($fileO->basePath) ? $fileO->basePath : '' );
 		$path .= str_replace( '|', DS, $fileO->path );
 		if ( !empty($fileO->thumbnail) ) $path .= DS . 'thumbnails';
 		$path .= DS;
 		$path .= $fileO->name;
 		$path .= '.';
 		$path .= $fileO->type;

		return $path;

	}






	public function copyFile($filid,$fileSpecificationInfo=null) {
				$imagesM = WModel::get( 'images' );

		$originalFileM = WModel::get( 'images' );
		$originalFileM->whereE( 'filid', $filid );
		$originFileInfoO = $originalFileM->load( 'o' );

		$orignPath = $originalFileM->getFilePath();

				foreach( $originFileInfoO as $key => $val ) {
			$imagesM->$key = $val;
		}

		foreach( $fileSpecificationInfo as $key => $val ) {
			$underScoreKey = '_' . $key;
			$imagesM->$underScoreKey = $val;
		}
		$imagesM->thumbnail = 0;			$imagesM->secure = $fileSpecificationInfo->secure;


		$imagesM->_folder = $fileSpecificationInfo->folder;
		$imagesM->folder = $fileSpecificationInfo->folder;
		$imagesM->_path = $fileSpecificationInfo->path;

		$imagesM->width = $originFileInfoO->width;
		$imagesM->height = $originFileInfoO->height;


		$imagesM->_copy = true;



		unset( $imagesM->filid );


		$tempName = JOOBI_DS_TEMP . 'previewid' . rand( 1000, 9999 );
		$fileC = WGet::file();
		$fileC->copy( $orignPath, $tempName );

		$imagesM->_tmp_name = $tempName;
		$imagesM->_name = 'preview_' . $filid . '.' . $originFileInfoO->type;
		$imagesM->_completePath = JOOBI_DS_TEMP;



		$imagesM->returnId();

				$fileA = WClass::get('images.process');
		$fileA->process( $imagesM );

		$imagesM->save();

		return $imagesM->filid;

	}
}