<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_category_catagories_view extends Output_Listings_class {


function prepareQuery() {


	
	$allParamsO = new stdClass;

	$allParamsO->themeType = 'node';	
	$allParamsO->nodeName = 'catalog';



		if ( !$categoryPrmsO->ctyitems ) return false;

		WGlobals::set( 'ctytitle', $categoryPrmsO->ctytitle, 'global' );

		if ( $categoryPrmsO->ctypagi ) {
				$this->pagiIncrement = $categoryPrmsO->ctylayoutcol;					$allParamsO->nb = WGlobals::getUserState("0wiev-$this->yid-limit", 'limit'.$this->yid, 0, 'int' );
		if ( empty($allParamsO->nb) ) $allParamsO->nb = $categoryPrmsO->ctylayoutcol;		if ( empty($allParamsO->nb) || $allParamsO->nb > 500 ) $allParamsO->nb = 10;					$allParamsO->pagination = true;			$this->pagination = 5;
		$allParamsO->yid = $this->yid;	
	}


	$allParamsO->sorting = $categoryPrmsO->ctysorting;

	$allParamsO->parent = WGlobals::get('eid');

	$allParamsO->layout = $categoryPrmsO->ctylayout;

	$allParamsO->layoutname = $categoryPrmsO->ctylayoutname;
	$allParamsO->layoutNbColumn = $categoryPrmsO->ctylayoutcol;
	$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

	$allParamsO->carrouselArrow = 1;


		$allParamsO->nb = !empty($categoryPrmsO->ctynbdisplay) ? $categoryPrmsO->ctynbdisplay : 500;

	$allParamsO->display = $categoryPrmsO->ctydisplay;

	$allParamsO->showNoName = ! $categoryPrmsO->ctyshowname;

	$allParamsO->showDesc = $categoryPrmsO->ctyshowdesc;

	$allParamsO->showNoItem = ! $categoryPrmsO->ctyshownbitm;
	$allParamsO->showNoItemSub = ! $categoryPrmsO->ctyshownbitmsub;
	if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) $allParamsO->showNoItemSub = true;

	$allParamsO->nbItems = $categoryPrmsO->nbitems;
	$allParamsO->itemImage = $categoryPrmsO->itemimage;

	$allParamsO->climit = $categoryPrmsO->ctyclimit;

	$allParamsO->showNoImage = ! $categoryPrmsO->ctyshowimage;

	$allParamsO->imageWidth = $categoryPrmsO->ctyimagewidth;

	$allParamsO->imageHeight = $categoryPrmsO->ctyimageheight;

	$allParamsO->showHeader = $categoryPrmsO->ctyshowcolumn;

	$allParamsO->pageID = $categoryPrmsO->ctypgid;

		if ( !empty($categoryPrmsO->ctyremoteurl) && !empty($categoryPrmsO->ctyremotecatid) ) {
		$myTagText = '{widget:productcat';
		foreach( $categoryPrmsO as $prop => $val ) if ( !empty($val) ) $myTagText .= '|'.$prop.'='.$val;
		$myTagText .= '|remoteURL='.$categoryPrmsO->ctyremoteurl.'|parent='.$categoryPrmsO->ctyremotecatid.'}';

		$tagC = WClass::get('output.process');
		$tagC->replaceTags( $myTagText );
		$this->customContent = $myTagText;
		$this->addData( array( 'dummmy' ) );			if ( !empty($allParamsO->totalCount) ) $this->setTotalCount( $allParamsO->totalCount );

				
		return true;
	}
	
	$productCategoryLoadC = WClass::get( 'item.loadcategory' );

	$categoryA = $productCategoryLoadC->get( $allParamsO );


	if ( empty($categoryA) ) return false;


	$this->addData( $categoryA );



	
	$productCategoryLoadC->extraProcess( $categoryA, $allParamsO );



	
	$outputThemeC = WClass::get( 'output.theme' );

	$outputThemeC->nodeName = 'catalog';

	$outputThemeC->layoutPrefix = 'cat';

	$outputThemeC->header = $productCategoryLoadC->setHeader();

	$this->customContent = $outputThemeC->createLayout( $categoryA, $allParamsO );

	return true;



}

}