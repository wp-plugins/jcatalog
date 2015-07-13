<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Node_install extends WInstall {

	public function install(&$object) {

		if ( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall) ) {

			
						$fileC = WGet::file();
			$directory = JOOBI_DS_NODE . 'main' . DS . 'install' . DS . 'images' .DS;
			$fileC->move( $directory . 'mgopencosmeticabold.ttf', JOOBI_DS_MEDIA . 'fonts'. DS . 'mgopencosmeticabold' . DS . 'mgopencosmeticabold.ttf', 'force' );
			$fileC->move( $directory . 'StayPuft.sfd', JOOBI_DS_MEDIA . 'fonts' . DS . 'staypuft' . DS . 'StayPuft.sfd', 'force' );
			$fileC->move( $directory . 'staypuft.ttf', JOOBI_DS_MEDIA . 'fonts' . DS . 'staypuft' . DS . 'staypuft.ttf', 'force' );


						$themeM = WModel::get( 'theme' );
			$themeM->whereE( 'namekey', 'joomla.admin.theme' );
			$themeM->setVal( 'premium', 0 );
			$themeM->update();

			$themeM->whereIn( 'type', array( 1, 3 ) );
			$themeM->setVal( 'premium', 0 );
			$themeM->update();

						if ( 'wordpress' == JOOBI_FRAMEWORK_TYPE ) {
				$themeM->whereE( 'namekey', 'wp40.site.theme' );
				$themeM->setVal( 'premium', 1 );
				$themeM->update();
			} else {
				$themeM->whereE( 'namekey', 'joomla30.site.theme' );
				$themeM->setVal( 'premium', 1 );
				$themeM->update();
			}

			$themeM->whereE( 'namekey', 'vendors30.site.theme' );
			$themeM->setVal( 'premium', 1 );
			$themeM->update();

			$this->_insertDefaultPreferences4Themes();

			$this->_createDefaultSpace();

			WText::load( 'main.node' );

			$schedulerInstallC = WClass::get( 'scheduler.install' );
			$schedulerInstallC->newScheduler(
			  'main.checkupdate.scheduler'
			, WText::t('1347916591IUDQ')
			, WText::t('1302519272IRLM')
			, 100				, 604800				, 60				, 1					);

			$schedulerInstallC->newScheduler(
			  'main.optimize.scheduler'
			, WText::t('1347916591IUDQ')
			, WText::t('1302519272IRLM')
			, 200				, 86400				, 60				, 1					);

			$schedulerInstallC->newScheduler(
			  'email.queue.scheduler'
			, WText::t('1374608348GDGV')
			, WText::t('1374608348GDGW')
			, 1				, 60				, 60				, 1					);

			$schedulerInstallC->newScheduler(
			  'email.cleanstats.scheduler'
			, WText::t('1391607531FXMD')
			, WText::t('1391607531FXME')
			, 50				, 86400				, 60				, 1					);


			$installWidgetsC = WClass::get( 'install.widgets' );
			$installWidgetsC->installWidgetType(
			  'main.time'
			  , "Time widget"
			  , WText::t('1242282413PMNG')
			  , WText::t('1377041362DLCC')
			  , 17				);


			$installWidgetsC = WClass::get( 'install.widgets' );
			$installWidgetsC->installTable( 'main.credentialtype', $this->_installValuesA() );


		}


						$libraryCMSMenuC = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
		$libraryCMSMenuC->installModulePreferencesFile();


						$installWidgetsC = WClass::get( 'install.widgets' );

		$installStatus = $installWidgetsC->installWidgets( 'main.node' );



		return true;


	}






	function version_2588() {

				$filesA = array();
		$filesA[] = 'node/output/form/datetime.php';
		$filesA[] = 'node/output/form/media.php';
		$filesA[] = 'node/main/form/trans.php';
		$filesA[] = 'node/main/form/transarea.php';

		$this->_addThemeFile( 1, $filesA );

	}





















	public function addExtensions() {

				$extension = new stdClass;
		$extension->namekey = 'main.system.plugin';
		$extension->name = 'Joobi - Replace widgets';
		$extension->folder = 'system';
		$extension->type = 50;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|main|plugin';
		$extension->core = 1;
		$extension->params = 'publish=0';
		$extension->description = 'Replace tags and widgets in Joomla components / pages.';

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );

				$extension = new stdClass;
		$extension->namekey = 'main.content.plugin';
		$extension->name = 'Joobi - Repalce Widgets in Articles';
		$extension->folder = 'content';
		$extension->type = 50;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|main|plugin';
		$extension->core = 1;
		$extension->params = 'publish=0';
		$extension->description = 'Replace tags and widgets in Joomla contents / articles.';

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );


				$extension = new stdClass;
		$extension->namekey = 'main.button.plugin';
		$extension->name = 'Joobi - Widgets button';
		$extension->folder = 'editors-xtd';
		$extension->type = 50;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|main|plugin';
		$extension->core = 1;
		$extension->params = 'publish=1';
		$extension->description = 'Insert Widgets into a content.';

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );


				$extension = new stdClass;
		$extension->namekey = 'main.design.module';
		$extension->name = 'Joobi - Design Module';
		$extension->folder = 'design';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|main|module';
		$extension->core = 1;
		$extension->params = "publish=1\nposition=position-7\naccess=3";
		$extension->description = 'Module to edit views and change translations directly from the front-end of the site';
		$libraryCMSMenuC = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
		$extension->install = $libraryCMSMenuC->modulePreferences();

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );


				$extension = new stdClass;
		$extension->namekey = 'main.googletranslate.module';
		$extension->name = 'Joobi - Automatic Language Translator ( Google )';
		$extension->folder = 'login';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|main|module';
		$extension->core = 1;
		$extension->params = "publish=0\nposition=position-7\nordering=99";
		$extension->description = 'Language pick-list to automatically translate the site with Google translate API.';

		$libraryCMSMenuC = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
		$extension->install = $libraryCMSMenuC->modulePreferences();

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );


	}






	public function addWidgets() {
				$allWidgetsA = array();

				$widget = new stdClass;
		$widget->namekey = 'firstname';
		$widget->alias = 'First Name';
		$widget->name = 'First Name';
		$widget->framework_type = 13;
		$widget->widgetType = 'users.user';
		$widget->params = 'select=firstname';
				$allWidgetsA[] = $widget;

				$widget = new stdClass;
		$widget->namekey = 'name';
		$widget->alias = 'Name';
		$widget->name = 'Name';
		$widget->framework_type = 13;
		$widget->widgetType = 'users.user';
		$widget->params = 'select=name';
				$allWidgetsA[] = $widget;

		$widget = new stdClass;
		$widget->namekey = 'lastname';
		$widget->alias = 'Last Name';
		$widget->name = 'Last Name';
		$widget->framework_type = 13;
		$widget->widgetType = 'users.user';
		$widget->params = 'select=lastname';
				$allWidgetsA[] = $widget;

		$widget = new stdClass;
		$widget->namekey = 'username';
		$widget->alias = 'Username';
		$widget->name = 'Username';
		$widget->framework_type = 13;
		$widget->widgetType = 'users.user';
		$widget->params = 'select=username';
				$allWidgetsA[] = $widget;

		$widget = new stdClass;
		$widget->namekey = 'email';
		$widget->alias = 'email';
		$widget->name = 'email';
		$widget->framework_type = 13;
		$widget->widgetType = 'users.user';
		$widget->params = 'select=email';
				$allWidgetsA[] = $widget;

		return $allWidgetsA;

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
 			} 		} 		if ( empty($coreThemeO) || empty($hasClone) ) return false;

 		
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





 	private function _createDefaultSpace() {

 		$roleC = WRole::get();
 		$regRole = $roleC->getRole( 'registered' );

				$spaceM = WModel::get( 'space' );
		$spaceM->namekey = 'site';
		$spaceM->alias = 'Space for Users in the site';
		$spaceM->setChild( 'spacetrans', 'name', 'Users' );
		$spaceM->setChild( 'spacetrans', 'description', 'Default Space for Users within Joomla theme' );
		$spaceM->publish = 1;
		$spaceM->core = 1;
		$spaceM->controller = 'users';
		$spaceM->theme = 'joomla30.site.theme';
		$spaceM->menu = 'users_node_horizontalmenu_fe';
		$spaceM->rolid = $regRole;
		$spaceM->frameworktheme = 1;
		$spaceM->setIgnore();
		$spaceM->save();

 	}





	private function _insertDefaultPreferences4Themes() {

		$joomlaSite30 = 'font_awesome=auto
image_responsive=1
image_style=rounded
nav_logoname=Nav
nav_brand=fa-home
nav_uselogo=1
nav_showicon=1
form_tabfade=1
pane_color=1
pane_icon=1
pagination=1
tooltip_html=1
button_icon=1
button_color=1
wizard_color=1
form_direction=horizontal
toolbar_color=1
toolbar_group=1
toolbar_icon=1
table_maxlist=10
table_condensed=1
table_hover=1
table_striped=1
table_columniconcolor=1
table_buttoncolor=1
table_buttonicon=1
table_buttontext=0
catalog_container=panel
catalog_starcolor=warning
catalog_starsize=large
catalog_addcarticon=fa-shopping-cart
catalog_addcartcolor=primary
catalog_addcartsize=xlarge
catalog_reviewicon=fa-comment
catalog_reviewcolor=default
catalog_reviewsize=xsmall
catalog_detailicon=fa-eye
catalog_detailcolor=success
catalog_detailsize=small
catalog_questioncolor=warning
catalog_questionsize=small
catalog_viewallicon=fa-eye
catalog_viewallcolor=default
catalog_viewallsize=small
catalog_carticon=fa-shopping-cart
catalog_cartcolor=primary
catalog_cartsize=standard
catalog_vendorsregistericon=fa-check-square-o
catalog_vendorsregistercolor=primary
catalog_vendorsregistersize=small
socialicon_group=1
socialicon_size=small
catalog_cartupdateicon=fa-refresh
catalog_cartupdatecolor=primary
catalog_cartupdatesize=standard
catalog_cartpreviousicon=fa-chevron-left
catalog_cartpreviouscolor=warning
catalog_cartprevioussize=standard
catalog_cartpreviousiconposition=left
catalog_cartnexticon=fa-chevron-right
catalog_cartnextcolor=primary
catalog_cartnextsize=standard
catalog_cartnexticonposition=right
catalog_viewmapicon=fa-globe
catalog_viewmapsize=xsmall
catalog_editaddressicon=fa-map-marker
catalog_editaddresssize=xsmall';

		$joomlaVendors30 = 'font_awesome=auto
image_responsive=1
image_style=rounded
nav_logoname=Nav
nav_brand=app-joobi-logo
nav_uselogo=1
nav_showicon=1
form_tabfade=1
pagination=1
pane_color=1
pane_icon=1
tooltip_html=1
alert_dismiss=1
button_icon=1
button_color=1
view_icon=1
wizard_color=1
form_direction=horizontal
toolbar_color=1
toolbar_group=1
toolbar_icon=1
table_maxlist=10
table_hover=1
table_striped=1
table_columniconcolor=1
table_buttoncolor=1
table_buttonicon=1
table_buttontext=1';

		$themeM = WModel::get( 'theme' );
		if ( 'wordpress' == JOOBI_FRAMEWORK_TYPE ) {
			$themeM->whereIn( 'namekey', array( 'wp40.site.theme', 'wpbootstrap.site.theme' ) );
		} else {
			$themeM->whereIn( 'namekey', array( 'joomla30.site.theme', 'virtuemart.site.theme' ) );
		}
		$themeM->setVal( 'params', $joomlaSite30 );
		$themeM->update();

		$themeM->whereE( 'namekey', 'vendors30.site.theme' );
		$themeM->setVal( 'params', $joomlaVendors30 );
		$themeM->update();

	}












	private function _installValuesA() {

		return array(
  array('crdidtype' => '1','namekey' => 'local','alias' => 'Local Disk','rolid' => '1','core' => '1','publish' => '1','category' => '3'),
  array('crdidtype' => '2','namekey' => 's3','alias' => 'Amazon S3','rolid' => '7','core' => '1','publish' => '1','category' => '3'),
  array('crdidtype' => '3','namekey' => 'dropbox','alias' => 'Dropbox','rolid' => '7','core' => '0','publish' => '0','category' => '3'),
  array('crdidtype' => '4','namekey' => 'drive','alias' => 'Google Drive','rolid' => '7','core' => '0','publish' => '0','category' => '3'),
  array('crdidtype' => '5','namekey' => 'tweeter','alias' => 'Tweeter','rolid' => '3','core' => '1','publish' => '1','category' => '7'),
  array('crdidtype' => '6','namekey' => 'facebook','alias' => 'Facebook','rolid' => '3','core' => '1','publish' => '1','category' => '7'),
  array('crdidtype' => '7','namekey' => 'googleapi','alias' => 'Google API','rolid' => '3','core' => '1','publish' => '1','category' => '11'),
  array('crdidtype' => '8','namekey' => 'infusionsoft','alias' => 'InfusionSoft','rolid' => '8','core' => '1','publish' => '1','category' => '11'),
  array('crdidtype' => '9','namekey' => 'recaptcha','alias' => 'reCaptcha','rolid' => '1','core' => '1','publish' => '1','category' => '11')
);

	}

}