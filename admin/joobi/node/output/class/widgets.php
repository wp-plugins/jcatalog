<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












class Output_Widgets_class extends WClasses {

	private static $_myWidgetA=array();







	public function preLoadWidgetsForView($yid){

		if( empty($yid)) return false;

		$allWidgetsA=$this->_loadWidgetsFromYID( $yid );

				if( empty( $allWidgetsA )){
						$installWidgetsC=WClass::get( 'install.widgets' );
			$installStatus=$installWidgetsC->installViewWidgets( $yid );
			if( $installStatus===false ) return false;

			$allWidgetsA=$this->_loadWidgetsFromYID( $yid );
			if( empty($allWidgetsA)) return false;

		}
				foreach( $allWidgetsA as $oneWidget){
			self::$_myWidgetA[$yid][$oneWidget->widgetid]=$oneWidget;
		}
		return true;

	}








	public function loadWidgetsForView($yid,$widgetid){

		if( empty($yid) || empty($widgetid)) return false;

		if( !empty( self::$_myWidgetA[$yid][$widgetid] )) return self::$_myWidgetA[$yid][$widgetid];
		else return null;

	}








	public function createWidgetString(&$oneWidget,$overWritePArams=null){

				$tag='{widget:';
		$namekeyA=explode( '.', $oneWidget->namekey );
		$tag .=$namekeyA[1];

		if( !empty($oneWidget->params)){
						$newObj=new stdClass();
			$newObj->params=$oneWidget->params;
			WTools::getParams( $newObj );

			if( !empty($overWritePArams)){
				foreach( $overWritePArams as $oneOverK=> $oneOverV){
					$newObj->$oneOverK=$oneOverV;
				}			}
						if( !empty($widgetParams->pagination) && !empty($widgetParams->yid)){
								if( empty($newObj->nb)) $newObj->nb=10;					elseif( $newObj->nb > 500 ) $newObj->nb=500;
			}

			foreach( $newObj as $oneKey=> $oneVal){
				$tag .='|' . $oneKey . '=' . $oneVal;
			}
			WTools::getParams( $oneWidget );
		}		$tag .='}';

		return $tag;

	}






	public function loadWidgetsFromNamekey($namekey){


		$mainWIdgetsM=WModel::get( 'main.widget' );
		$mainWIdgetsM->makeLJ( 'main.widgettrans', 'widgetid' );
		$mainWIdgetsM->whereLanguage();
		$mainWIdgetsM->makeLJ( 'main.widgettype', 'wgtypeid', 'wgtypeid', 0, 2 );
		if( is_string($namekey)){
			$mainWIdgetsM->whereE( 'namekey', $namekey );
		}else{
			$mainWIdgetsM->whereIn( 'namekey', $namekey );
		}
		$mainWIdgetsM->whereE( 'publish', 1 );
		$mainWIdgetsM->checkAccess();

		$mainWIdgetsM->select( 'name', 1 );
		$mainWIdgetsM->select( 'namekey', 2 );
		$mainWIdgetsM->select( 'namekey', 0, 'namekeyWidget' );

		$allWidgetsA=$mainWIdgetsM->load( 'ol', array( 'params' ));

		return $allWidgetsA;

	}






	private function _loadWidgetsFromYID($yid){

		$caching=WPref::load( 'PLIBRARY_NODE_CACHING' );
		$caching=( $caching > 5 ) ? 'cache' : 'static';

		 $getModel=true;

		if( $caching > 5){

			$nameCache='Zx-widgets-'. $yid;

						$cache=WCache::get();
			$allWidgetsA=$cache->get( $nameCache, 'Views' );
			if( !empty($allWidgetsA)) $getModel=false;
		}
		if( $getModel){

			$mainWIdgetsM=WModel::get( 'main.widget' );
			$mainWIdgetsM->makeLJ( 'main.widgettrans', 'widgetid' );
			$mainWIdgetsM->whereLanguage();
			$mainWIdgetsM->makeLJ( 'main.widgettype', 'wgtypeid', 'wgtypeid', 0, 2 );
			$mainWIdgetsM->whereE( 'framework_type', 5 );
			$mainWIdgetsM->whereE( 'framework_id', $yid );
			$mainWIdgetsM->whereE( 'publish', 1 );
			$mainWIdgetsM->select( 'name', 1 );
			$mainWIdgetsM->select( 'namekey', 2 );
			$mainWIdgetsM->checkAccess();
			$allWidgetsA=$mainWIdgetsM->load( 'ol', array( 'widgetid', 'params' ));

		}
		if( $caching >5){
			$cache->set( $nameCache, $allWidgetsA, 'Views' );

		}
		return $allWidgetsA;

	}
 }