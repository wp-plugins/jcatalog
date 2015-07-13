<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Node_install extends WInstall {






	public function addExtensions() {


				$extension = new stdClass;
		$extension->namekey = 'catalog.search.module';
		$extension->name = "Joobi - Catalog Search module";
		$extension->folder = 'catalog';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|catalog|module';
		$extension->core = 1;
		$extension->params = "publish=0\nwidgetView=catalog_search_module";
		$extension->description = '';
		$libraryCMSMenuC = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
		$extension->install = $libraryCMSMenuC->modulePreferences();

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );



				$extension = new stdClass;
		$extension->namekey = 'catalog.advancesearch.module';
		$extension->name = "Joobi - Catalog Advance Search module";
		$extension->folder = 'catalog';
		$extension->type = 25;
		$extension->publish = 1;
		$extension->certify = 1;
		$extension->destination = 'node|catalog|module';
		$extension->core = 1;
		$extension->params = "publish=0";			$extension->description = '';
		$libraryCMSMenuC = WAddon::get( 'api.' . JOOBI_FRAMEWORK . '.cmsmenu' );
		$extension->install = $libraryCMSMenuC->modulePreferences();

		if ( $this->insertNewExtension( $extension ) ) $this->installExtension( $extension->namekey );

	}

}