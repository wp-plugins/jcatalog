<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Parameters_class extends WClasses {







	public function getListingsElementEditViewParams() {

		$viewName = 'main_viewlisting_listing';
		return $this->getParamsElementOfView( $viewName );

	}





	public function getFormsElementEditViewParams() {

		$viewName = 'main_viewlisting_form';
		return $this->getParamsElementOfView( $viewName );

	}







	public function getParamsElementOfView($viewName) {


		$viewFormsM = WModel::get( 'library.viewforms' );
		$viewFormsM->makeLJ( 'library.view', 'yid' );
		$viewFormsM->whereE( 'namekey', $viewName, 1 );
		$viewFormsM->whereE( 'publish', 1 );
		$viewFormsM->where( 'map', 'LIKE', 'p[%' );
		$allElementA = $viewFormsM->load( 'lra', array( 'map' ) );

		if ( empty($allElementA) ) return array();

		$newA = array();
		foreach( $allElementA as $oneElement ) {
			$newA[] = substr( $oneElement, 2, -1 );

		}
		return $newA;

	}
}