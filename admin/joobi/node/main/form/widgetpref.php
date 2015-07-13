<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.layout' );
class Main_CoreWidgetpref_form extends WForm_layout {


	function create() {


		
		$id = WGlobals::get( 'id' );

		$frameworkType = 0;

		$option = '';

		if ( empty($id) ) {

			$id = $this->getValue( 'framework_id', 'main.widget' );

			$frameworkType = $this->getValue( 'framework_type', 'main.widget' );

		}
		if ( 'wordpress' == JOOBI_FRAMEWORK_TYPE ) {
			if ( !is_numeric($id) ) {
				WGlobals::setSession( 'editWidgetsPref', 'id', $id );
												WGlobals::getSession( 'editWidgetsPref', 'id', '' );
			} else {
				$idSess = WGlobals::getSession( 'editWidgetsPref', 'id', '' );
				if ( !empty($idSess) ) $id = $idSess;
			}		}


		if ( $frameworkType == 92 ) {

			$option = 'com_modules';

		} elseif ( $frameworkType == 91 ) {

			$framework_type = 91;

			$option = 'com_plugins';

		}


		$libraryCMSMenuC = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );

		$extensionO = $libraryCMSMenuC->loadExtension( $id, $option );

		if ( empty($extensionO) ) return false;


		$ExtensionDataO = WExtension::get( $extensionO->namekey, 'data' );

		if ( !empty($ExtensionDataO->widgetView) ) {

			$yid = WView::get( $ExtensionDataO->widgetView, 'yid', null, false );

		} else {



			$viewNamekey = str_replace( '.', '_', substr( $extensionO->namekey, 0, -7 ) );

			$viewNamekeyModule = $viewNamekey . '_module';

			$yid = WView::get( $viewNamekeyModule, 'yid', null, null, false );

			if ( empty($yid) ) {

				$viewNamekeyWidget = $viewNamekey . '_widget';

				$yid = WView::get( $viewNamekeyWidget, 'yid', null, null, false );

			}


		}

		if ( empty($yid) ) {






			return false;

		}


		$this->viewID = $yid;



		return parent::create();



	}
}