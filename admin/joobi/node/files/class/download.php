<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Files_Download_class extends WClasses {

	private $_fileInfoO = null;







	public function getFile($filid,$checkOwnership=true) {

		if ( empty($filid) ) return false;

		$filesHelperC = WClass::get( 'files.helper' );
		$this->_fileInfoO = $filesHelperC->getInfo( $filid );

		if ( empty($this->_fileInfoO) ) {
			$message = WMessage::get();
			$message->userE('1326470276GRUO');
		}
		if ( $checkOwnership ) {
			$uid = WUser::get( 'uid' );
			if ( $uid != $this->_fileInfoO->uid ) {
				$message = WMessage::get();
				$message->userE('1326470276GRUP');
			}		}


				if ( $this->_fileInfoO->type == 'url' ) {
			WPages::redirect( $this->_fileInfoO->name );
			return true;
		}
		$fileC = WGet::file( $this->_fileInfoO->storage );
		$this->_fileInfoO->fileID = $this->_fileInfoO->filid;
		$fileC->setFileInformation( $this->_fileInfoO );
		$fileC->download();

		exit();


	}






	public function ds($url) {

		if ( empty($url) ) return false;

		WPages::redirect( $url );


	}

}