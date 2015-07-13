<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Files_Node_model extends WModel {


	


	var $_name = '';	
	var $_map = '';		
	var $_multiple = false;	


	public $_fileType = 'files';



	var $type = '';	
	public $_mimeType = '';	
	public $_tmp_name = '';	
	var $_error = 0;	
	var $_size = 0; 	


	
	public $_folder = 'media'; 
	public $_path = ''; 
	var $secure = false; 


	var $_format = array(); 
	var $_maxSize = 0;	


	var $_completePath = '';	
	var $_local = false;



	public $thumbnail = 0;	
	public $_maxTHeight = 0;

	public $_maxTWidth = 0;

	public $_maxHeight = 0;

	public $_maxWidth = 0;

	public $_watermark = 0;

	public $_storage = 'local';	
	public $storage = null;





	public $_returnId = true; 
	public $_uploadFile = true; 


	var $_resized = false;	


	
	private $_noFileJustContent = false;



	var $_copy = false; 














	public function getInfo($filid) {



		$filesHelperC = WClass::get( 'files.helper' );

		return $filesHelperC->getInfo( $this->value );



	}
















	public function setFileInfoForSave($fileObj,$column='filid') {



		$this->_fileInfo[$column] = $fileObj;



	}
























	public function saveOneFile($fileContent,$fileName,$filePath='',$basePath='',$overwrite=false) {



		
		if ( !empty($filePath) ) {

			$this->_path = str_replace( array( '|', '/', '\\'), DS, $filePath );

		}


		if ( !empty($basePath) ) {

			$this->_folder = trim( str_replace( JOOBI_DS_USER, '', $basePath ), DS);

		}


		
		$this->_name = $fileName;



		
		$this->thumbnail = 0;

		
		$this->secure = 0;

		$this->_size = strlen( $fileContent );

		$this->_noFileJustContent = true;



		$writeType = 'write';

		if ($overwrite) {

			$name = pathinfo($fileName, PATHINFO_FILENAME);

			$this->whereE( 'name', $name );

			$this->whereE( 'path', str_replace( DS, '|', $this->_path ) );

			$existFile = $this->load('o');



			if ( !empty($existFile) ) $writeType = 'force';

		}


		
		if ( empty($existFile) ) {

			
			$this->save();

		} else {

			$this->whereE( 'filid', $this->filid );

			$this->update();

		}


		
		$file = WGet::file( $this->_storage );

		if ( empty( $this->_completePath ) ) $this->_completePath = $file->makePath( $this->_folder, $this->_path );





		$this->size = $file->write( $this->_completePath .DS. $this->name . '.' . $this->type, $fileContent, $writeType );



		return $this->filid;



	}














	public function saveOnlyData($filename='',$path='') {



		$this->_name = $filename;


		$this->_noFileJustContent = true;

		$this->_path = $path;



	}












	public function save($notUsed=null,$notUsed2=null) {



		
		if ( !empty( $this->_storage ) && is_numeric($this->_storage) ) {

			$this->storage = $this->_storage;

		}




		
		$this->secure = (int)( $this->secure ) ? 1 : 0;

		$this->thumbnail = (int)( $this->thumbnail ) ? 1 : 0;

		if ( !isset($this->uid) ) $this->uid = WUser::get('uid');



		
		if ( !empty($this->_externalFile) ) {

			$this->name = $this->_name;

			$this->type = $this->_type;

			$this->path = '';



			$this->returnId();



			
			if ( !$this->_checkUnicity( false, true ) ) {

				
				$this->filid = $this->_currentFileID;

				 return true;

			}


			$this->returnId();



			
			$status = parent::save();



			return $status;



		}


		






		if ( isset($this->folder) ) $this->_folder = $this->folder;



		$folderC = WGet::folder( $this->_storage );

		if ( empty($this->_tmp_name) && !$this->_noFileJustContent ) return true;


		$this->_completePath = $folderC->makePath( $this->_folder, $this->_path );



		$message = WMessage::get();



		
		

		
		if ( empty($this->size) ) $this->size = $this->_size;



		$tmpTypeA = explode( '.', $this->_name );

		$this->type = strtolower( array_pop($tmpTypeA) );



		if ( !empty($this->_type) ) {

			$typeA = explode( '/', $this->_type );

			$this->_mimeType = $typeA[0];

			if ( empty($this->type) ) {

				$this->type = array_pop($typeA);

			}
		}


		
		if ( is_string($this->_format) ) {

			$this->_format = explode( ',', $this->_format );

			if ( !empty($this->_format) ) {

				$newFormat = array();

				foreach( $this->_format as $oneF ) {

					$oneF = trim( $oneF );

					if ( !empty($oneF) ) $newFormat[] = $oneF;

				}
				$this->_format = $newFormat;

			}
		}


		
		if ( is_array($this->_format) && !empty($this->_format) && !in_array($this->type, $this->_format) ) {

			$TYPE = $this->type;

			$FORMAT = implode(' , ', $this->_format );



			$message->userW('1298294171AWEH',array('$TYPE'=>$TYPE,'$FORMAT'=>$FORMAT));

			return false;

		}


		
		if ( !empty($this->_maxSize) ) {

			if ($this->_size > $this->_maxSize) {

				$FILENAME = $this->_name;

				$message = WMessage::get();



				$MAX_SIZE = WTools::returnBytes( $this->_maxSize, true );

				$message->userW('1359654979DESV',array('$FILENAME'=>$FILENAME,'$MAX_SIZE'=>$MAX_SIZE));










				return false;

			}
		}

		


		
		if ( $folderC->checkExist() && !$folderC->exist( $this->_completePath ) ) $folderC->create( $this->_completePath, '', true );



		
		$this->path = str_replace( DS, '|', $this->_path );


		
		$name = preg_replace( '#[^a-z0-9\.\_]#i','_' , $this->_name );

		$name = strtolower($name);


		
		$pos = strrpos($name, '.');

		$this->name = substr($name, 0, $pos );




		
		if ($this->secure) {

			static $count = 0;

			static $nowTime = null;

			$count++;

			if ( $nowTime!=time() ) {

				$nowTime=time();

				$count=1;

			}


			
			$this->md5 = $nowTime .'-'. $count . substr( md5($this->name . '.' . $this->type ), 0, 20 );

		}




		
		if ( !$this->_checkUnicity( false ) ) return false;	
		if ( !$this->_checkUnicity( true ) ) return false;	


		$this->_fullName = $this->name . '.' . $this->type;



		if ( !isset($this->mime) && !empty($this->_type) ) $this->mime = $this->_type;



		
		if ( $this->_fileType !='files' ) {



			if ( $this->_fileType =='images' || $this->_mimeType=='image' ) {



				
				$fileA = WClass::get( 'images.process' );

				$fileA->process( $this );


				
				$folderC->create( $this->_completePath , '', true );












			}


			


		}




		
		if ( WExtension::exist( 'vendor.node' ) ) {

			$uid = WUser::get('uid');

			$vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );

			if ( !empty($vendorHelperC) ) $vendid = $vendorHelperC->getVendorID( $uid );

			else $vendid = 1;

		} else $vendid = 1;



		
		$this->vendid = $vendid;



		$this->returnId();

		
		$status = parent::save();



		if (!$status) return false;



		
		if ( $this->_noFileJustContent ) return true;



		if ( !$this->move() ) {





			$message->userW('1206732415ABES');


			return false;

		}


		return true;



	}


	function saveparent() {

		return parent::save();

	}


















	function deleteValidate($eid=0) {

		$this->_x = $this->load( $eid );

		return true;

	}














	function deleteExtra($eid=0) {



		if ( !empty($this->_x->path) || !empty($this->_x->secure) ) {



			
			if ( empty($this->_basePath) ) $this->_basePath = JOOBI_DS_USER;

			else $this->_basePath = rtrim( $this->_basePath, DS ) . DS;







			$this->_x->path = str_replace( '|', DS, $this->_x->path );







			$fileC = WGet::file( $this->_x->storage );

			$fileC->setFileInformation( $this->_x );





			$this->_completePath = $fileC->makePath( $this->_x->folder, $this->_x->path ) . DS;



			if ( !empty($this->_x->thumbnail) ) {

				$thumbnail = $this->_completePath . 'thumbnails' . DS . $this->_x->name . '.' . $this->_x->type;

				$fileC->delete( $thumbnail );


			}


			$this->_x->thumbnail = false;

			$fileC->setFileInformation( $this->_x );



			$fullfile = $this->_completePath . $this->_x->name . '.' . $this->_x->type;





			$fileC->delete( $fullfile );




		}
		return true;

	}


























	public function move() {



		$file = WGet::file( $this->_storage );

		$fileInfoO = WObject::get( 'files.file' );

		$fileInfoO->fileID = $this->filid;

		$fileInfoO->name = $this->name;

		$fileInfoO->type = $this->type;

		$fileInfoO->folder = ( empty($this->folder) ? 'media' : $this->folder );

		$fileInfoO->path = $this->path;

		$fileInfoO->basePath = JOOBI_DS_USER;

		$fileInfoO->secure = $this->secure;

		$fileInfoO->thumbnail = $this->thumbnail;

		if ( !empty($this->filid) ) $file->setFileInformation( $fileInfoO );



		if ( $this->_noFileJustContent ) {

			return $file->write( $this->_tmp_name, $this->_completePath . DS . $this->name . '.' . $this->type );

		} elseif ( $this->_copy ) {

			return $file->copy( $this->_tmp_name, $this->_completePath . DS . $this->name . '.' . $this->type );

		} elseif ( $this->_uploadFile ) {

			return $file->upload( $this->_tmp_name, $this->_completePath . DS . $this->name . '.' . $this->type );

		}  else {

			return $file->move( $this->_tmp_name, $this->_completePath . DS . $this->name . '.' . $this->type );

		}


	}














	public function write($content,$destination=null) {





		$file = WGet::file( $this->_storage );

		$filename = $this->name . '.' . $this->type;



		$LOCATION = rtrim( $destination, DS ) . DS . rtrim($this->path, DS) . DS . $filename;

		$this->size = $file->write($LOCATION, $content, 'force');



		
		if ($this->size > 0) {



			$parts = explode(DS, $this->path);

			$this->path = implode('|', $parts);

			if ($this->_md5)

				$this->md5 = md5($content . microtime());



			$this->whereE('type', $this->type);

			$this->whereE('name', $this->name);

			$this->whereE('path', $this->path);

			$id = $this->existId();



			if (!empty ($id)) {

				$this->filid = $id;

				$this->_filid = $id;

				$this->_new = false;

			}


			if ( !parent::save() ) {

				$message = WMessage::get();

				$message->codeW('The file could not be saved in the file table: ' . $LOCATION . ' . You might have a dupliacate.');

				return false;

			}


			if ( !isset($this->filid) ) $this->_filid = $this->lastId();



			return true;



		} else {



			$message = WMessage::get();

			$message->userW('1212843257NVLI',array('$LOCATION'=>$LOCATION));

			return false;

		}


	}


















	public function convertPath($path='',$type='hdd') {

		if ( $type=='hdd' ) {

			$type = DS;

		} elseif ( $type=='url' ) {

			$type = '/';

		}
		return str_replace( array('|','\\','/'), $type, $path );

	}












	public function getFilePath() {



		if ( $this->secure ) {

			$path = JOOBI_DS_USER . 'safe' . DS . $this->convertPath( $this->path ) . DS . $this->name . '.' . $this->type;

		} else {

			$path = JOOBI_DS_USER . $this->convertPath( $this->path ) . DS . $this->name . '.' . $this->type;

		}


		return $path;



	}




















	private function _checkUnicity($unique=true,$external=false) {




		$file = WGet::file( $this->_storage );

		$fileName = ( $this->secure ) ? $this->md5 : $this->name;

		$result = true;

		$this->_currentFileID = 0;



		$i=1;	
		while ( $result ) {

			if ( $unique ) {	
				if ( !$file->checkExist() || !$file->exist( $this->_completePath . DS . $fileName .'.'. $this->type ) ) return true;

			} else {	
				$this->whereE('name', $this->name);

				$this->whereE('path', $this->path);

				$this->whereE('type', $this->type);

				if ( $external ) {



					if ( ($this->_currentFileID = $this->load('lr', 'filid') ) ) return false;

					else return true;

				} else {

					if ( !$this->existId() ) return true;

				}
			}
			
			$randomizedn = rand( 1000000000, 9999999999 );

			$this->name = $this->name . '_' . $randomizedn;

			$fileName = $this->name;

			if ( strlen($this->name) >= 254 ) $this->name = substr( $this->name , 0, 245 - $i );	
			$i++;

			if ( $i> 40 ) return false;	
		}


		return true;



	}}