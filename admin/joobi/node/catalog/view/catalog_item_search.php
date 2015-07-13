<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_item_search_view extends Output_Forms_class {

function prepareView() {



		$searchVendor = WGlobals::get( 'showSearchFilterVendor', false, 'global' );

		if ( !$searchVendor ) $this->removeElements( array('catalog_item_search_x_searchvendid') );



		$searchCategory = WGlobals::get( 'showSearchFilterCategory', false, 'global' );

		if ( !$searchCategory ) $this->removeElements( array('catalog_item_search_x_searchcatid') );



		$searchType = WGlobals::get( 'showSearchFilterType', false, 'global' );



		if ( !$searchType ) $this->removeElements( array('catalog_item_search_x_searchtype') );



		$searchLocation = WGlobals::get( 'showSearchFilterLocation', false, 'global' );

		$mapServices = WPref::load( 'PITEM_NODE_MAPSERVICES' );

		if ( !$searchLocation || !$mapServices ) $this->removeElements( array('catalog_item_search_x_searchlocation') );



		
		$searchZipCode = WGlobals::get( 'showSearchFilterZipCode', false, 'global' );

		if ( !$searchZipCode ) {

			$this->removeElements( array('catalog_item_search_x_searchzipcode') );

		}
		
		$searchCountry = WGlobals::get( 'showSearchFilterCountry', false, 'global' );

		if ( !$searchCountry ) {

			$this->removeElements( array('catalog_item_search_x_searchzipcodecountry') );

		}


		return true;



	}
}