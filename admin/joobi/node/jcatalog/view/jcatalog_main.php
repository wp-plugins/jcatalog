<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Jcatalog_Jcatalog_main_view extends Output_Mlinks_class {

	function prepareView() {



		$extensionExist = WExtension::exist( 'vendors.node' );

		if ( !$extensionExist ) $this->removeMenus( array( 'jcatalog_main_vendors', 'jcatalog_main_vendors_preferences' ) );



		$promotion = WPref::load( 'PITEM_NODE_PROMOTIONUSE' );

		if ( ! $promotion ) {

			 $this->removeElements( 'jcatalog_main_promotion' );

		}


		if ( ! WApplication::isEnabled( JOOBI_MAIN_APP ) ) {

			$this->removeElements( array( 'jcatalog_main_apps-widgets' ) );

		} else {

			$this->removeElements( array( 'jcatalog_main_tools_japps', 'jcatalog_main_design_japps' ) );

		}

		return true;



	}
}