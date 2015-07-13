<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WLoadFile( 'library.storage.class', JOOBI_DS_NODE );
class Main_s3_class extends Library_Storage_class {

	public $s3 = null;
	private $bucket	= null;
	private $useSSL = true;
	private $bucketPositionBefore = true;
	private $accessKey = null;
	private $secretKey = null;
	private $classType = null;
	private $endPoint = 's3.amazonaws.com';
	public $name = 's3';

	protected $fileInfoO = null;





	private function _setAccess() {

		if ( empty($this->bucket) ) {

			if ( !empty($this->storageID) ) {
								$mainCredentialsC = WClass::get( 'main.credentials' );
				$storageS3O = $mainCredentialsC->loadFromID( $this->storageID );
			} else {
				$mainCredentialsC = WClass::get( 'main.credentials' );
				$storageS3O = $mainCredentialsC->loadFromType( 's3' );
			}
			$this->bucket = $storageS3O->directory;
			$this->accessKey = $storageS3O->username;
			$this->secretKey = $storageS3O->passcode;
			if ( !empty($storageS3O->url) ) $this->endPoint = $storageS3O->url;
			if ( !empty($storageS3O->classtype) ) $this->classType = $storageS3O->classtype;
			if ( !empty($storageS3O->bucketafter) ) $this->bucketPositionBefore = false;
			$this->useSSL = ( !empty($storageS3O->ssl)  ? true : false );


			if ( empty($this->accessKey) || empty($this->secretKey) || empty($this->bucket) ) {
				$message = WMessage::get();
				$message->userE('1350003540HDZY');
			}


		}
	}

	private function _initializeS3() {

		if ( !isset($this->s3) ) {
			if ( !isset($this->bucket) ) $this->_setAccess();
			if ( empty($this->bucket) ) return false;

			WLoadFile( 'main.s3api.class', JOOBI_DS_NODE );
			$this->s3 = new S3( $this->accessKey, $this->secretKey, $this->useSSL, $this->endPoint );


		}
WMessage::log( 'using S3', 's3_usage' );


		return true;

	}





	public function fileURL() {

		if ( !isset($this->bucket) ) $this->_setAccess();

		$URL = 'http' . ( ( $this->useSSL ) ? 's' : '' );
		$URL .= '://';
		if ( $this->bucketPositionBefore ) {
			$URL .= $this->bucket;
			$URL .= '.';
			$URL .= $this->endPoint;
		} else {
			$URL .= $this->endPoint;
			$URL .= '/';
			$URL .= $this->bucket;
		}		$URL .= '/';

		$thumbnail = ( !empty($this->fileInfoO->thumbnail) ? $this->fileInfoO->thumbnail : false );
		$URL .= $this->_createAmazonS3BucketName( $thumbnail );

		return $URL;

	}







   public function checkExist() {
		return false;
   }







   public function exist($path,$file=false) {

   		if ( $file ) {
			return false;
   		}
   				return true;
   }








	public function copy($src,$dst,$file=false,$filter=null,$backup=false,$exclude=array()) {

		$fileS = WGet::file();
		$content = $fileS->read( $src );

		if ( !empty($content) ) {
			$this->write( $dst, $content );
		}
		return true;

   }









	public function move($src,$dst) {

		$fileS = WGet::file();
		$content = $fileS->read( $src );
		$fileS->delete( $src );

		if ( !empty($content) ) {
			$this->write( $dst, $content );
		}
		return true;

	}











	public function write($path,$content,$append=false,$chmod='0644') {

		if ( !$this->_initializeS3() ) return false;

		$fileAccess = $this->_convertCHMODtoACL( $chmod );


		$inputFile = array();
		$inputFile['data'] = $content;
		$inputFile['size'] = strlen($content);
		$inputFile['md5sum'] = base64_encode( md5( $content, true ) );
	  	if ( !$this->s3->putObject( $inputFile, $this->bucket, $path, $fileAccess ) ) {
	  		$message = WMessage::get();
			$message->userE('1360711865IYJW');
			return false;
	  	}
		return true;

  }







public function upload($src,$dst,$file=false) {

	if ( empty( $this->fileInfoO ) ) return false;

	if ( !$this->_initializeS3() ) return false;


		$fileAccess = S3::ACL_PUBLIC_READ;
		if ( !empty( $this->fileInfoO->secure ) ) $fileAccess = S3::ACL_AUTHENTICATED_READ;
		$tmpPath = JOOBI_DS_TEMP . 's3' . DS . $this->fileInfoO->folder . DS . $this->fileInfoO->path . DS . $this->fileInfoO->name . '.' . $this->fileInfoO->type;
		$tmpSource = str_replace( array( '|', '\\'), DS, $tmpPath );
		$fileC = WGet::file( 'local' );
		if ( $fileC->exist($tmpSource) ) {
						$src = $tmpSource;
		}
				if ( $this->s3->putObjectFile( $src, $this->bucket, $this->_createAmazonS3BucketName(), $fileAccess, array(), $this->classType ) ) {
						$fileC = WGet::file( 'local' );
			$fileC->delete( $src );

									if ( !empty($this->fileInfoO->thumbnail) && in_array( $this->fileInfoO->type, array( 'jpg', 'png', 'gif' ) ) ) {

				$thumbnailsPath = JOOBI_DS_TEMP . 's3' . DS . $this->fileInfoO->folder . DS . $this->fileInfoO->path . DS . 'thumbnails' . DS . $this->fileInfoO->name . '.' . $this->fileInfoO->type;
				$thumbnailSource = str_replace( array( '|', '\\'), DS, $thumbnailsPath );

				$this->s3->putObjectFile( $thumbnailSource, $this->bucket, $this->_createAmazonS3BucketName( true ), $fileAccess, array(), $this->classType );

				
				$fileC->delete( $thumbnailSource );

			}
			return true;
		}
		$message = WMessage::get();
		$message->userE('1360711865IYJX');

		return false;

  }





