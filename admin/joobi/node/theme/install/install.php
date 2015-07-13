<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Theme_Node_install extends WInstall {

	public function install(&$object){

		if( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall)){

						$themeM=WModel::get( 'theme' );
			$themeM->setVal( 'premium', 1 );
			$themeM->whereE( 'core', 1 );
			$themeM->update();

									$imageM=WModel::get( 'files' );
			$imageM->whereE( 'name', 'default_theme' );
			$imageID=$imageM->load( 'lr', 'filid' );

			if(!empty($imageID)) return true;

						$filehandler=WGet::file();

			$src=JOOBI_DS_NODE .'theme' . DS . 'install' . DS . 'image'.DS. 'default_theme.png';
			if( !$filehandler->exist( $src )) return true;
			$content=$filehandler->read( $src );
			$dest='images' . DS . 'theme' ;
			$filehandler->write( JOOBI_DS_MEDIA . $dest . DS . 'thumbnails' . DS . 'default_theme.png', $content, 'overwrite'  );

						$imagesM=WModel::get( 'files' );
			if( !empty($imagesM)){


				$imagesM->saveOneFile( $content, 'default_theme.png', $dest, JOOBI_DS_MEDIA, true ); 
								$imagesM=WModel::get( 'files' ); 				$imagesM->setVal( 'core', 1 );
				$imagesM->setVal( 'storage', '0' );
				$imagesM->setVal( 'width', 80 );
				$imagesM->setVal( 'twidth', 80 );
				$imagesM->setVal( 'height', 120 );
				$imagesM->setVal( 'theight', 120 );
				$imagesM->setVal( 'thumbnail', 1 );
				$imagesM->whereE( 'name', 'default_theme' );
				$imagesM->whereE( 'type', 'png' );
				$imagesM->update();

			}
			$this->_installDefaultMailTheme();

		}
		return true;

	}





	private function _installDefaultMailTheme(){

		$themeM=WModel::get( 'theme' );
		$theme='none';
		$themeName='Default';

		$themeM->tmid=null;
				$themeM->setChild( 'themetrans', 'name', $themeName );
		$themeM->setChild( 'themetrans', 'description', 'The default newsletter theme.' );
		$themeM->namekey='mail.' . $theme;
		$themeM->folder=$theme;
		$themeM->publish=1;
		$themeM->core=1;
		$themeM->availability=1;
		$themeM->type=106;
		$themeM->ordering=1;
		$themeM->alias=$themeName . ' theme';
		$themeM->created=time();
		$themeM->modified=time();
		$themeM->save();

		return true;

	}




	public function addExtensions(){

				$extension=new stdClass;
		$extension->namekey='theme.system.plugin';
		$extension->name='Joobi - Bootstrap Skins for Theme';
		$extension->folder='system';
		$extension->type=50;
		$extension->publish=1;
		$extension->certify=1;
		$extension->destination='node|theme|plugin';
		$extension->core=1;
		$extension->params='publish=1';
		$extension->description='Overwrite the boostrap.css file with a skin file.';

		if( $this->insertNewExtension( $extension )) $this->installExtension( $extension->namekey );


	}


}