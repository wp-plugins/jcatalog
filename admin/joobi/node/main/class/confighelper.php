<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Confighelper_class extends WClasses {

	private $_dontProcessNamekeyA = array( 'install_page' );	
	private $_preferenceA = array();
	private $_mapA = array();





	public function renderConfig() {

		$prefA = WPref::$usedA;
		if ( empty($prefA) ) return '';
		$this->_getAllPreferencesA( $prefA );

		if ( empty($this->_preferenceA) ) return '';

		$html = '<p class="bg-warning">' . WText::t('1416948594GBIZ') . '</p> ';
		$html .= '<p class="bg-success">' . WText::t('1416948594GBJA');
		$html .= '<br />' . WText::t('1416948594GBJB') . '</p> ';

		if ( ! $this->_loadPrefForms() ) return '';


		$layout = WView::getHTML( 'main_configuration_form' );
		$html .= $layout->make();


		

		return $html;

	}





	public function renderViewDetails() {

		if ( empty(WView::$viewID[0]) ) return '';

		$yid = WView::$viewID[0];
		$myView = WView::get( $yid, 'name' ) . ' ( ' . WView::get( $yid, 'namekey' ) . ' )';
		$wid = WView::get( $yid, 'wid' );
		$node = WExtension::get( $wid, 'name' ) . ' ( ' . WExtension::get( $wid, 'namekey' ) . ' )';


		$theme = WView::definePath();
		$isCore = $this->_isCore( $yid );

		$value2DisplayA = array();
		$url = $this->_debuConvertURL();
		if ( !empty($url) ) {
			$value2DisplayA[WText::t('1419342002KFBC')] = $url;
		}		$value2DisplayA[WText::t('1416948594GBJC')] = $myView;
		$value2DisplayA[WText::t('1206732400OWXH')] = $node;
		$value2DisplayA[WText::t('1416948594GBJD')] = $isCore;
		$value2DisplayA[WText::t('1207306697RNME')] = $theme;

		$outputSpaceC = WClass::get( 'output.space' );
		$spaceO = $outputSpaceC->findSpace();
		if ( !empty($spaceO->namekey) ) {
			$space = $spaceO->namekey;
			$value2DisplayA[WText::t('1302502965PLCE')] = $space;
		}


		$html = '<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">' . WText::t('1416948594GBJC') . '</h3>
  </div>
  <div class="panel-body">';
		foreach( $value2DisplayA as $name => $output ) {
			$html .= '<div class="form-group clearfix">
      <label for="viewName" class="col-sm-2 control-label">' . $name . '</label>
      <div class="col-sm-10">' . $output . '</div>
    </div>';
		}$html .= '</div>
</div>';


		return $html;

	}





	private function _debuConvertURL() {

						$MainURL = WGlobals::get( 'MainURL', array(), 'global' );

		$finalURL = '';
		if ( !empty($MainURL) ) {

			foreach( $MainURL as $kye => $val ) {
				if ( !empty($finalURL) ) $finalURL .= '&';
				$finalURL .= $kye . '=' . $val;
			}
						$query = WGlobals::get('QUERY_STRING','','server');
			if ( !empty($query) ) {
				if ( !empty($finalURL) ) $finalURL .= '&';
				$finalURL .= $query;
			} else {
				$query = WGlobals::get('REDIRECT_QUERY_STRING','','server');
				if ( !empty($query) ) {
					if ( !empty($finalURL) ) $finalURL .= '&';
					$finalURL .= $query;
				} else {
					$queryA = WGlobals::get('argv','','server');
					if ( !empty($queryA[0]) ) {
						if ( !empty($finalURL) ) $finalURL .= '&';
						$finalURL .= $queryA[0];
					}				}			}
		}
		if ( !empty($finalURL) ) {
			$finalURL = WPage::completeURL( $finalURL );
		}
		return $finalURL;

	}





	private function _isCore($yid) {

		$type = WView::get( $yid, 'type' );
		if ( $type == 2 ) {
			$viewM = WModel::get( 'main.viewlisting' );
		} else {
			$viewM = WModel::get( 'main.viewform' );
		}
		$viewM->whereE( 'yid', $yid );
		$viewM->whereE( 'publish', 1 );
		$viewM->whereE( 'hidden', 0 );
		$viewM->whereE( 'core', 0 );
		$viewM->orderBy( 'ordering', 'ASC' );
		$allNoneCoreA = $viewM->load( 'lra', array( 'namekey' ) );

		if ( empty($allNoneCoreA) ) {
			$html = '<span class="label label-success">' . WText::t('1206732372QTKI') . '</span>';
		} else {
			$html = '<span class="label label-danger">' . WText::t('1206732372QTKJ') . '</span>';
			$html .= '<br />' . implode( '<br />', $allNoneCoreA );
		}
		return $html;

	}




	private function _loadPrefForms() {

		$multiformM = WModel::get( 'library.viewforms' );
		$multiformM->makeLJ( 'library.viewformstrans', 'fid' );
		$multiformM->whereLanguage();
		$multiformM->whereE( 'publish', 1 );
		$multiformM->whereIn( 'map', $this->_mapA );
		$multiformM->groupBy( 'map' );
		$allElementsA = $multiformM->load( 'ol' );

		if ( empty($allElementsA) ) return false;

		$SortedA = array();
		foreach( $allElementsA as $one ) {
			$SortedA[$one->map] = $one;
		}
		WGlobals::set( 'configElementA', $SortedA, 'global' );
		WGlobals::set( 'configOrderA', $this->_preferenceA, 'global' );

		return true;

	}





	private function _getAllPreferencesA($prefA) {

				$appsM = WModel::get( 'apps' );
		$appsM->rememberQuery( true );
		$appsM->whereE( 'showconfig', 0 );
		$dontProcessNodeA = $appsM->load( 'lra', 'namekey' );


		foreach( $prefA as $pref => $notUsed ) {
			$cst = substr( $pref, 1 ); 			$explodeMeA = explode( '_', strtolower($cst) );
			$extension = array_shift( $explodeMeA ) . '.' . array_shift( $explodeMeA );
			if ( in_array( $extension, $dontProcessNodeA ) ) continue;

			$prefNamekey = implode( '_', $explodeMeA );

			if ( in_array( $prefNamekey, $this->_dontProcessNamekeyA ) ) continue;

			$map = 'c[' . $extension . '][' . $prefNamekey . ']';

			$this->_mapA[$pref] = $map;
			$this->_preferenceA[$extension][$prefNamekey] = $map;

		}
	}
}