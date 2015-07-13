<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_search_listing_view extends Output_Listings_class {

function prepareQuery() {


		if ( !defined('PCATALOG_NODE_SEARCHVENDOR') ) WPref::get( 'catalog.node');

		$searchVendor = PCATALOG_NODE_SEARCHVENDOR;
		if ( !$searchVendor ) $this->removePicklists( array('vendors_list_publish_catalog_home_search') );

		$searchCategory = PCATALOG_NODE_SEARCHCATEGORY;
		if ( !$searchCategory ) $this->removePicklists( array('catalog_item_category_search') );

		$searchType = PCATALOG_NODE_SEARCHTYPE;
		if ( !$searchType ) $this->removePicklists( array('catalog_item_type_search') );

								$searchCountry = PCATALOG_NODE_SEARCHCOUNTRY;
		if ( !$searchCountry ) $this->removePicklists( array('countries_published_list_wdefault') );
		
		return true;


	}
}