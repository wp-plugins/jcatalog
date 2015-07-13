<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Parentarea_picklist extends WPicklist {

	function create() {



		$yid = WGlobals::get( 'parentAReaYID', 0, 'global' );



		if ( empty($yid) ) return true;

		$type = WView::get( $yid, 'type' );

		if ( $type == 2 ) {
						$layout = 'listings';
			$pkey = 'lid';
			$porpertyA = array( 'lid' );

		} else {
						$layout = 'forms';
			$pkey = 'fid';
			$porpertyA = array( 'fid', 'area' );

		}


		$viewElementM = WModel::get( 'library.view' . $layout );
		$viewElementM->makeLJ( 'library.view' . $layout . 'trans' );
		$viewElementM->whereLanguage();
		$viewElementM->select( 'name', 1 );
		$viewElementM->whereE( 'yid', $yid );
		$viewElementM->where( 'parentdft', '>', 0 );
		$viewElementM->orderBy( 'parentdft' );
		$allElementA = $viewElementM->load( 'ol', $porpertyA );


		if ( !empty($allElementA) ) {
			foreach( $allElementA as $oneElement ) {
				if ( !empty( $oneElement->area ) ) {
					$AREANAME = $oneElement->area;
					$extra = str_replace(array('$AREANAME'), array($AREANAME),WText::t('1397855844SRLO'));
				} else $extra = '';
				$this->addElement( $oneElement->$pkey, $oneElement->name . $extra );
			}		} else {
			return false;
		}



		return true;



	}
}