	public function download() {

		if ( empty($this->fileInfoO->secure) ) {
			
			$url = $this->fileURL();

		} else {
			
			$url = $this->_s3_getTemporaryLink();

		}
		if ( !empty($url) ) {
			WPages::redirect( $url );

			
		}
	}







	public function delete($path,$file=true) {

		if ( empty( $this->fileInfoO ) ) return false;

		if ( !$this->_initializeS3() ) return false;
		$this->s3->deleteObject( $this->bucket, $this->_createAmazonS3BucketName() );

		return true;

	}







 	public function makePath($folder,$path='') {
 		return JOOBI_DS_TEMP . 's3' . DS . $folder . ( !empty($path) ? DS . $path : '' );
 	}




	private function _createAmazonS3BucketName($thumbnails=false) {

		$basePath = $this->fileInfoO->path;
		if ( !empty($this->fileInfoO->folder) ) $basePath = $this->fileInfoO->folder . '/' . $basePath;
		$path = str_replace( array( '|', '\\'), '/', $basePath );
		if ( $thumbnails ) $path .= '/thumbnails';
				$fileNameInBucket = $path . '/' . $this->fileInfoO->name;			if ( !empty($this->fileInfoO->fileID) ) $fileNameInBucket .= '-' . $this->fileInfoO->fileID;
		$fileNameInBucket .= '.' . $this->fileInfoO->type;

		return $fileNameInBucket;

	}














    private function _s3_getTemporaryLink($expires=5) {

    	if ( !isset($this->bucket) ) $this->_setAccess();

    	$path = $this->_createAmazonS3BucketName();

            $expires = time() + intval(floatval($expires) * 60);
            $path = str_replace('%2F', '/', rawurlencode($path = ltrim($path, '/')));
            $signpath = '/'. $this->bucket .'/'. $path;
            $signsz = implode("\n", $pieces = array('GET', null, null, $expires, $signpath));

            $signature = $this->_crypto_hmacSHA1($this->secretKey, $signsz);
      
      $startURL = 'http' . ( ( $this->useSSL ) ? 's' : '' ) . '://';
	if ( $this->bucketPositionBefore ) {
		$startURL .= $this->bucket;
		$startURL .= '.';
		$startURL .= $this->endPoint;
	} else {
		$startURL .= $this->endPoint;
		$startURL .= '/';
		$startURL .= $this->bucket;
	}	$startURL .= '/';
	$startURL .= $path;


            $qs = http_build_query($pieces = array(
        'AWSAccessKeyId' => $this->accessKey,
        'Expires' => $expires,
        'Signature' => $signature,
      ));

            return $startURL . '?' . $qs;

    }
 




	private function _convertCHMODtoACL($chmod) {

	  	$newAccess = substr( $chmod, -1 );
	  	if ( $newAccess >= 6 ) $fileAccess = S3::ACL_PUBLIC_READ_WRITE;
	  	elseif ( $newAccess >= 4 ) $fileAccess = S3::ACL_PUBLIC_READ;
	  	else  $fileAccess = S3::ACL_PRIVATE;

	  	return $fileAccess;

	}


    







    private function _crypto_hmacSHA1($key,$data,$blocksize=64) {
        if (strlen($key) > $blocksize) $key = pack('H*', sha1($key));
        $key = str_pad($key, $blocksize, chr(0x00));
        $ipad = str_repeat(chr(0x36), $blocksize);
        $opad = str_repeat(chr(0x5c), $blocksize);
        $hmac = pack( 'H*', sha1(
        ($key ^ $opad) . pack( 'H*', sha1(
          ($key ^ $ipad) . $data
        ))
      ));
        return base64_encode($hmac);
    }

}