<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Images_Node_install extends WInstall {

	public function install(&$object){


				if( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall)){

			$this->_fontFile();
		}


		return true;


	}







	private function _fontFile(){
		$file=WGet::file();
		$file->move( JOOBI_DS_NODE .'images' . DS . 'install' . DS . 'monofont.ttf', JOOBI_DS_MEDIA . 'fonts' . DS . 'monofont.ttf' );
		return true;
	}

}