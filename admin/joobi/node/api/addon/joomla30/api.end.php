<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


















class WModule extends WElement {






	public function __construct($params){
		if( !empty($params->module)){
			$allModuleParams=$params->toArray();
		}else{
			$allModuleParams=$params;
		}

		if( !empty($allModuleParams)){
			foreach( $allModuleParams as $prop=> $value){
				$this->$prop=$value;
			}		}
		if( !empty( $params->module )){
			$this->module=$params->module;
			unset( $params->module );

						$eWidgetO=$this->_loadWidget( $this->module->id );
			if( empty($eWidgetO->widgetid)){
								$libraryCMSMenuC=WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
				$status=$libraryCMSMenuC->editExtensionPreferences( $this->module->id, 'com_modules' );

				$eWidgetO=$this->_loadWidget( $this->module->id );
			}
			if( !empty($eWidgetO->params)){
				$this->params=$eWidgetO->params;
				WTools::getParams( $this );
			}
		}
				$this->suffix=( isset($this->moduleclass_sfx) ? $this->moduleclass_sfx : ''  );
		$this->classes='moduletable';

				if( IS_ADMIN ) return true;

		$themeExist=WView::initializeTheme();
		if( true !==$themeExist ) return $themeExist;

	}




	public function make($notUsed1=null,$notUsed2=null){


		$this->create();

				$direct_edit_modules=WPref::load( 'PMAIN_NODE_DIRECT_EDIT_MODULES' );
		if( !empty( $direct_edit_modules )){
			$directEditClass=WClass::get( 'output.directedit' );
			$this->content=$directEditClass->editModule( $this->module->id ) . $this->content;
		}
				if( !empty($this->content)){
						$className='standardModule';
			if( !empty($this->module->name)) $className .=' ' . $this->module->name;
			if( !empty($this->module->id)) $className .=' wdgt_' . $this->module->id;
			$this->content='<div class="' . $className . '">' . $this->content .'</div>' . WView::popupMemory( '', true );
		}

		$status=$this->display();


				WPage::declareJS();
		return $status;

	}






	private function _loadWidget($moduleId){

		$mainWidgetM=WModel::get( 'library.widget' );
		$mainWidgetM->whereE( 'framework_id', $moduleId );
		$mainWidgetM->whereE( 'framework_type', 92 );
		$eWidgetO=$mainWidgetM->load( 'o', array( 'widgetid', 'params'));	
		return $eWidgetO;
	}

}





class WPlugin extends WObj {




	public function __construct($path=''){
		static $alreadyRegistered=array();

		$className=strtolower( get_class($this));
		$arrayExploded=explode( '_', $className );

				$plugin=JPluginHelper::getPlugin( $arrayExploded[1], $className );

		if( !empty($plugin->params)){
			$this->params=$plugin->params;
			WTools::getParams( $this );
		}
		if( !empty($path) && is_string($path) && !isset($alreadyRegistered[$path])){
						WApplication::cmsInitPlugin( $this );
			$alreadyRegistered[$path]=true;
		}
	}

	function onAfterInitialise(){
	}	function onAfterRoute(){
	}	function onAfterRender(){
	}	function onExtensionAfterInstall($a,$b){
		return true;
	}	function onExtensionAfterSave($a,$b){
		return true;
	}	function onExtensionAfterUninstall($a,$b,$c){
		return true;
	}	function onExtensionAfterUpdate($a,$b){
		return true;
	}	function onExtensionBeforeInstall($a,$b,$c,$d){
		return true;
	}	function onExtensionBeforeSave($a,$b){
		return true;
	}	function onExtensionBeforeUninstall($a){
		return true;
	}	function onExtensionBeforeUpdate($a,$b){
		return true;
	}	function onContentAfterDelete($a,$b){
	}	function onContentAfterSave($a,$b,$c){
	}	function onContentAfterTitle($a,$b,$c,$d){
	}	function onContentBeforeDelete($a,$b){
	}	function onContentBeforeSave($a,$b,$c){
	}	function onContentChangeState($a,$b,$c){
	}	function onContentPrepare($a,$b,$c,$d){
	}	function onContentAfterDisplay($a,$b,$c,$d){
	}	function onContentBeforeDisplay($a,&$b,&$c,$d){
	}	function onContentSearchAreas(){
	}	function onContentSearch($a,$b,$c,$d){
	}	function onUserAuthenticate($a,$b,$c){
		return true;
	}	function onUserBeforeSave($a,$b,$c){
		return true;
	}	function onUserAfterSave($a,$b,$c,$d){
		return true;
	}	function onUserBeforeDelete($a){
			return true;
	}	function onUserAfterDelete($a,$b,$c){
		return true;
	}	function onUserLogin($a,$b){
		return true;
	}	function onUserLogout($a,$b){
		return true;
	}	function onUserBeforeDeleteGroup($a){
		return true;
	}	function onUserAfterDeleteGroup($a,$b,$c){
		return true;
	}	function onUserBeforeSaveGroup($a){
		return true;
	}	function onUserAfterSaveGroup($a){
		return true;
	}	function onDisplay($a){
		return null;
	}
}