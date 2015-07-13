<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_home_search_view extends Output_Forms_class {

	private $_itemsPagination = null;



	protected function prepareView() {


		
		$searchbox = WPref::load( 'PCATALOG_NODE_SEARCHBOX' );
					WGlobals::set( 'showSearchFilterVendor', PCATALOG_NODE_SEARCHVENDOR, 'global' );
			WGlobals::set( 'showSearchFilterCategory', PCATALOG_NODE_SEARCHCATEGORY, 'global' );
			WGlobals::set( 'showSearchFilterType', PCATALOG_NODE_SEARCHTYPE, 'global' );
			WGlobals::set( 'showSearchFilterLocation', PCATALOG_NODE_SEARCHLOCATION, 'global' );
			WGlobals::set( 'showSearchFilterZipCode', PCATALOG_NODE_SEARCHZIPCODE, 'global' );
			WGlobals::set( 'showSearchFilterCountry', PCATALOG_NODE_SEARCHCOUNTRY, 'global' );


		
		$this->_showItems();



		if ( PCATALOG_NODE_ADVSEARCHDELETE ) $this->_showAdvanceSearchFitlers();


		return true;



	}







	private function _showAdvanceSearchFitlers() {

		
		$catalogAdvFilterC = WClass::get( 'catalog.advfilter' );
		$this->_advSeachableA = $catalogAdvFilterC->getItemFitlers();

		if ( empty( $this->_advSeachableA ) ) return true;

		$html = '';
		foreach( $this->_advSeachableA as $oneSearch ) {
			$lidToUse = $oneSearch->lid;
			$value = WGlobals::getUserState( 'advCtlg_val_' . $lidToUse, $lidToUse, null, '', 'advCatalog' );
			if ( !empty($value) ) {
				$link = WPages::link( 'controller=catalog&advCatalogReset[' . $oneSearch->lid . ']=1&advCatalog[' . $oneSearch->lid . ']=' );
				$linkText = $oneSearch->name . '<i class="fa fa-times-circle"></i>';
				$linkHTML = '<a href="' . $link . '">' . $linkText . '</a>';
				$html .= '<span class="badge resetFilter">' . $linkHTML . '</span>';

				$value = null;
			}		}
		$this->setValue( 'searchFilter', $html );


	}











	private function _showItems() {



		
		$this->setValue( 'itemTitle', WText::t('1373216613LQOL') );



		
		$sortingPresentation = WPref::load( 'PCATALOG_NODE_SORTINGPRESENTATION' );



		WGlobals::set( 'itemsSortingPicklist', WPref::load( 'PCATALOG_NODE_SEARCHITMAVAILSORT' ), 'global' );

		WGlobals::set( 'homeItemsSorting', WPref::load( 'PCATALOG_NODE_SEARCHITMSORTING' ), 'global' );



		
		$joobiRun = 'return '. WPage::actionJavaScript( 'home', $this->firstFormName );

		$params = new stdClass;

		$params->map = 'choicesorting';	
		$dropdownPL = WView::picklist( 'catalog_home_items_sorting', $joobiRun, $params );

		$this->setValue( 'itemsPicklist', $dropdownPL->display() );



		
		$displayedItems = $this->_loadItems();

		$this->setValue( 'itemsPagination', $this->_itemsPagination );





		$this->setValue( 'items', $displayedItems );



		return true;



	}








	private function _getFieldFromRequest($name) {

		$searchItem = WGlobals::get( $name, '' );
		if ( !empty($searchItem) ) return $searchItem;

		$searchItem = WForm::getPrev( 'x[' . $name . ']' );
		if ( empty($searchItem) ) {
			$trucs = WGlobals::get( 'trucs' );
			if (!empty($trucs['x'][$name]) ) $searchItem = $trucs['x'][$name];
		}
		return $searchItem;
	}







private function _loadItems() {

	static $i = 0;

	$i++;

	
	$allParamsO = new stdClass;

	$allParamsO->themeType = 'node';	
	$allParamsO->nodeName = 'catalog';



	
	$choicesortingTabUsed = WGlobals::get( 'homeItemsSortingTabUsed', false, 'global' );

	$choicesorting = WGlobals::get( 'choicesorting' );


	
	$search = $this->_getFieldFromRequest( 'search' );		if ( !empty( $search ) ) $allParamsO->search = $search;
	$prodtypid = $this->_getFieldFromRequest( 'prodtypid' );	
	if ( !empty( $prodtypid ) ) $allParamsO->prodtypid = $prodtypid;
	else $allParamsO->prodtypid = 0;
	$catid = $this->_getFieldFromRequest( 'catid' );		if ( !empty( $catid ) ) $allParamsO->category = $catid;
	$vendid = $this->_getFieldFromRequest( 'vendid' );		if ( !empty( $vendid ) ) $allParamsO->vendor = $vendid;
	$location = $this->_getFieldFromRequest( 'location' );		$locationDefaultText = WText::t('1375896154QSFL');
	if ( $location == $locationDefaultText ) $location = '';

			$country = WPref::load( 'PCATALOG_NODE_SEARCHCOUNTRYZIPCODE' );

		$zipcode = $this->_getFieldFromRequest( 'zipcode' );
	if ( WPref::load( 'PCATALOG_NODE_SEARCHCOUNTRY' ) ) $country = $this->_getFieldFromRequest( 'country' );

	$countryName = '';
	$zipcodeDefaultText = WText::t('1398702488PGTJ');
	if( !empty($zipcode) && $zipcode != $zipcodeDefaultText ) {
		if ( !empty($location) ) $location .= ', ' . $zipcode;
	}
	if ( !empty($country) ) {

		$location .= ', ';
		if ( is_numeric($country) ) {
			$countriesHelper = WClass::get( 'countries.helper' );
			$countryO = $countriesHelper->getData($country);
			$countryName = $countryO->name;
			$location .= $countryName;
		} else {
			$countryName = $country;
			$location .= $countryName;
		}
	}
	

	if ( !empty( $location ) ) {


		$radius = $this->_getFieldFromRequest( 'radius' );

		if ( !empty($radius) ) {
			$allParamsO->location = $location;
			$allParamsO->radius = $radius;
		} else {
			$allParamsO->location = $location;
			$allParamsO->radius = 25;			}	}

	$allParamsO->sorting = ( !empty($choicesorting) ) ? $choicesorting : PCATALOG_NODE_SEARCHITMSORTING;

	
	if ( $choicesortingTabUsed ) WGlobals::set( 'homeItemsSorting', 'none', 'global' );

	else WGlobals::set( 'homeItemsSorting', $allParamsO->sorting, 'global' );



	$uniqueNameState = 'catalogSearchItems' . $i . 'type' . $allParamsO->prodtypid;

		$allParamsO->getadvsearch = true;


	
	if ( PCATALOG_NODE_SEARCHITMPAGI ) {


				$catalogAdvFilterC = WClass::get( 'catalog.advfilter' );
		$uniqueNameState .= $catalogAdvFilterC->getUniqueString();


		
		
				if ( !empty($catid) ) $uniqueNameState .= '_ct_' . $catid;
		if ( !empty($vendid) ) $uniqueNameState .= '_vd_' . $vendid;
		if ( !empty($search) ) $uniqueNameState .= '_s_' . md5( $search );
		if ( !empty($location) ) $uniqueNameState .= '_xy_' . md5( $location . $radius );



		$allParamsO->nb = PCATALOG_NODE_SEARCHITMNBDISPLAY;

		
		if ( empty($allParamsO->nb) ) $allParamsO->nb = 10;	
		elseif ( $allParamsO->nb > 500 ) $allParamsO->nb = 500;



		
		$allParamsO->pagination = true;	
		$allParamsO->yid = $uniqueNameState;	


	}

		$allParamsO->borderShow = PCATALOG_NODE_ITMBORDERSHOW;
	$allParamsO->borderColor = PCATALOG_NODE_ITMBORDERCOLOR;	

	$allParamsO->layout = PCATALOG_NODE_SEARCHITMLAYOUT;

	$allParamsO->layoutname = PCATALOG_NODE_SEARCHITMLAYOUTNAME;

	$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

	$allParamsO->layoutNbColumn = PCATALOG_NODE_SEARCHITMLAYOUTCOL;


	$allParamsO->nb = PCATALOG_NODE_SEARCHITMNBDISPLAY;

	if ( empty($allParamsO->nb) || $allParamsO->nb > 200 ) $allParamsO->nb = 10;

	$allParamsO->display = PCATALOG_NODE_SEARCHITMDISPLAY;

	$allParamsO->showNoName = ! PCATALOG_NODE_SEARCHITMSHOWNAME;

	$allParamsO->dontShowFree = ! PCATALOG_NODE_SEARCHITMSHOWFREE;

	$allParamsO->showPreview = PCATALOG_NODE_SEARCHITMSHOWPREVIEW;

	$allParamsO->showPrice = PCATALOG_NODE_SEARCHITMSHOWPRICE;

	$allParamsO->showBid = PCATALOG_NODE_SEARCHITMSHOWBID;
	$allParamsO->showcountdown = PCATALOG_NODE_SEARCHITMSHOWCOUNTDOWN;

	$allParamsO->showIntro = PCATALOG_NODE_SEARCHITMSHOWINTRO;

	$allParamsO->showDesc = PCATALOG_NODE_SEARCHITMSHOWDESC;

	$allParamsO->showVendor = PCATALOG_NODE_SEARCHITMSHOWVENDOR;

	$allParamsO->showQuestion = PCATALOG_NODE_SEARCHITMSHOWQUESTION;

	$allParamsO->climit = PCATALOG_NODE_SEARCHITMCLIMIT;

	$allParamsO->nlimit = PCATALOG_NODE_SEARCHITMNLIMIT;
	$allParamsO->addCart = PCATALOG_NODE_SEARCHITMADDCART;

	$allParamsO->showNoRating = ! PCATALOG_NODE_SEARCHITMSHOWRATING;

	$allParamsO->showReview = PCATALOG_NODE_SEARCHITMFEEDBACK;

	$allParamsO->share = PCATALOG_NODE_SEARCHITMSHARE;

	$allParamsO->showReadMore = PCATALOG_NODE_SEARCHITMREADMORE;

	$allParamsO->mouseOver = PCATALOG_NODE_SEARCHITMMOUSEOVER;

	$allParamsO->showNoImage = ! PCATALOG_NODE_SEARCHITMSHOWIMAGE;

	$allParamsO->imageWidth = PCATALOG_NODE_SEARCHITMIMAGEWIDTH;

	$allParamsO->imageHeight = PCATALOG_NODE_SEARCHITMIMAGEHEIGHT;

	$allParamsO->showHeader = PCATALOG_NODE_SEARCHITMSHOWCOLUMN;

		$allParamsO->showMainCategory = false;


	$allParamsO->showAll = 0;

	$allParamsO->uniqueSection = $uniqueNameState;

	$generalPageID = PCATALOG_NODE_CATALOGPGIDGENERAL;

	$itemPageID = PCATALOG_NODE_CATALOGPGIDITEMS;

	$allParamsO->pageID =  (!empty( $itemPageID ) ) ? $itemPageID : ( (!empty( $generalPageID ) ) ? $generalPageID : '');



	$allParamsO->widgetSlug = 'search_item';


	
	$productLoadC = WClass::get( 'item.load' );

	$productA = $productLoadC->get( $allParamsO );



	if ( empty($productA) ) {
		$productA = array( true );

		return '<span class="catalogItemEmpty">' . WText::t('1373216613LQOM') . '</span>';

	}


	
	if ( PCATALOG_NODE_SEARCHITMPAGI ) {

		$startLimit = WGlobals::getUserState("wiev-$uniqueNameState-limitstart", 'limitstart'.$uniqueNameState, 0, 'int' );

		$pagiI = WView::pagination( $uniqueNameState, $allParamsO->totalCount, $startLimit, $allParamsO->nb, 0, 'Items', 'home' );

		$pagiI->setFormName( $this->firstFormName );

		if ( !empty($this->_itemType) ) $pagiI->addHidden( 'type', $this->_itemType );

		$this->_itemsPagination = $pagiI->getListFooter();

	}


	
	$productLoadC->extraProcess( $productA, $allParamsO );



	
	$outputThemeC = WClass::get( 'output.theme' );

	$outputThemeC->nodeName = 'catalog';

	$allParamsO->header = $productLoadC->setHeader();



	return $outputThemeC->createLayout( $productA, $allParamsO );



}
}