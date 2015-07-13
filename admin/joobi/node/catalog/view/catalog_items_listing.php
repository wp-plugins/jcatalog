<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_items_listing_view extends Output_Listings_class {
function prepareQuery() {



	if ( !defined('PCATALOG_NODE_ITMLAYOUT') ) WPref::get( 'catalog.node' );







	
	$allParamsO = new stdClass;

	$allParamsO->themeType = 'node';	
	$allParamsO->nodeName = 'catalog';



	
	$choicesorting = WGlobals::get( 'choicesorting' );



	$type = WGlobals::get( 'type', null );

	if ( !empty($type) ) $allParamsO->type = $type;

	else $allParamsO->prodtypid = WGlobals::get('prodtypid', 0 );

	$category = WGlobals::get('category', null );

	if ( !empty($category) ) $allParamsO->category = $category;

	$vendor = WGlobals::get('vendor', null );

	if ( !empty($vendor) ) $allParamsO->vendor = $vendor;





	$allParamsO->sorting = ( !empty($choicesorting) ) ? $choicesorting : PCATALOG_NODE_ITMSORTING;

	
	WGlobals::set( 'homeItemsSorting', $allParamsO->sorting, 'global' );



	$allParamsO->nb = 5;	
	$allParamsO->display = PCATALOG_NODE_ITMDISPLAY;



	
	$uniqueNameState = 'catalogItemsList' . $type;

	$allParamsO->nb = PCATALOG_NODE_ITMNBDISPLAY;
	
	if ( empty($allParamsO->nb) ) $allParamsO->nb = 10;	
	elseif ( $allParamsO->nb > 500 ) $allParamsO->nb = 500;



	$allParamsO->pagination = true;

	$allParamsO->yid = $this->yid ;



	$allParamsO->id = PCATALOG_NODE_ITMPIDS;

	$allParamsO->search = PCATALOG_NODE_ITMSEARCH;

	$allParamsO->layout = PCATALOG_NODE_ITMLAYOUT;

	$allParamsO->layoutname = PCATALOG_NODE_ITMLAYOUTNAME;

	$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

	$allParamsO->carrouselArrow = 1;


	$allParamsO->layoutNbColumn = PCATALOG_NODE_ITMLAYOUTCOL;

	if ( empty($allParamsO->nb) || $allParamsO->nb > 200 ) $allParamsO->nb = 10;

	$allParamsO->display = PCATALOG_NODE_ITMDISPLAY;


		$allParamsO->borderShow = PCATALOG_NODE_ITMBORDERSHOW;
	$allParamsO->borderColor = PCATALOG_NODE_ITMBORDERCOLOR;	

	$allParamsO->showNoName = 0;

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

	$allParamsO->mouseOver = PCATALOG_NODE_ITMMOUSEOVER;

	$allParamsO->showReadMore = PCATALOG_NODE_ITMREADMORE;

	$allParamsO->showNoImage = ! PCATALOG_NODE_ITMSHOWIMAGE;

	$allParamsO->imageWidth = PCATALOG_NODE_ITMIMAGEWIDTH;

	$allParamsO->imageHeight = PCATALOG_NODE_ITMIMAGEHEIGHT;

	$allParamsO->showHeader = PCATALOG_NODE_ITMSHOWCOLUMN;

	$allParamsO->showAll = PCATALOG_NODE_ITMSHOWALL;

	$allParamsO->uniqueSection = $uniqueNameState;





	$generalPageID = PCATALOG_NODE_CATALOGPGIDGENERAL;

	$itemPageID = PCATALOG_NODE_CATALOGPGIDITEMS;

	$allParamsO->pageID = ( !empty( $itemPageID ) ) ? $itemPageID : ( ( !empty($generalPageID) ) ? $generalPageID : '');





	
	$productLoadC = WClass::get( 'item.load' );

	$productA = $productLoadC->get( $allParamsO );



	
	if ( !empty( $allParamsO->totalCount) ) $this->setCount( $allParamsO->totalCount );



	if ( empty($productA) ) {

		$this->content = WText::t('1308888992TDMY');

		return true;

	}


	$this->addData( $productA );



	
	$productLoadC->extraProcess( $productA, $allParamsO );



	
	$outputThemeC = WClass::get( 'output.theme' );

	$outputThemeC->nodeName = 'catalog';

	$outputThemeC->header = $productLoadC->setHeader();


	


	$panel = new stdClass;
	$panel->id = $uniqueNameState;
	$panel->body = $outputThemeC->createLayout( $productA, $allParamsO );

	$this->customContent = WPage::renderBluePrint( 'panel', $panel );

	return true;



}}