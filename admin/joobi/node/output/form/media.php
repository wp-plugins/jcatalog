<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');














WView::includeElement( 'form.text' );
class WForm_Coremedia extends WForm_text {

	private static $_countUploads=0;
	protected $inputType='file';

	private $_maxFileSizeShow=0;

	private $_allowedFormatsA=array();

	private $_maxFiles=1;






	function show(){

		if( empty($this->value)) return false;

		if( empty($this->element->imageWidth)){
			$definedImgWidth=(int)WGlobals::get( 'maxImageWidth', 180 );
			$this->element->imageWidth=$definedImgWidth;
		}		if( empty($this->element->imageHeight)){
			$definedImgHeight=(int)WGlobals::get( 'maxImageHeight', 180 );
			$this->element->imageHeight=$definedImgWidth;
		}
				$filesMediaC=WClass::get( 'files.media' );
		$this->content=$filesMediaC->renderHTML( $this->value, $this->element ) .'<br />';
		WGlobals::set( 'media-type-show-view', $filesMediaC->fileType );

		return true;

	}



	protected function _maxFileUpload(){
		static $maxFileSize=null;

		$allowedFiles='';
		if( !empty($this->element->sid)){
			$usedModelM=WModel::get( $this->element->sid );
			$this->_allowedFormatsA=( !empty( $usedModelM->_fileInfo[$this->element->map]->format ) ? $usedModelM->_fileInfo[$this->element->map]->format : array());

			$allowedFiles='';
			if( !empty($this->_allowedFormatsA)){
				$allowedFormatsA=( is_array($this->_allowedFormatsA) ?  implode( ", ", $this->_allowedFormatsA ) : $this->_allowedFormatsA );
				$allowedFormatsA=strtolower( $allowedFormatsA );
				$allowedFiles='. ' . WText::t('1360107637HVSN') . $allowedFormatsA;
			}
		}
						$name='maxFileUpload-' . $this->element->namekey;
		$maxFileUpload=WGlobals::get( $name, 0, 'global' );
		if( empty($maxFileUpload)){
			$maxFileUpload=WPref::getOne( 'imgmaxsize', $this->nodeID );
		}		$maxFileUpload=$maxFileUpload * 1024;

				if( !isset($maxFileSize)){
			$maxFileSize1=@ini_get('post_max_size');
			$maxFileSize2=@ini_get('upload_max_filesize');
			$maxFileSize=( $maxFileSize2 > $maxFileSize1 ) ? $maxFileSize2 : $maxFileSize1;
		}
		if( !empty($maxFileUpload) && $maxFileUpload < WTools::returnBytes($maxFileSize)){
			$this->_maxFileSizeShow=WTools::returnBytes( $maxFileUpload, true );
		}else{
			$this->_maxFileSizeShow=WTools::returnBytes( WTools::returnBytes( $maxFileSize ), true );
		}
		if( !empty( $this->_maxFileSizeShow )) return ' ' . WText::t('1241675239ROHF') . ': ' . $this->_maxFileSizeShow . $allowedFiles;
		else return false;

	}
}