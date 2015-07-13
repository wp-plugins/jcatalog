<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Main_Area_picklist extends WPicklist {

	function create() {



		$this->addElement( '', ' - ' . WText::t('1206732410ICCJ') .  ' - ' );



		


		$yid = $this->getValue( 'yid' );

		$params = WView::get( $yid, 'params' );

		if ( !empty($params) ) {
			$o = new stdClass;
			$o->params = $params;

			WTools::getParams( $o );

			if ( !empty($o->viewarea) ) $allArea = json_decode( $o->viewarea );
		}


		if ( !empty( $allArea ) ) {



			foreach( $allArea as $oneArea ) {



				$this->addElement( $oneArea, $oneArea );



			}


		}


		return true;



	}
}