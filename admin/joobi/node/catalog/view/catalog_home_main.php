<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_home_main_view extends Output_Forms_class {
private $_itemsPagination = '';	


	private $_paneTab = null;	


	
	private $_itemType = '';

	private $_itemTypeID = '';



	protected function prepareView() {



	
	$this->_itemType = WGlobals::get( 'type' );





	
	
	
	WGlobals::set( 'homecatid', 1, 'global' );



	$generalPageID = WPref::load( 'PCATALOG_NODE_CATALOGPGIDGENERAL' );

	if ( !empty($generalPageID) ) {

		$cmsPage = WPage::cmsGetItemId();

		if ( $generalPageID != $cmsPage ) {

			

		}
	}


	if ( PCATALOG_NODE_HOMESHOWRSS ) {

		



		$display = '<div id="rssFeed">';
		$data = new stdClass;
		$data->type = 'rss';
		$data->link = WPage::routeURL('controller=item&task=rss&jdoctype=230');
		$display .= WPage::renderBluePrint( 'others', $data );
		$display .= '</div>';



		$this->setValue( 'rss', $display );



	}

	$searchbox = WPref::load( 'PCATALOG_NODE_SEARCHBOX' );
		if ( $searchbox ) {
		WGlobals::set( 'showSearchFilterVendor', PCATALOG_NODE_SEARCHVENDOR, 'global' );
		WGlobals::set( 'showSearchFilterCategory', PCATALOG_NODE_SEARCHCATEGORY, 'global' );
		WGlobals::set( 'showSearchFilterType', PCATALOG_NODE_SEARCHTYPE, 'global' );
		WGlobals::set( 'showSearchFilterLocation', PCATALOG_NODE_SEARCHLOCATION, 'global' );
		WGlobals::set( 'showSearchFilterZipCode', PCATALOG_NODE_SEARCHZIPCODE, 'global' ); 		WGlobals::set( 'showSearchFilterCountry', PCATALOG_NODE_SEARCHCOUNTRY, 'global' ); 	}

	$carrousel = PCATALOG_NODE_CARROUSEL;

	
	if ( $carrousel ) {



		
		$allParamsO = new stdClass;
		$allParamsO->idLabel = 'catalogHomePage';

		$allParamsO->themeType = 'node';	
		$allParamsO->nodeName = 'catalog';

		$allParamsO->prodtypid = ( !empty($this->_itemType) ? $this->_itemType : PCATALOG_NODE_CRSLTYPE );

		$allParamsO->showTitle = PCATALOG_NODE_CRSLTITLE;
		$allParamsO->title = WText::t('1304526971HCDU');	

	














				$allParamsO->borderShow = PCATALOG_NODE_CRSLBORDERSHOW;
		$allParamsO->borderColor = PCATALOG_NODE_CRSLBORDERCOLOR;
		$allParamsO->layoutNbColumn = PCATALOG_NODE_CRSLLAYOUTCOL;
		$allParamsO->layoutNbRow = PCATALOG_NODE_CRSLLAYOUTROW;

		$allParamsO->getadvsearch = true;

		$allParamsO->sorting = PCATALOG_NODE_CRSLSORTING;

		$allParamsO->id = PCATALOG_NODE_CRSLPIDS;

		$allParamsO->search = PCATALOG_NODE_CRSLSEARCH;

		$allParamsO->layout = PCATALOG_NODE_CRSLLAYOUT;

		$allParamsO->layoutname = PCATALOG_NODE_CRSLLAYOUTNAME;
		$allParamsO->carrouselArrow = 1;


		$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

		$allParamsO->nb = PCATALOG_NODE_CRSLNBDISPLAY;

		if ( empty($allParamsO->nb) || $allParamsO->nb > 100 ) $allParamsO->nb = 10;

		$allParamsO->display = PCATALOG_NODE_CRSLDISPLAY;

		$allParamsO->showNoName = ! PCATALOG_NODE_CRSLSHOWNAME;

		$allParamsO->dontShowFree = ! PCATALOG_NODE_CRSLSHOWFREE;

		$allParamsO->showPrice = PCATALOG_NODE_CRSLSHOWPRICE;

		$allParamsO->showBid = PCATALOG_NODE_CRSLSHOWBID;
		$allParamsO->showcountdown = PCATALOG_NODE_CRSLSHOWCOUNTDOWN;

		$allParamsO->showPreview = PCATALOG_NODE_CRSLSHOWPREVIEW;

		$allParamsO->showIntro = PCATALOG_NODE_CRSLSHOWINTRO;

		$allParamsO->showDesc = PCATALOG_NODE_CRSLSHOWDESC;

		$allParamsO->showVendor = PCATALOG_NODE_CRSLSHOWVENDOR;

		$allParamsO->showQuestion = PCATALOG_NODE_CRSLSHOWQUESTION;

		$allParamsO->climit = PCATALOG_NODE_CRSLCLIMIT;

		$allParamsO->nlimit = PCATALOG_NODE_CRSLNLIMIT;
		$allParamsO->addCart = PCATALOG_NODE_CRSLADDCART;

		$allParamsO->showNoRating = ! PCATALOG_NODE_CRSLSHOWRATING;

		$allParamsO->showReview = PCATALOG_NODE_CRSLFEEDBACK;

		$allParamsO->share = PCATALOG_NODE_CRSLSHARE;

		$allParamsO->showReadMore = PCATALOG_NODE_CRSLREADMORE;

		$allParamsO->showNoImage = ! PCATALOG_NODE_CRSLSHOWIMAGE;

		$allParamsO->imageWidth = PCATALOG_NODE_CRSLIMAGEWIDTH;

		$allParamsO->imageHeight = PCATALOG_NODE_CRSLIMAGEHEIGHT;
		$allParamsO->showMainCategory = PCATALOG_NODE_CRSLSHOWCATEGORY;

		$generalPageID = PCATALOG_NODE_CATALOGPGIDGENERAL;

		$itemPageID = PCATALOG_NODE_CATALOGPGIDCAROUSEL;

		$allParamsO->pageID = ( !empty( $itemPageID ) ) ? $itemPageID : ((!empty( $generalPageID )) ? $generalPageID : '');


		$allParamsO->widgetSlug = 'catalog_carrousel';


		if ( $allParamsO->display == 'standard' ) $allParamsO->display = 'carrousel';



		
		$productLoadC = WClass::get( 'item.load' );

		$productA = $productLoadC->get( $allParamsO );



		
		if ( !empty($productA) ) {



	


			
			$productLoadC->extraProcess( $productA, $allParamsO );

			
			$outputThemeC = WClass::get( 'output.theme' );

			$outputThemeC->nodeName = 'catalog';

			$outputThemeC->header = $productLoadC->setHeader();

			$displayCarrousel = $outputThemeC->createLayout( $productA, $allParamsO );

			$this->setValue( 'carrousel', $displayCarrousel );



		}


	}


	
	$this->_showItems();

	$mapServices = WPref::load( 'PITEM_NODE_MAPSERVICES' );
	if ($mapServices) $this->_showItemsMap();



	
	$this->_loadCategories();





	
	$extensionExist = WExtension::exist( 'vendors.node' );

	if ( PCATALOG_NODE_VDRITEMS && $extensionExist ) $this->_loadVendors();


	if ($mapServices) $this->_showVendorsMap();

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







	private function _showItemsMap() {

				if ( 'mobile' == JOOBI_FRAMEWORK_TYPE ) return false;

		$showMap = PCATALOG_NODE_ITMAPITEMS;
		if ( empty($showMap) ) return false;

		$showAllMap = PCATALOG_NODE_ITMAPALLITEMS;

		$this->setValue( 'itemsMapTitle', WText::t('1373904180MYWC') );

				if ( empty($showAllMap) ) {
			$coordinatesA =	WGlobals::get( 'itemsCoordinatesA', array(), 'global' );
		} else {
			$showMapMax = PCATALOG_NODE_ITMAPMAXNB;
			if ( empty($showMapMax) ) $showMapMax = 1000;

			
			$itemM = WModel::get( 'item' );
			$itemM->makeLJ( 'itemtrans', 'pid' );
			$itemM->makeLJ( 'item.type', 'prodtypid', 'prodtypid', 0, 2 );
			$itemM->select( 'type', 2 );
			$itemM->whereLanguage();
			$itemM->setLimit( $showMapMax );
			$itemM->select( 'name', 1 );

			$itemM->checkAccess();
			$itemM->whereE( 'publish', 1 );

			$itemM->where( 'longitude', '<', '180' );
			$itemM->where( 'longitude', '>', '-180' );
			$itemM->where( 'latitude', '<', '180' );
			$itemM->where( 'latitude', '>', '-180' );
			$coordinatesA = $itemM->load( 'ol', array( 'location', 'longitude', 'latitude', 'pid' ) );

			if ( !empty( $coordinatesA ) ) {
				$productDesignationT = WType::get( 'item.designation' );
				foreach( $coordinatesA as $one ) {
										$itemTypeName = $productDesignationT->getName( $one->type );
					$one->icon = JOOBI_URL_MEDIA . 'itemtype/thumbnails/' . $itemTypeName . 'typex.png';
										$one->link = WPage::linkHome( 'controller=catalog&task=show&eid=' . $one->pid );
				}			}

		}
				$showMapWidth = PCATALOG_NODE_ITMAPWIDTH;
		if ( empty( $showMapWidth ) ) $showMapWidth = 600;

		$showMapHeight = PCATALOG_NODE_ITMAPHEIGHT;
		if ( empty( $showMapHeight ) ) $showMapHeight = 350;

		$addressMapC = WClass::get( 'address.map', null, 'class', false );
		if ( empty($addressMapC) ) return false;

		$addressMapC->setClustering( $coordinatesA );

		$addressMapC->setWidth( $showMapWidth );
		$addressMapC->setHeight( $showMapHeight );

		$this->setValue( 'itemsmap', $addressMapC->renderMapOnly() );

	}







	private function _showVendorsMap() {

				if ( 'mobile' == JOOBI_FRAMEWORK_TYPE ) return false;

		$showMap = PCATALOG_NODE_VDRMAPITEMS;
		if ( empty($showMap) ) return false;
		$showMap = WExtension::exist( 'vendors.node' );
		if ( empty($showMap) ) return false;


		$showAllMap = PCATALOG_NODE_VDRMAPALLITEMS;

		$this->setValue( 'vendorsMapTitle', WText::t('1373904181EMBL') );

				if ( empty($showAllMap) ) {
			$coordinatesA =	WGlobals::get( 'vendorsCoordinatesA', array(), 'global' );
		} else {

			$showMapMax = PCATALOG_NODE_VDRMAPMAXNB;
			if ( empty($showMapMax) ) $showMapMax = 1000;
			
			$itemM = WModel::get( 'vendor' );
			$itemM->makeLJ( 'vendortrans', 'vendid' );
			$itemM->makeLJ( 'countries', 'originctyid', 'ctyid', 0, 2 );
			$itemM->whereLanguage();
			$itemM->setLimit( $showMapMax );
			$itemM->select( 'name', 1 );
			$itemM->select( 'originaddress', 0, 'address' );
			$itemM->select( 'origincity', 0, 'city' );
			$itemM->select( 'originstate', 0, 'state' );
			$itemM->select( 'originzipcode', 0, 'zipcode' );
			$itemM->select( 'name', 2, 'country' );

			$itemM->where( 'longitude', '<', '180' );
			$itemM->where( 'longitude', '>', '-180' );
			$itemM->where( 'latitude', '<', '180' );

			$itemM->setLimit( 10000 );
			$coordinatesA = $itemM->load( 'ol', array( 'longitude', 'latitude', 'vendid' ) );

		}
		if ( empty($coordinatesA) ) return true;

		foreach( $coordinatesA as $oneVend ) {
			if ( !empty($oneVend->vendid) ) $oneVend->link = WPage::linkHome( 'controller=vendors&task=show&eid=' . $oneVend->vendid );
		}
				$showMapWidth = PCATALOG_NODE_VDRMAPWIDTH;
		if ( empty( $showMapWidth ) ) $showMapWidth = 600;

		$showMapHeight = PCATALOG_NODE_VDRMAPHEIGHT;
		if ( empty( $showMapHeight ) ) $showMapHeight = 350;

		$addressMapC = WClass::get( 'address.map' );
		$addressMapC->setClustering( $coordinatesA );

		$addressMapC->setWidth( $showMapWidth );
		$addressMapC->setHeight( $showMapHeight );

		$this->setValue( 'vendorsmap', $addressMapC->renderMapOnly() );

	}












	private function _showItems() {



		$showItems = PCATALOG_NODE_ITMITEMS;

		if ( !$showItems ) return true;



		
		$this->setValue( 'itemTitle', WText::t('1233642085PNTA') );



		
		$sortingPresentation = PCATALOG_NODE_SORTINGPRESENTATION;



		if ( $sortingPresentation != 'tab' ) {	


			WGlobals::set( 'itemsSortingPicklist', PCATALOG_NODE_ITMAVAILSORT, 'global' );

			WGlobals::set( 'homeItemsSorting', PCATALOG_NODE_ITMSORTING, 'global' );



			
			$joobiRun = 'return '.WPage::actionJavaScript( 'home', $this->firstFormName );

			$params = new stdClass;

			$params->map = 'choicesorting';	
			$dropdownPL = WView::picklist( 'catalog_home_items_sorting', $joobiRun, $params );

			$this->setValue( 'itemsPicklist', $dropdownPL->display() );



			
			$displayedItems = $this->_loadItems();

			$this->setValue( 'itemsPagination', $this->_itemsPagination );



		} else {

			


			
			$ITMAVAILSORT = trim( PCATALOG_NODE_ITMAVAILSORT );

			if ( empty($ITMAVAILSORT) ) return true;

			$availableItemsA = WTools::pref2String( $ITMAVAILSORT );



			WGlobals::set( 'homeItemsSortingTabUsed', true, 'global' );

			WGlobals::set( 'homeItemsSorting', 'none', 'global' );

			$this->setValue( 'itemsClassExtra', ' tabs' );



			$html = '';




			if ( !empty($availableItemsA) ) {

								$data = new stdClass;
				$data->frame = 'tab';
				$params = new stdClass;
				$params->id = 'catalogHomeItemTabs';
				$params->idText = $params->id;
				$data->params = $params;
				$this->_paneTab = WPage::renderBluePrint( 'frame', $data );

				$this->_paneTab->startPane( $params );


				foreach( $availableItemsA as $oneTabSorting ) {

					$sorting = trim($oneTabSorting);

					WGlobals::set( 'choicesorting', $sorting );

					$displayedItems = $this->_loadItems();

					$html .= $this->_addTab( $sorting, $displayedItems, $this->_itemsPagination, $params->id );

				}


				$displayedItems = $this->_paneTab->endPane( $params );



				WGlobals::set( 'homeItemsSorting', 'none', 'global' );



			} else {

				$displayedItems = '';

			}




		}


		$this->setValue( 'items', $displayedItems );



		return true;



	}








private function _loadItems() {

	static $i = 0;

	$i++;

	
	$allParamsO = new stdClass;

	$allParamsO->themeType = 'node';	
	$allParamsO->nodeName = 'catalog';



	
	$choicesortingTabUsed = WGlobals::get( 'homeItemsSortingTabUsed', false, 'global' );

	$choicesorting = WGlobals::get( 'choicesorting' );



	$allParamsO->prodtypid = ( !empty($this->_itemType) ? $this->_itemType : PCATALOG_NODE_ITMTYPE );



	$allParamsO->sorting = ( !empty($choicesorting) ) ? $choicesorting : PCATALOG_NODE_ITMSORTING;

	
	if ( $choicesortingTabUsed ) WGlobals::set( 'homeItemsSorting', 'none', 'global' );

	else WGlobals::set( 'homeItemsSorting', $allParamsO->sorting, 'global' );



		$allParamsO->borderShow = PCATALOG_NODE_ITMBORDERSHOW;
	$allParamsO->borderColor = PCATALOG_NODE_ITMBORDERCOLOR;	

	$allParamsO->id = PCATALOG_NODE_ITMPIDS;

	$allParamsO->search = PCATALOG_NODE_ITMSEARCH;

	$allParamsO->layout = PCATALOG_NODE_ITMLAYOUT;

	$allParamsO->layoutname = PCATALOG_NODE_ITMLAYOUTNAME;

	$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

	$allParamsO->carrouselArrow = 1;


	$allParamsO->layoutNbColumn = PCATALOG_NODE_ITMLAYOUTCOL;

	$allParamsO->nb = PCATALOG_NODE_ITMNBDISPLAY;

	if ( empty($allParamsO->nb) || $allParamsO->nb > 200 ) $allParamsO->nb = 10;

	$allParamsO->display = PCATALOG_NODE_ITMDISPLAY;

	$allParamsO->showNoName = ! PCATALOG_NODE_ITMSHOWNAME;

	$allParamsO->dontShowFree = ! PCATALOG_NODE_ITMSHOWFREE;

	$allParamsO->showPreview = PCATALOG_NODE_ITMSHOWPREVIEW;

	$allParamsO->showPrice = PCATALOG_NODE_ITMSHOWPRICE;

	$allParamsO->showBid = PCATALOG_NODE_ITMSHOWBID;
	$allParamsO->showcountdown = PCATALOG_NODE_ITMSHOWCOUNTDOWN;

	$allParamsO->showIntro = PCATALOG_NODE_ITMSHOWINTRO;

	$allParamsO->showDesc = PCATALOG_NODE_ITMSHOWDESC;

	$allParamsO->showVendor = PCATALOG_NODE_ITMSHOWVENDOR;

	$allParamsO->showQuestion = PCATALOG_NODE_ITMSHOWQUESTION;

	$allParamsO->climit = PCATALOG_NODE_ITMCLIMIT;

	$allParamsO->nlimit = PCATALOG_NODE_ITMNLIMIT;
	$allParamsO->addCart = PCATALOG_NODE_ITMADDCART;

	$allParamsO->showNoRating = ! PCATALOG_NODE_ITMSHOWRATING;

	$allParamsO->showReview = PCATALOG_NODE_ITMFEEDBACK;

	$allParamsO->share = PCATALOG_NODE_ITMSHARE;

	$allParamsO->showReadMore = PCATALOG_NODE_ITMREADMORE;

	$allParamsO->mouseOver = PCATALOG_NODE_ITMMOUSEOVER;

	$allParamsO->showNoImage = ! PCATALOG_NODE_ITMSHOWIMAGE;

	$allParamsO->imageWidth = PCATALOG_NODE_ITMIMAGEWIDTH;

	$allParamsO->imageHeight = PCATALOG_NODE_ITMIMAGEHEIGHT;

	$allParamsO->showHeader = PCATALOG_NODE_ITMSHOWCOLUMN;
	$allParamsO->showMainCategory = PCATALOG_NODE_ITMSHOWCATEGORY;

	$allParamsO->showAll = PCATALOG_NODE_ITMSHOWALL;



	$generalPageID = PCATALOG_NODE_CATALOGPGIDGENERAL;

	$itemPageID = PCATALOG_NODE_CATALOGPGIDITEMS;

	$allParamsO->pageID =  (!empty( $itemPageID ) ) ? $itemPageID : ( (!empty( $generalPageID ) ) ? $generalPageID : '');



	$uniqueNameState = 'catalogHomeItems' . $i . 'type' . $allParamsO->prodtypid;

		$allParamsO->getadvsearch = true;

		if ( PCATALOG_NODE_ITMPAGI ) {

				
		$allParamsO->nb = PCATALOG_NODE_ITMNBDISPLAY;				if ( empty($allParamsO->nb) ) $allParamsO->nb = 10;			elseif ( $allParamsO->nb > 500 ) $allParamsO->nb = 500;

				$catalogAdvFilterC = WClass::get( 'catalog.advfilter' );
		$uniqueNameState .= $catalogAdvFilterC->getUniqueString();

				$allParamsO->pagination = true;			$allParamsO->yid = $uniqueNameState;	
	}
	$allParamsO->uniqueSection = $uniqueNameState;
	$allParamsO->widgetSlug = 'catalog_item';


	
	$productLoadC = WClass::get( 'item.load' );

	$productA = $productLoadC->get( $allParamsO );



	if ( empty($productA) ) {
		$productA = array( true );

		return '<span class="catalogItemEmpty">' . WText::t('1314356550DDJA') . '</span>';

	}


	
	if ( PCATALOG_NODE_ITMPAGI ) {

		$startLimit = WGlobals::getUserState("wiev-$uniqueNameState-limitstart", 'limitstart'.$uniqueNameState, 0, 'int' );

		$pagiI = WView::pagination( $uniqueNameState, $allParamsO->totalCount, $startLimit, $allParamsO->nb, 0, 'Items', 'home' );

		$pagiI->setFormName( $this->firstFormName );

		if ( !empty($this->_itemType) ) $pagiI->addHidden( 'type', $this->_itemType );

		$this->_itemsPagination = $pagiI->getListFooter();

	}


	
	$productLoadC->extraProcess( $productA, $allParamsO );

	
	$outputThemeC = WClass::get( 'output.theme' );

	$outputThemeC->nodeName = 'catalog';

	$outputThemeC->header = $productLoadC->setHeader();



	return $outputThemeC->createLayout( $productA, $allParamsO );



}








private function _loadCategories() {


	static $i=0;

	if ( !defined('PCATALOG_NODE_CTYLAYOUT') ) WPref::get( 'catalog.node' );



	$showItems = PCATALOG_NODE_CTYITEMS;

	if ( !$showItems ) return true;



	$this->setValue( 'categoryTitle', WText::t('1206732411EGQQ') );



	
	$allParamsO = new stdClass;

	$allParamsO->themeType = 'node';	
	$allParamsO->nodeName = 'catalog';



	$allParamsO->prodtypid = ( ( !empty($this->_itemType) ) ? $this->_itemType : 0 );	

	$i++;
	$uniqueNameState = 'catalogHomeCategories' . $i . 'type' . $allParamsO->prodtypid;


	
	if ( PCATALOG_NODE_CTYPAGI ) {













		
		

		$allParamsO->nb = PCATALOG_NODE_CTYNBDISPLAY;
		
		if ( empty($allParamsO->nb) ) $allParamsO->nb = 10;	
		elseif ( $allParamsO->nb > 500 ) $allParamsO->nb = 500;



		
		$allParamsO->pagination = true;	
		$allParamsO->yid = $uniqueNameState;	


	}

		$allParamsO->borderShow = PCATALOG_NODE_CTYBORDERSHOW;
	$allParamsO->borderColor = PCATALOG_NODE_CTYBORDERCOLOR;		$allParamsO->subCatPopOver = PCATALOG_NODE_CTYSUBCATPOPOVER;	

	$allParamsO->sorting = PCATALOG_NODE_CTYSORTING;

	$allParamsO->id = PCATALOG_NODE_CTYIDS;

	$allParamsO->parent = PCATALOG_NODE_CTYPARENT;

	$allParamsO->layout = PCATALOG_NODE_CTYLAYOUT;

	$allParamsO->layoutname = PCATALOG_NODE_CTYLAYOUTNAME;

	$allParamsO->layoutNbColumn = PCATALOG_NODE_CTYLAYOUTCOL;

	$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

	$allParamsO->carrouselArrow = 1;

	$allParamsO->hasItems = PCATALOG_NODE_CTYHASITEMS;

	$allParamsO->nb = PCATALOG_NODE_CTYNBDISPLAY;


	$allParamsO->level = PCATALOG_NODE_CTYNBLEVEL;

	$allParamsO->display = PCATALOG_NODE_CTYDISPLAY;

	$allParamsO->showNoName = ! PCATALOG_NODE_CTYSHOWNAME;

	$allParamsO->showDesc = PCATALOG_NODE_CTYSHOWDESC;

	$allParamsO->showNoItem = ! PCATALOG_NODE_CTYSHOWNBITM;
	$allParamsO->showNoItemSub = ! PCATALOG_NODE_CTYSHOWNBITMSUB;
	if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) $allParamsO->showNoItemSub = true;

	$allParamsO->nbItems = PCATALOG_NODE_CTYNBITEMS;
	$allParamsO->itemImage = PCATALOG_NODE_CTYNBITEMS;


	$allParamsO->climit = PCATALOG_NODE_CTYCLIMIT;

	$allParamsO->nlimit = PCATALOG_NODE_CTYNLIMIT;
	$allParamsO->showNoImage = ! PCATALOG_NODE_CTYSHOWIMAGE;

	$allParamsO->imageWidth = PCATALOG_NODE_CTYIMAGEWIDTH;

	$allParamsO->imageHeight = PCATALOG_NODE_CTYIMAGEHEIGHT;

	$allParamsO->showHeader = PCATALOG_NODE_CTYSHOWCOLUMN;

	$allParamsO->uniqueSection = $uniqueNameState;

	$allParamsO->showAll = PCATALOG_NODE_CTYSHOWALL;

	$generalPageID = PCATALOG_NODE_CATALOGPGIDGENERAL;

	$itemPageID = PCATALOG_NODE_CATALOGPGIDCATEGORY;

	$allParamsO->pageID = ( !empty( $itemPageID ) ) ? $itemPageID : ((!empty( $generalPageID )) ? $generalPageID : '');


	$allParamsO->widgetSlug = 'catalog_category';


	
	$productCategoryLoadC = WClass::get( 'item.loadcategory' );

	$categoryA = $productCategoryLoadC->get( $allParamsO );



	if ( empty($categoryA) ) return false;







	
	if ( PCATALOG_NODE_CTYPAGI ) {

		$startLimit = WGlobals::getUserState("wiev-$uniqueNameState-limitstart", 'limitstart'.$uniqueNameState, 0, 'int' );



		$pagiI = WView::pagination( $uniqueNameState, $allParamsO->totalCount, $startLimit, $allParamsO->nb, 0, 'Categories', 'home' );

		$pagiI->setFormName( $this->firstFormName );

		if ( !empty($this->_itemType) ) $pagiI->addHidden( 'type', $this->_itemType );

		$this->setValue( 'categoriesPagination', $pagiI->getListFooter() );



	}


	
	$productCategoryLoadC->extraProcess( $categoryA, $allParamsO );



	
	$outputThemeC = WClass::get( 'output.theme' );

	$outputThemeC->nodeName = 'catalog';

	$outputThemeC->layoutPrefix = 'cat';

	$outputThemeC->header = $productCategoryLoadC->setHeader();



	$displayCategories = $outputThemeC->createLayout( $categoryA, $allParamsO );



	$this->setValue( 'categories', $displayCategories );



	return true;



}










	private function _loadVendors() {

		static $i=0;

		$this->setValue( 'vendorTitle', WText::t('1220793715LTKS') );

		
		$allParamsO = new stdClass;

		$allParamsO->themeType = 'node';	
		$allParamsO->nodeName = 'catalog';



		$choicesorting = WGlobals::get( 'vendorsorting' );


		$i++;
				$uniqueNameState = 'catalogHomeVendors' . $i;


		
		if ( PCATALOG_NODE_VDRPAGI ) {



			



			$allParamsO->nb = PCATALOG_NODE_VDRNBDISPLAY;
			
			if ( empty($allParamsO->nb) ) $allParamsO->nb = 10;	
			elseif ( $allParamsO->nb > 500 ) $allParamsO->nb = 500;



			
			$allParamsO->pagination = true;	
			$allParamsO->yid = $uniqueNameState;	


		}

				$allParamsO->borderShow = PCATALOG_NODE_VDRBORDERSHOW;
		$allParamsO->borderColor = PCATALOG_NODE_VDRBORDERCOLOR;	

		$allParamsO->sorting = ( !empty($choicesorting) ) ? $choicesorting : PCATALOG_NODE_VDRSORTING;

		$allParamsO->id = PCATALOG_NODE_VDRIDS;

		$allParamsO->layout = PCATALOG_NODE_VDRLAYOUT;

		$allParamsO->layoutname = PCATALOG_NODE_VDRLAYOUTNAME;

		$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

		$allParamsO->carrouselArrow = 1;


		$allParamsO->layoutNbColumn = PCATALOG_NODE_VDRLAYOUTCOL;

		$allParamsO->nb = PCATALOG_NODE_VDRNBDISPLAY;

		if ( empty($allParamsO->nb) || $allParamsO->nb > 100 ) $allParamsO->nb = 10;

		$allParamsO->display = PCATALOG_NODE_VDRDISPLAY;

		$allParamsO->showNoName = ! PCATALOG_NODE_VDRSHOWNAME;

		$allParamsO->showDesc = PCATALOG_NODE_VDRSHOWDESC;

		$allParamsO->showQuestion = PCATALOG_NODE_VDRSHOWQUESTION;

		$allParamsO->climit = PCATALOG_NODE_VDRCLIMIT;

		$allParamsO->nlimit = PCATALOG_NODE_VDRNLIMIT;
		$allParamsO->showNoRating = ! PCATALOG_NODE_VDRSHOWRATING;

		$allParamsO->showReview = PCATALOG_NODE_VDRFEEDBACK;

		$allParamsO->share = PCATALOG_NODE_VDRSHARE;

		$allParamsO->showNoImage = ! PCATALOG_NODE_VDRSHOWIMAGE;

		$allParamsO->imageWidth = PCATALOG_NODE_VDRIMAGEWIDTH;

		$allParamsO->imageHeight = PCATALOG_NODE_VDRIMAGEHEIGHT;

		$allParamsO->showHeader = PCATALOG_NODE_VDRSHOWCOLUMN;

		$allParamsO->uniqueSection = $uniqueNameState;

		$allParamsO->showAll = PCATALOG_NODE_VDRSHOWALL;

		$generalPageID = PCATALOG_NODE_CATALOGPGIDGENERAL;

		$itemPageID = PCATALOG_NODE_CATALOGPGIDVENDORS;

		$allParamsO->pageID = (!empty( $itemPageID )) ? $itemPageID : ((!empty( $generalPageID )) ? $generalPageID : '');

		if ( empty($allParamsO->layout) ) $allParamsO->layout = 'badgemini';


		$allParamsO->widgetSlug = 'catalog_vendors';


		
		$vendorsLoadC = WClass::get( 'vendors.load' );

		$vendorsA = $vendorsLoadC->get( $allParamsO );



		if ( empty($vendorsA) ) return false;



		
		if ( PCATALOG_NODE_VDRPAGI ) {

			$startLimit = WGlobals::getUserState("wiev-$uniqueNameState-limitstart", 'limitstart'.$uniqueNameState, 0, 'int' );

			$pagiI = WView::pagination( $uniqueNameState, $allParamsO->totalCount, $startLimit, $allParamsO->nb, 0, 'Vendors', 'home' );

			$pagiI->setFormName( $this->firstFormName );

			if ( !empty($this->_itemType) ) $pagiI->addHidden( 'type', $this->_itemType );

			$this->setValue( 'vendorsPagination', $pagiI->getListFooter() );



		}


		
		$vendorsLoadC->extraProcess( $vendorsA, $allParamsO );



		
		$outputThemeC = WClass::get( 'output.theme' );

		$outputThemeC->nodeName = 'catalog';

		$outputThemeC->layoutPrefix = 'vendor';

		$outputThemeC->header = $vendorsLoadC->setHeader();



		$displayVendors = $outputThemeC->createLayout( $vendorsA, $allParamsO );






		$this->setValue( 'vendors', $displayVendors );

	}


















	private function _addTab($sorting,$content,$pagination,$id) {


		$params = new stdClass;

		$params->id = $id . '-' . $sorting;
		$params->idText = $params->id;

		$params->text = $this->_getSortingEquivalentName( $sorting );



		$this->_paneTab->startPage( $params );



		$this->_paneTab->content .= '<div class="nagiPadding clearfix">';
		$this->_paneTab->content .= $pagination;
		$this->_paneTab->content .= '</div>';
		$this->_paneTab->content .= $content;

		return $this->_paneTab->endPage( $params );



	}












	private function _getSortingEquivalentName($sorting) {



		switch ( $sorting ) {

			case 'featured':

				$text = WText::t('1256629159GBCH');

				break;

			case 'sold':

				$text = WText::t('1304527165QGOS');

				break;

			case 'rated':

				$text = WText::t('1257243215EFTI');

				break;

			case 'hits':

				$text = WText::t('1242282415NZTN');

				break;

			case 'reviews':

				$text = WText::t('1257243215EFTU');

				break;

			case 'highprice':

				$text = WText::t('1305198010FCNE');

				break;

			case 'lowprice':

				$text = WText::t('1305198010FCNF');

				break;

			case 'newest':

				$text = WText::t('1304918557EIYL');

				break;

			case 'oldest':

				$text = WText::t('1307606755CNOQ');

				break;

			case 'alphabetic':

				$text = WText::t('1219769904NDIK');

				break;

			case 'reversealphabetic':

				$text = WText::t('1307606756SRYP');

				break;

			case 'endingsoon':

				$text = WText::t('1412376020TDFY');

				break;

			case 'recentlyviewed':
				$text = WText::t('1420549772RZVB');
				break;
			case 'mytopviewed':
				$text = WText::t('1420549772RZVC');
				break;
			case 'recentlyupdated':
				$text = WText::t('1307606756SRYQ');
				break;
			case 'availabledate':
				$text = WText::t('1415146133GKRN');
				break;
			case 'random':

				$text = WText::t('1241592274CBNQ');

				break;

			case 'justsold':

				$text = WText::t('1308888986AJEG');

				break;

			default:

				$message = WMessage::get();

				$message->codeE( 'The following sorting is not defined: ' . $sorting );

				break;

		}


		return $text;

	}}