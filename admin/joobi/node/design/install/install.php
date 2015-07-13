<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Node_install extends WInstall {






	public function install(&$object) {


		if ( !empty( $this->newInstall ) || (property_exists($object, 'newInstall') && $object->newInstall) ) {


			WText::load( 'design.node' );

			$installWidgetsC = WClass::get( 'install.widgets' );
			$installWidgetsC->installWidgetType(
			  'design.button'
			  , 'Button'
			  , WText::t('1219769905FKPU')
			, WText::t('1400708734QLWH')
			, 19				);

			$installWidgetsC->installWidgetType(
			  'design.icon'
			  , 'Bootstrap Font Awesome Icon'
			  , 'Font Awesome Icon'
			, 'Create a font awesome icon'
			, 19				);


		}

		return true;


	}



}