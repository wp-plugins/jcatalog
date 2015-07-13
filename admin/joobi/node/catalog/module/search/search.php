<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_CoreSearch_module extends WModule {

	function create() {


		$controler = WGlobals::get( 'controller' );
		$task = WGlobals::get( 'task' );
		if ( 'catalog' == $controler && ( 'home' == $task || empty($task) ) ) {
			$searchbox = WPref::load( 'PCATALOG_NODE_SEARCHBOX' );
			if ( $searchbox ) return false;
		}
				$controller = new stdClass;

		$controller->controller = 'catalog';

		$controller->wid = $this->wid;

		$controller->sid = WModel::get( 'item', 'sid' );

		$controller->firstForm = true;

		$this->layout = WView::getHTML( 'catalog_item_search', $controller );			if ( !empty($this->layout) ) {
			if ( isset($this->picklistvendor) ) WGlobals::set( 'showSearchFilterVendor', $this->picklistvendor, 'global' );
			if ( isset($this->picklistcategory) ) WGlobals::set( 'showSearchFilterCategory', $this->picklistcategory, 'global' );
			if ( isset($this->picklisttype) ) WGlobals::set( 'showSearchFilterType', $this->picklisttype, 'global' );
			if ( isset($this->picklistlocation) ) WGlobals::set( 'showSearchFilterLocation', $this->picklistlocation, 'global' );
						if ( isset($this->picklistzipcode) ) WGlobals::set( 'showSearchFilterZipCode', $this->picklistzipcode, 'global' );
			if ( isset($this->picklistcountry) ) WGlobals::set( 'showSearchFilterCountry', $this->picklistcountry, 'global' );

			$formObj = WView::form( $this->layout->firstFormName );
			$formObj->hiddenRemove( 'task' );

			$size = ( !empty($this->size) ? $this->size : '100%' );
			WGlobals::set( 'catalogSearchInputSize', $size );

			$css = '';
			$css .= ' .sdmodule{float:none;}';

			if ( !empty($this->resultitemid) ) {
				$formObj = WView::form( $this->layout->firstFormName );
				$formObj->hidden( JOOBI_PAGEID_NAME, $this->resultitemid );
			}

			WText::load( 'catalog.node' );
			$textSearch = WText::t('1206732365OQJI');
			$html = '<div class="search-div sdmodule">';				$html .= $this->layout->make();
			$html .= '</div>';

			WPage::addCSSScript($css);

			$this->content = $html;

		}


	}
}