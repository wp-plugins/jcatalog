<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');







class Wordpress_Node_install extends WInstall {








	public function install(&$object) {

		try{



		if ( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall) ) {

			WText::load( 'wordpress.node' );

			$installWidgetsC = WClass::get( 'install.widgets' );
			$installWidgetsC->installWidgetType(
			  'wordpress.menus'
			  , "Joobi Menus"
			  , WText::t('1431633303POEA')
			  , WText::t('1431633304FVNB')
			  , 3				);

									$prefM = WPref::get( 'users.node' );
						$prefM->updatePref( 'framework_be', 'wordpress' );
			$prefM->updatePref( 'framework_be', 'wordpress' );
			$prefM->updatePref( 'activationmethod', 'none' );	
		}
		} catch (Exception $e) {
			WMessage::log( "\n install <br> " . $e->getMessage(), 'users_install' );
		}
		return true;


	}







	function version_205() {

				$filesA = array();
		$filesA[] = 'node/output/form/datetime.php';
		$filesA[] = 'node/output/form/media.php';
		$filesA[] = 'node/main/form/trans.php';
		$filesA[] = 'node/main/form/transarea.php';

		$this->_addThemeFile( 1, $filesA );

	}






	public function addExtensions() {

				if ( JOOBI_FRAMEWORK_TYPE != 'wordpress' ) return true;

				$extension = new stdClass;
		$extension->namekey = 'wordpress.quickicons.module';
		$extension->name = 'Joobi - Joobi Quick Icons';
		$extension->folder = 'quickicons';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|wordpress|module';
		$extension->core = 1;
		$extension->params = "position=icon\npublish=1\naccess=1\nclient=1\nordering=1";
		$extension->description = '';

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );



	}








 	private function _updateThemeFile($type,$filesA) {



	 			 		$themeM = WModel::get( 'theme' );
	 		$themeM->whereE( 'type', $type );
	 		$themeM->orderBy( 'tmid', 'ASC' );
			 		$this->_allThemeA = $themeM->load( 'ol', array( 'tmid', 'namekey', 'premium', 'core', 'folder' ) );


 		if ( empty($this->_allThemeA) ) return false;

 		 		$coreThemeO = null;
 		$hasClone = false;
 		foreach( $this->_allThemeA as $oneTheme ) {
 			if ( !empty($oneTheme->core) ) {
 				if ( empty($coreThemeO) ) $coreThemeO = $oneTheme;
 			} else {
 				$hasClone = true;
 			} 		}
 		if ( empty($coreThemeO) || empty($hasClone) ) return false;

 		
 		$fileS = WGet::file();
 				foreach( $this->_allThemeA as $oneTheme ) {

			if ( !empty($oneTheme->core) ) continue;

			$basePath = JOOBI_DS_THEME;

			$namekey = $coreThemeO->namekey;
			$namekeyA = explode( '.', $namekey );
			array_pop( $namekeyA );
			$location = array_pop( $namekeyA );
			$original = array_pop( $namekeyA );

			$baseOrignal = $basePath . $location . DS . $original . DS;
			$baseDestination = $basePath . $location . DS . $oneTheme->folder . DS;

						foreach( $filesA as $oneFile ) {

				$oneFile = str_replace( '/', DS, $oneFile );

				if ( $fileS->exist( $baseOrignal . $oneFile ) ) {

					if ( $fileS->exist( $baseDestination . $oneFile ) ) {
						$extensionA = explode( '.', $oneFile );
						$ext = array_pop( $extensionA );
						$file = implode( '.', $extensionA );
						$newName = $file . '.' . time() . '.bak.' . $ext;

						$fileS->move( $baseDestination . $oneFile, $baseDestination . $newName, true );

					}					$fileS->copy( $baseOrignal . $oneFile, $baseDestination . $oneFile, true );

				}
			}
		}
 	}








 	private function _addThemeFile($type,$filesA) {



	 			 		$themeM = WModel::get( 'theme' );
	 		$themeM->whereE( 'type', $type );
	 		$themeM->orderBy( 'tmid', 'ASC' );
			 		$this->_allThemeA = $themeM->load( 'ol', array( 'tmid', 'namekey', 'premium', 'core', 'folder' ) );



 		if ( empty($this->_allThemeA) ) return false;

 		 		$coreThemeO = null;
 		$hasClone = false;
 		foreach( $this->_allThemeA as $oneTheme ) {
 			if ( !empty($oneTheme->core) ) {
 				if ( empty($coreThemeO) ) $coreThemeO = $oneTheme;
 			} else {
 				$hasClone = true;
 			} 		}
 		if ( empty($coreThemeO) || empty($hasClone) ) return false;

 		
 		$fileS = WGet::file();
 				foreach( $this->_allThemeA as $oneTheme ) {

			if ( !empty($oneTheme->core) ) continue;

			$basePath = JOOBI_DS_THEME;

			$namekey = $coreThemeO->namekey;
			$namekeyA = explode( '.', $namekey );
			array_pop( $namekeyA );
			$location = array_pop( $namekeyA );
			$original = array_pop( $namekeyA );

			$baseOrignal = $basePath . $location . DS . $original . DS;
			$baseDestination = $basePath . $location . DS . $oneTheme->folder . DS;

						foreach( $filesA as $oneFile ) {

				$oneFile = str_replace( '/', DS, $oneFile );

				if ( $fileS->exist( $baseOrignal . $oneFile ) ) {

					$fileS->copy( $baseOrignal . $oneFile, $baseDestination . $oneFile, true );

				}
			}
		}
 	}


}