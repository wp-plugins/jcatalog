<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




class Apps_Node_install extends WInstall {






	public function install($object){
				$pref=WPref::get( 'install.node' );

		$appsUserinfosM=WModel::get( 'apps.userinfos' );
		$appsUserinfosM->makeLJ( 'apps', 'wid' );
		$appsUserinfosM->where( 'expire', '>', time());
		$appsUserinfosM->whereE( 'enabled', 1 );
		$appsUserinfosM->whereE( 'type', 1, 1 );
		$appsUserinfosM->where( 'namekey', '!=', 'jiptracker.application', 1 );			$appsUserinfosM->select( 'name', 1 );
		$appsUserinfosM->orderBy( 'name', 'ASC', 1 );
		$allAppsA=$appsUserinfosM->load( 'lra' );

		if( !empty($allAppsA)){
						$appsInstallC=WClass::get( 'apps.install' );
			$count=1;
			foreach( $allAppsA as $oneApp){
				$appsInstallC->createDashboardMenu( $oneApp, $count );
				$count++;
			}
		}

		if( !empty($this->newInstall) || (property_exists($object, 'newInstall') && $object->newInstall)){
			
			$this->_checkMultiLanguageSite();

			$this->_insertDefaultPreferences4Themes();

		}else{

						$folderS=WGet::folder();
			$loc=JOOBI_DS_INC . 'openflashchart';
			if( $folderS->exist($loc)){
				$folderS->delete($loc);
			}
					}
	}





	function version_3191(){

		$extM=WModel::get( 'apps' );
		$extM->whereIn( 'type', array( 1, 150 ));
		$extM->whereE( 'publish', 1 );
		$allEXtesnionA=$extM->load( 'lra' , array( 'wid' ));

		if( empty( $allEXtesnionA )) return true;

		$mainPrefrencesC=WClass::get( 'apps.preferences', null, 'class', false );
		foreach( $allEXtesnionA as $wid){
		 	$folder=WExtension::get( $wid, 'folder' );
		 	$status=$mainPrefrencesC->updatePreferences( $wid, $folder );
		}

	}





	function version_3190(){

		$libraryCMSMenuC=WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
		$libraryCMSMenuC->installModulePreferencesFile();


	}





	function version_2960(){

				if( 'joomla'==JOOBI_FRAMEWORK_TYPE && 'jcenter' !=JOOBI_MAIN_APP){
			$folderS=WGet::folder();
			$folderS->copy( JOOBI_DS_ROOT . 'components' . DS . 'com_jcenter' . DS . 'fields', JOOBI_DS_ROOT . 'components' . DS . 'com_' . JOOBI_MAIN_APP . DS . 'fields' );
		}
		
				$appsUserInfosM=WModel::get( 'apps.userinfos' );
		$appsUserInfosM->makeLJ( 'apps' );
		$appsUserInfosM->whereE( 'namekey', 'jcenter.application', 1 );
		$token=$appsUserInfosM->load( 'lr', 'token' );

		if( !empty($token)){

						$sx1Token=array( 'ACA', 'MOB', 'MOV', 'TOK', 'MAN', 'DEM', 'API' );

			$tID=strtoupper( substr( $token, 0, 3 ));

			if( in_array( $tID, $sx1Token )){					$ltypeTolicence=0;
				$widTolicence=0;
				$levelTolicence=0;
				$appsInfoC=WClass::get( 'apps.info' );
				$status=$appsInfoC->requestCandy( $ltypeTolicence, $widTolicence , $levelTolicence, $token, true );

			}
		}


	}


	function version_2349(){

				if( !class_exists('Install_Common_class')) require_once( dirname(dirname(__FILE__)) . DS . 'class' . DS . 'common.php' );
		Install_Common_class::writeFrameworkDefaultConfigFile();

	}





	public function addExtensions(){

		$extension=new stdClass;
		$extension->namekey='apps.system.plugin';
		$extension->name='Joobi - Debug Traces';
		$extension->folder='system';
		$extension->type=50;
		$extension->publish=1;
		$extension->certify=1;
		$extension->destination='node|apps|plugin';
		$extension->core=1;
		$extension->params='publish=1';
		$extension->description='This is a plugin to see all the debug traces at the bottom of the page.';

		if( $this->insertNewExtension( $extension )) $this->installExtension( $extension->namekey );

	}





	private function _checkMultiLanguageSite(){
		
		
				$languagesA=WApplication::availLanguages( 'lgid', 'all' );
		if( count( $languagesA ) > 1){
						$pref=WPref::get( 'library.node' );
			$pref->updatePref( 'multilang', 1 );

			$cache=WCache::get();
			$cache->resetCache( 'Preference' );
		}
	}





	private function _insertDefaultPreferences4Themes(){

		$joomla30='font_awesome=1
image_responsive=1
image_style=rounded
nav_logoname=app-joobi-logo
nav_brand=Nav
nav_uselogo=1
pagination=11
nav_showicon=1
form_tabfade=1
pane_color=1
pane_icon=1
tooltip_html=1
alert_dismiss=1
alert_collapse=1
button_icon=1
button_color=1
view_icon=1
wizard_color=1
form_direction=horizontal
toolbar_color=1
toolbar_group=1
toolbar_icon=1
table_maxlist=20
table_hover=1
table_striped=1
table_columniconcolor=1
table_buttonicon=1
table_buttontext=1';




		$themeM=WModel::get( 'theme' );

		$themeM->whereIn( 'namekey', array( 'joomla30.admin.theme', 'wp40.admin.theme' ));

		$themeM->setVal( 'params', $joomla30 );
		$themeM->update();

	}
}