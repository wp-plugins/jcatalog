<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Directedit_class extends WClasses {







	public function getParamsView($namekey,$typeOfView='') {

		$explodeA = explode( '.', $namekey );
		if ( empty($explodeA[1]) ) {
			$node = 'output';
			$type = $explodeA[0];
		} else {
			$node = $explodeA[0];
			$type = $explodeA[1];
		}
		$namekey = $node . '_' . $type;

		if ( !empty($typeOfView) ) $typeOfView .= '_';
		$namekey = $node . '_params_' . $typeOfView . $namekey;
		$controller = new stdClass;
		$controller->controller = $node;
		$controller->nestedView = true;
		$controller->wid = WExtension::get( $node,'wid' );


				$exist = WView::get( $namekey, 'yid', null, null, false );


			
		if ($exist) {
			return $namekey;
		} else {
			return false;
		}
	}
}