<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Item_my_show_list_view extends Output_Forms_class {
private $_itemsPagination = '';	


protected function prepareView() {



		$this->setValue( 'itemTitle', WText::t('1337906340SAJU') );



		
		$itemPrmsO = new stdClass;

		$itemPrmsO->layout = 'badgeedit';

		$itemPrmsO->layoutname = '';

		$itemPrmsO->showcolumn = 1;

		$itemPrmsO->display = 'standard';

		$itemPrmsO->showprice = 1;

		$itemPrmsO->showbid = 1;

		$itemPrmsO->showpreview = 0;

		$itemPrmsO->showintro = 1;

		$itemPrmsO->showdesc = 0;

		$itemPrmsO->showVendor = 0;

		$itemPrmsO->showquestion = 0;

		$itemPrmsO->climit = 200;

		$itemPrmsO->addcart = 0;

		$itemPrmsO->showrating = 0;

		$itemPrmsO->feedback = 0;

		$itemPrmsO->share = '';

		$itemPrmsO->readmore = 0;

		$itemPrmsO->showimage = 1;

		$itemPrmsO->imagewidth = 60;

		$itemPrmsO->imageheight = 60;

		$itemPrmsO->showHeader = 0;

		$itemPrmsO->sorting = 'latest';

		$itemPrmsO->nbdisplay = 20;

		$itemPrmsO->pagi = 1;

		$itemPrmsO->layoutcol = 1;

		$itemPrmsO->showname = 1;

		$itemPrmsO->showfree = 1;

		$itemPrmsO->editable = 1;







		
		$allParamsO = new stdClass;

		$allParamsO->themeType = 'node';	
		$allParamsO->nodeName = 'catalog';



		$choicesorting = WGlobals::get( 'choicesorting' );



		$allParamsO->sorting = ( !empty($choicesorting) ) ? $choicesorting : $itemPrmsO->sorting;

		
		WGlobals::set( 'myItemsSorting', $allParamsO->sorting, 'global' );



		
		$joobiRun = 'return '.WPage::actionJavaScript( 'category', $this->firstFormName );

		$params = new stdClass;

		$params->map = 'choicesorting';	


		$allParamsO->showSubCategory = 1;





		$allParamsO->nb = $itemPrmsO->nbdisplay;


		$uniqueNameState = 'myItems';	
		
		if ( $itemPrmsO->pagi ) {	


			
			
			




			
			if ( empty($allParamsO->nb) ) $allParamsO->nb = 10;	
			elseif ( $allParamsO->nb > 1000 ) $allParamsO->nb = 1000;



			
			$allParamsO->pagination = true;	
			$allParamsO->yid = $uniqueNameState;	
		}


		$allParamsO->layout = $itemPrmsO->layout;

		$allParamsO->layoutname = $itemPrmsO->layoutname;

		$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

		$allParamsO->layoutNbColumn = $itemPrmsO->layoutcol;

		$allParamsO->display = $itemPrmsO->display;

		$allParamsO->showNoName = ! $itemPrmsO->showname;

		$allParamsO->dontShowFree = ! $itemPrmsO->showfree;

		$allParamsO->showPrice = $itemPrmsO->showprice;

		$allParamsO->showBid = $itemPrmsO->showbid;
		if (!empty($itemPrmsO->showcountdown) ) $allParamsO->showcountdown = $itemPrmsO->showcountdown;

		$allParamsO->showPreview = $itemPrmsO->showpreview;

		$allParamsO->showIntro = $itemPrmsO->showintro;

		$allParamsO->showDesc = $itemPrmsO->showdesc;

		$allParamsO->showVendor = $itemPrmsO->showVendor;

		$allParamsO->showQuestion = $itemPrmsO->showquestion;

		$allParamsO->climit = $itemPrmsO->climit;

		$allParamsO->addCart = $itemPrmsO->addcart;

		$allParamsO->showNoRating = ! $itemPrmsO->showrating;

		$allParamsO->showReview = $itemPrmsO->feedback;

		$allParamsO->share = $itemPrmsO->share;

		$allParamsO->showReadMore = $itemPrmsO->readmore;

		$allParamsO->showNoImage = ! $itemPrmsO->showimage;

		$allParamsO->imageWidth = $itemPrmsO->imagewidth;

		$allParamsO->imageHeight = $itemPrmsO->imageheight;

		$allParamsO->showHeader = $itemPrmsO->showHeader;



		
		$allParamsO->editable = $itemPrmsO->editable;

		$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

		$uid = WUser::get('uid');

		$allParamsO->vendor = $vendorHelperC->getVendorID( $uid );

		
		if ( empty($allParamsO->vendor) ) return false;



		
		$productLoadC = WClass::get( 'item.load' );

		$productA = $productLoadC->get( $allParamsO );



		if ( empty($productA) ) {
			$productA = array( true );
			$this->setValue( 'items', '<span class="catalogItemEmpty">' . WText::t('1314356550DDJA') . '</span>' );

			return true;

		}


		
		if ( $itemPrmsO->pagi ) {

			$startLimit = WGlobals::getUserState( "wiev-$uniqueNameState-limitstart", 'limitstart'.$uniqueNameState, 0, 'int' );

			$pagiI = WView::pagination( $uniqueNameState, $allParamsO->totalCount, $startLimit, $allParamsO->nb, 0, 'ItemsListing', 'listing' );

			$pagiI->setFormName( $this->firstFormName );

			$this->_itemsPagination = $pagiI->getListFooter();
		}


		
		$productLoadC->extraProcess( $productA, $allParamsO );

		
		$outputThemeC = WClass::get( 'output.theme' );

		$outputThemeC->nodeName = 'catalog';

		$outputThemeC->header = $productLoadC->setHeader();



		$displayedItems = $outputThemeC->createLayout( $productA, $allParamsO );



		
		$this->setValue( 'itemsPagination', $this->_itemsPagination );

		$this->setValue( 'items', $displayedItems );



	return true;



}
}