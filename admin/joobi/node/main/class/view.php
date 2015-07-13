<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Main_View_class extends WClasses {






	public function uncoreView() {

		$eidA = WGlobals::get( true );

		if ( empty( $eidA ) ) return true;

		foreach( $eidA as $oneView ) {
			$this->_unCoreView( $oneView );
		}
	}






	public function recoreView() {

		$eidA = WGlobals::getEID( true );

		if ( empty( $eidA ) ) return true;

		foreach( $eidA as $oneView ) {
			$this->_recoreView( $oneView );
		}
		if ( count($eidA) > 1 ) {
			$this->userS('1408059813TBDS');
		} else {
			$this->userS('1408059813TBDT');
		}
		$this->userS('1420854481TJBT');

	}






	public function reRestoreView() {

		$eidA = WGlobals::getEID( true );

		if ( empty( $eidA ) ) return true;

		foreach( $eidA as $oneView ) {
						$this->_recoreView( $oneView );
						$this->_reRestoredView( $oneView );
		}
		if ( count($eidA) > 1 ) {
			$this->userS('1420854481TJBU');
		} else {
			$this->userS('1420854481TJBV');
		}
	}






	private function _reRestoredView($yid) {

		$namekey = WView::get( $yid, 'namekey' );
		$node = WExtension::get( WView::get( $yid, 'wid' ), 'folder' );

				$filename = $namekey . '.cca';
		$path = JOOBI_DS_NODE . $node . DS . 'database' . DS;

		$origin = $path . 'installed' . DS . 'view' . DS . $filename;
		$dest = $path . 'data' . DS . 'view' . DS . $filename;

		$fileS = WGet::file();
		if ( $fileS->exist( $origin ) ) {
			 $fileS->move( $origin, $dest, true );
		} else {
			if ( ! $fileS->exist( $dest ) ) return false;
		}

				$reload = WViews::checkExistFileForInserting( $namekey );


	}




	private function _recoreView($yid) {

	$viewsA = array();
	$viewsA[] = 'main.viewform';
	$viewsA[] = 'main.viewlisting';
	$viewsA[] = 'main.viewmenu';

	
	foreach( $viewsA as $model ) {
		$mainViewM = WModel::get( $model );
		$mainViewM->whereE( 'yid', $yid );
		if ( in_array( $model, array( 'main.viewform', 'main.viewlisting' ) ) ) $mainViewM->where( 'fdid', '=', 0 );
		$mainViewM->setVal( 'core', 1 );
		$mainViewM->update();
	}

	}







	private function _unCoreView($yid) {

		$viewsA = array();
		$viewsA[] = 'main.view';
		$viewsA[] = 'main.viewform';
		$viewsA[] = 'main.viewlisting';
		$viewsA[] = 'main.viewmenu';

		
		foreach( $viewsA as $model ) {
			$mainViewM = WModel::get( $model );
			$mainViewM->whereE( 'yid', $yid );
			$mainViewM->setVal( 'core', 0 );
			$mainViewM->update();
		}


	}
}