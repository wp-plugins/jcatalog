<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_Node_install extends WInstall {






	public function install(&$object) {


		if ( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall) ) {


			WText::load( 'address.node' );
			$installWidgetsC = WClass::get( 'install.widgets' );
			$installWidgetsC->installWidgetType(
			  'address.map'
			  , 'Map widget'
			  , WText::t('1206732424BJFR')
			, WText::t('1379006374DSBD')
			, 7				);

		}

		return true;


	}



}