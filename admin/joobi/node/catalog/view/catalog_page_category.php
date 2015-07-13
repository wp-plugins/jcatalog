<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Catalog_page_category_view extends Output_Forms_class {
private $_useCustom = false;



	private $_catid = 0;



	private $_categoryType = 0;



	private $_itemPrmsO = null;	
	private $_categoryPrmsO = null;



	private $_itemsPagination = '';	
	private $_categoriesPagination = '';	


	private $_subcategoryCount = 0;





	protected function prepareView() {


		$this->_catid = WGlobals::getEID();

		if ( empty( $this->_catid ) ) $this->_catid = WGlobals::get( 'catid' );



		
		$generalCatPageID = WPref::load( 'PCATALOG_NODE_CATEGORYPGIDGENERAL' );

		if ( !empty($generalCatPageID) ) {

			$cmsPage = WPage::cmsGetItemId();

			if ( $generalCatPageID != $cmsPage ) {

				

			}
		}


		$this->_categoryType = $this->getValue( 'prodtypid' );



		$this->_useCustom = $this->getValue( 'ctygeneral' );


		
		if ( !empty($this->formObj) ) $this->formObj->hidden( 'eid' , $this->_catid );



		
		$this->bctrail = WPref::load( 'PCATALOG_NODE_BREADCRUMBS' );



		$ItemTitle = $this->getValue( 'numpid' ) > 1 ? WText::t('1233642085PNTA') : WText::t('1206732372QTKR');

		$this->setValue( 'subProductTitle', $ItemTitle );

		$ItemTitleSub = $this->getValue( 'numpidsub' ) > 1 ? WText::t('1233642085PNTA') : WText::t('1206732372QTKR');
		$this->setValue( 'subProductSubTitle', $ItemTitleSub );


	
		$pageParams = new stdClass;





		
		$HeaderPreferencesA = array(

		'showViews' => 'pagecatshowviews',

		'showLike' => 'pagecatshowlike',

		'showTweet' => 'pagecatshowtweet',

		'showBuzz' => 'pagecatshowbuzz',

		'showShareThis' => 'pagecatshowsharethis',

		'showFavorite' => 'pagecatshowfavorite',

		'showWatch' => 'pagecatshowwatch',

		'showLikeDislike' => 'pagecatshowlikedislike',

		'showShareWall' => 'pagecatshowsharewall',

		'showPrint' => 'pagecatshowprint'

		);



		foreach( $HeaderPreferencesA as $keyUp => $keyDown ) {

			if ( $this->_useCustom ) $pageParams->$keyUp = $this->getValue( $keyDown );

			else $pageParams->$keyUp = constant( 'PCATALOG_NODE_' . strtoupper( $keyDown ) );

		}


		$this->_processList();



		if ( $pageParams->showLike || $pageParams->showTweet || $pageParams->showBuzz || $pageParams->showShareThis || $pageParams->showFavorite || $pageParams->showWatch || $pageParams->showViews || $pageParams->showLikeDislike || $pageParams->showShareWall || $pageParams->showPrint ) {

			$itemName = $this->getValue( 'name' );

			$catalogShowproductC = WClass::get('catalog.showsocial');

			if ( !$catalogShowproductC->shareDisplay( $this, $this->_catid, $itemName, $pageParams, 'category', $this->getValue( 'hits', 'item.category' ) ) ) return false;

		}


		if ( $this->_useCustom ) {	


			WGlobals::set( 'listItemsSorting', $this->getValue('itmavailsort'), 'global' );



			
			if ( $this->getValue('catcarrousel') ) $this->_createCarrousel();



			
			if (!empty($this->_catid) && $this->getValue('ctyitems') ) $this->_countSubCategory();



			$pageParams->ctycss = $this->getValue('ctycss');

			$pageParams->categoryShowName = $this->getValue('categoryshowname');

			$pageParams->categoryShowDesc = $this->getValue('categoryshowdesc');

			$pageParams->categoryCountCat = $this->getValue('categorycountcat');

			$pageParams->categoryCountItems = $this->getValue('categorycountitems');
			$pageParams->categoryCountItemSub = $this->getValue('categorycountitemsub');
			if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) $pageParams->categoryCountItemSub = false;

			$pageParams->categoryShowRSS = $this->getValue('categoryshowrss');

			$pageParams->categoryShowImage = $this->getValue('categoryshowimage');

			$pageParams->categoryImageWidth = $this->getValue('categoryimagewidth');

			$pageParams->categoryImageHeight = $this->getValue('categoryimageheight');



			
			WGlobals::set( 'categoryPageParams', $pageParams, 'global' );



			
			$categoryPrmsO = new stdClass;


			$categoryPrmsO->ctybordershow = $this->getValue('ctybordershow');
			$categoryPrmsO->ctybordercolor = $this->getValue('ctybordercolor');

			$categoryPrmsO->ctyhasitems = $this->getValue('ctyhasitems');
			$categoryPrmsO->ctysubcatpopover = $this->getValue('ctysubcatpopover');
			$categoryPrmsO->ctynbitems = $this->getValue('ctynbitems');

			$categoryPrmsO->ctyitems = $this->getValue('ctyitems');

			$categoryPrmsO->ctytitle = $this->getValue('ctytitle');

			$categoryPrmsO->ctysorting = $this->getValue('ctysorting');

			$categoryPrmsO->ctylayout = $this->getValue('ctylayout');

			$categoryPrmsO->ctylayoutname = $this->getValue('ctylayoutname');

			$categoryPrmsO->ctylayoutcol = $this->getValue('ctylayoutcol');

			$categoryPrmsO->ctypagi = $this->getValue('ctypagi');

			$categoryPrmsO->ctynbdisplay = $this->getValue('ctynbdisplay');

			$categoryPrmsO->ctynblevel = $this->getValue('ctynblevel');

			$categoryPrmsO->ctydisplay = $this->getValue('ctydisplay');

			$categoryPrmsO->ctyshowname = $this->getValue('ctyshowname');

			$categoryPrmsO->ctyshowdesc = $this->getValue('ctyshowdesc');

			$categoryPrmsO->ctyshownbitm = $this->getValue( 'ctyshownbitm' );

			$categoryPrmsO->ctyshownbitmsub = $this->getValue( 'ctyshownbitmsub' );
			if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) $categoryPrmsO->ctyshownbitmsub = false;
			$categoryPrmsO->ctyclimit = $this->getValue('ctyclimit');

			$categoryPrmsO->ctynlimit = $this->getValue('ctynlimit');
			$categoryPrmsO->ctyshowimage = $this->getValue('ctyshowimage');

			$categoryPrmsO->ctyimagewidth = $this->getValue('ctyimagewidth');

			$categoryPrmsO->ctyimageheight = $this->getValue('ctyimageheight');

			$categoryPrmsO->ctyshowcolumn = $this->getValue('ctyshowcolumn');



			$categoryPrmsO->ctyremoteurl = $this->getValue('ctyurl');

			$categoryPrmsO->ctyremotecatid = $this->getValue('ctyrmtcatid');

			$categoryPrmsO->ctyjaffid = $this->getValue('ctyjaffid');



			
			$generalPageID = $this->getValue('catgenpgid');

			$itemPageID = $this->getValue('ctypgid');

			$categoryPrmsO->ctypgid = (!empty( $itemPageID )) ? $itemPageID : ((!empty( $generalPageID )) ? $generalPageID : '');



			$this->_categoryPrmsO = $categoryPrmsO;



			
			$itemPrmsO = new stdClass;

			$itemPrmsO->itmitems = $this->getValue('itmitems');

			$itemPrmsO->itmtitle = $this->getValue('itmtitle');

			$itemPrmsO->itmsubcat = $this->getValue('itmsubcat');



			$itemPrmsO->itmpids = $this->getValue('itmpids');

			$itemPrmsO->itmsearch = $this->getValue('itmssearch');

			if ( !empty($this->_categoryType) ) {

				$itemPrmsO->itmtype = $this->_categoryType;

			} else {

				$itemPrmsO->itmtype = $this->getValue('itmtype');

			}

			$itemPrmsO->itmbordershow = $this->getValue( 'itmbordershow' );
			$itemPrmsO->itmbordercolor = $this->getValue( 'itmbordercolor' );
			$itemPrmsO->itmshowcountdown = $this->getValue( 'showcountdown' );


			$itemPrmsO->itmsorting = $this->getValue('itmsorting');

			$itemPrmsO->itmlayout = $this->getValue('itmlayout');

			$itemPrmsO->itmlayoutname = $this->getValue('itmlayoutname');

			$itemPrmsO->itmlayoutcol = $this->getValue('itmlayoutcol');

			$itemPrmsO->itmnbdisplay = $this->getValue('itmnbdisplay');

			$itemPrmsO->itmpagi = $this->getValue('itmpagi');

			$itemPrmsO->itmdisplay = $this->getValue('itmdisplay');

			$itemPrmsO->itmshowname = $this->getValue('itmshowname');

			$itemPrmsO->itmshowdesc = $this->getValue('itmshowdesc');

			$itemPrmsO->itmclimit = $this->getValue('itmclimit');

			$itemPrmsO->itmnlimit = $this->getValue('itmnlimit');
			$itemPrmsO->itmshowimage = $this->getValue('itmshowimage');

			$itemPrmsO->itmimagewidth = $this->getValue('itmimagewidth');

			$itemPrmsO->itmimageheight = $this->getValue('itmimageheight');

			$itemPrmsO->itmshowcolumn = $this->getValue('itmshowcolumn');



			$itemPrmsO->itmshowfree = $this->getValue('itmshowfree');

			$itemPrmsO->itmshowprice = $this->getValue('itmshowprice');

			$itemPrmsO->itmshowbid = $this->getValue('itmshowbid');

			$itemPrmsO->itmshowpreview = $this->getValue('itmshowpreview');

			$itemPrmsO->itmshowintro = $this->getValue('itmshowintro');

			$itemPrmsO->itmshowvendor = $this->getValue('itmshowvendor');

			$itemPrmsO->itmshowquestion = $this->getValue('itmshowquestion');

			$itemPrmsO->itmaddcart = $this->getValue('itmaddcart');

			$itemPrmsO->itmshowrating = $this->getValue('itmshowrating');

			$itemPrmsO->itmfeedback = $this->getValue('itmfeedback');

			$itemPrmsO->itmshare = $this->getValue('itmshare');

			$itemPrmsO->itmreadmore = $this->getValue('itmreadmore');

			$itemPrmsO->itmmouseOver = $this->getValue('itmmouseover');



			$itemPrmsO->itmremoteurl = $this->getValue('ctyurl');

			$itemPrmsO->itmremotecatid = $this->getValue('ctyrmtcatid');

			$itemPrmsO->itmjaffid = $this->getValue('ctyjaffid');



			
			$generalPageID = $this->getValue('catgenpgid');

			$itemPageID = $this->getValue('itmspgid');

			$itemPrmsO->itmspgid = ( !empty( $itemPageID ) ) ? $itemPageID : ( ( !empty( $generalPageID ) ) ? $generalPageID : '' );



			$this->_itemPrmsO = $itemPrmsO;



		} else {	

			if ( !defined('PCATALOG_NODE_CTYLAYOUT') ) WPref::get( 'catalog.node' );



			WGlobals::set( 'listItemsSorting', PCATALOG_NODE_CATITMAVAILSORT, 'global' );	


			
			if ( PCATALOG_NODE_CATCARROUSEL ) $this->_createCarrousel();



			
			if ( !empty($this->_catid) && PCATALOG_NODE_CATCTYITEMS ) $this->_countSubCategory();



			$pageParams->ctycss = '';

			$pageParams->categoryShowName = PCATALOG_NODE_CATEGORYSHOWNAME;
			$pageParams->categoryShowDesc = PCATALOG_NODE_CATEGORYSHOWDESC;	
			$pageParams->categoryCountCat = PCATALOG_NODE_CATEGORYCOUNTCAT;	
			$pageParams->categoryCountItems = PCATALOG_NODE_CATEGORYCOUNTITEMS;				$pageParams->categoryCountItemSub = PCATALOG_NODE_CATEGORYCOUNTITEMSUB;				if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) $pageParams->categoryCountItemSub = false;

			$pageParams->categoryShowRSS = PCATALOG_NODE_CATEGORYSHOWRSS;	
			$pageParams->categoryShowImage = PCATALOG_NODE_CATEGORYSHOWIMAGE;	
			$pageParams->categoryImageWidth = PCATALOG_NODE_CATEGORYIMAGEWIDTH;	
			$pageParams->categoryImageHeight = PCATALOG_NODE_CATEGORYIMAGEHEIGHT;	


			
			WGlobals::set( 'categoryPageParams', $pageParams, 'global' );



			
			$categoryPrmsO = new stdClass;

			$categoryPrmsO->ctybordershow = PCATALOG_NODE_CATCTYBORDERSHOW;
			$categoryPrmsO->ctybordercolor = PCATALOG_NODE_CATCTYBORDERCOLOR;

			$categoryPrmsO->ctyhasitems = PCATALOG_NODE_CATCTYHASITEMS;
			$categoryPrmsO->ctysubcatpopover = PCATALOG_NODE_CATCTYSUBCATPOPOVER;
			$categoryPrmsO->ctynbitems = PCATALOG_NODE_CATCTYNBITEMS;


			$categoryPrmsO->ctyitems = PCATALOG_NODE_CATCTYITEMS;

			$categoryPrmsO->ctytitle = PCATALOG_NODE_CATCTYTITLE;

			$categoryPrmsO->ctysorting = PCATALOG_NODE_CATCTYSORTING;

			$categoryPrmsO->ctylayout = PCATALOG_NODE_CATCTYLAYOUT;

			$categoryPrmsO->ctylayoutname = PCATALOG_NODE_CATCTYLAYOUTNAME;

			$categoryPrmsO->ctylayoutcol = PCATALOG_NODE_CATCTYLAYOUTCOL;

			$categoryPrmsO->ctynbdisplay = PCATALOG_NODE_CATCTYNBDISPLAY;

			$categoryPrmsO->ctynblevel = PCATALOG_NODE_CATCTYNBLEVEL;

			$categoryPrmsO->ctypagi = PCATALOG_NODE_CATCTYPAGI;

			$categoryPrmsO->ctydisplay = PCATALOG_NODE_CATCTYDISPLAY;

			$categoryPrmsO->ctyshowname = PCATALOG_NODE_CATCTYSHOWNAME;

			$categoryPrmsO->ctyshowdesc = PCATALOG_NODE_CATCTYSHOWDESC;

			$categoryPrmsO->ctyshownbitm = PCATALOG_NODE_CATCTYSHOWNBITM;
			$categoryPrmsO->ctyshownbitmsub = PCATALOG_NODE_CATCTYSHOWNBITMSUB;
			if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) $categoryPrmsO->ctyshownbitmsub = false;

			$categoryPrmsO->ctyclimit = PCATALOG_NODE_CATCTYCLIMIT;

			$categoryPrmsO->ctynlimit = PCATALOG_NODE_CATCTYNLIMIT;
			$categoryPrmsO->ctyshowimage = PCATALOG_NODE_CATCTYSHOWIMAGE;

			$categoryPrmsO->ctyimagewidth = PCATALOG_NODE_CATCTYIMAGEWIDTH;

			$categoryPrmsO->ctyimageheight = PCATALOG_NODE_CATCTYIMAGEHEIGHT;

			$categoryPrmsO->ctyshowcolumn = PCATALOG_NODE_CATCTYSHOWCOLUMN;



			$categoryPrmsO->ctyremoteurl = $this->getValue('ctyurl');

			$categoryPrmsO->ctyremotecatid = $this->getValue('ctyrmtcatid');

			$categoryPrmsO->ctyjaffid = $this->getValue('ctyjaffid');



			
			$generalPageID = PCATALOG_NODE_CATEGORYPGIDGENERAL;

			$itemPageID = PCATALOG_NODE_CATEGORYPGIDCATEGORY;

			$categoryPrmsO->ctypgid = (!empty( $itemPageID )) ? $itemPageID : ((!empty( $generalPageID )) ? $generalPageID : '');



			$this->_categoryPrmsO = $categoryPrmsO;



			
			$itemPrmsO = new stdClass;

			$itemPrmsO->itmitems = PCATALOG_NODE_CATITMITEMS;

			$itemPrmsO->itmtitle = PCATALOG_NODE_CATITMTITLE;

			$itemPrmsO->itmsubcat = PCATALOG_NODE_CATITMSUBCAT;



			$itemPrmsO->itmpids = PCATALOG_NODE_CATITMPIDS;

			$itemPrmsO->itmsearch = PCATALOG_NODE_CATITMSEARCH;

			if ( !empty($this->_categoryType) ) {

				$itemPrmsO->itmtype = $this->_categoryType;

			} else {

				$itemPrmsO->itmtype = PCATALOG_NODE_CATITMTYPE;

			}

			$itemPrmsO->itmbordershow = PCATALOG_NODE_CATITMBORDERSHOW;
			$itemPrmsO->itmbordercolor = PCATALOG_NODE_CATITMBORDERCOLOR;
			$itemPrmsO->itmshowcountdown = PCATALOG_NODE_CATITMSHOWCOUNTDOWN;

			$itemPrmsO->itmsorting = PCATALOG_NODE_CATITMSORTING;

			$itemPrmsO->itmlayout = PCATALOG_NODE_CATITMLAYOUT;

			$itemPrmsO->itmlayoutname = PCATALOG_NODE_CATITMLAYOUTNAME;

			$itemPrmsO->itmlayoutcol = PCATALOG_NODE_CATITMLAYOUTCOL;

			$itemPrmsO->itmnbdisplay = PCATALOG_NODE_CATITMNBDISPLAY;

			$itemPrmsO->itmpagi = PCATALOG_NODE_CATITMPAGI;

			$itemPrmsO->itmdisplay = PCATALOG_NODE_CATITMDISPLAY;

			$itemPrmsO->itmshowname = PCATALOG_NODE_CATITMSHOWNAME;

			$itemPrmsO->itmshowdesc = PCATALOG_NODE_CATITMSHOWDESC;

			$itemPrmsO->itmclimit = PCATALOG_NODE_CATITMCLIMIT;

			$itemPrmsO->itmnlimit = PCATALOG_NODE_CATITMNLIMIT;
			$itemPrmsO->itmshowimage = PCATALOG_NODE_CATITMSHOWIMAGE;

			$itemPrmsO->itmimagewidth = PCATALOG_NODE_CATITMIMAGEWIDTH;

			$itemPrmsO->itmimageheight = PCATALOG_NODE_CATITMIMAGEHEIGHT;

			$itemPrmsO->itmshowcolumn = PCATALOG_NODE_CATITMSHOWCOLUMN;



			$itemPrmsO->itmshowfree = PCATALOG_NODE_CATITMSHOWFREE;

			$itemPrmsO->itmshowprice = PCATALOG_NODE_CATITMSHOWPRICE;

			$itemPrmsO->itmshowbid = PCATALOG_NODE_CATITMSHOWBID;

			$itemPrmsO->itmshowpreview = PCATALOG_NODE_CATITMSHOWPREVIEW;

			$itemPrmsO->itmshowintro = PCATALOG_NODE_CATITMSHOWINTRO;

			$itemPrmsO->itmshowvendor = PCATALOG_NODE_CATITMSHOWVENDOR;

			$itemPrmsO->itmshowquestion = PCATALOG_NODE_CATITMSHOWQUESTION;

			$itemPrmsO->itmaddcart = PCATALOG_NODE_CATITMADDCART;

			$itemPrmsO->itmshowrating = PCATALOG_NODE_CATITMSHOWRATING;

			$itemPrmsO->itmfeedback = PCATALOG_NODE_CATITMFEEDBACK;

			$itemPrmsO->itmshare = PCATALOG_NODE_CATITMSHARE;

			$itemPrmsO->itmreadmore = PCATALOG_NODE_CATITMREADMORE;

			$itemPrmsO->itmmouseOver = PCATALOG_NODE_CATITMMOUSEOVER;



			$itemPrmsO->itmremoteurl = $this->getValue('ctyurl');

			$itemPrmsO->itmremotecatid = $this->getValue('ctyrmtcatid');

			$itemPrmsO->itmjaffid = $this->getValue('ctyjaffid');



			
			$generalPageID = PCATALOG_NODE_CATEGORYPGIDGENERAL;

			$itemPageID = PCATALOG_NODE_CATEGORYPGIDITEMS;

			$itemPrmsO->itmspgid = ( !empty( $itemPageID ) ? $itemPageID : ( ( !empty( $generalPageID ) ) ? $generalPageID : '' ) );



			$this->_itemPrmsO = $itemPrmsO;



		}


		
		WGlobals::set( 'itmtitle', $itemPrmsO->itmtitle, 'global' );

		
		$this->setValue( 'itemTitle', WText::t('1233642085PNTA') );





		
		$this->_loadSubCategories();



		
		$displayedItems = $this->_loadItems();

		$this->setValue( 'itemsPagination', $this->_itemsPagination );

		$this->setValue( 'items', $displayedItems );





		
		$this->_loadVendors();



		$uid = WUser::get('uid');

		
		if ( !empty($uid) && PCATALOG_NODE_EDITITEMCATALOG ) {



			$showEditDeleteButton = false;

			$vendid = 0;



			if ( WExtension::exist( 'vendors.node' ) ) {



				
				$roleHelper = WRole::get();

				if ( WRole::hasRole( 'vendor' ) ) {

					$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

					$vendid = $vendorHelperC->getVendorID( $uid );

				}


				if ( !empty($vendid) ) {

					
					WPref::load( 'PITEM_NODE_ALLOWVENDORCAT' );



					if ( !PITEM_NODE_ALLOWVENDORCAT ) {

						$categoryVendID = $this->getValue( 'vendid' );

						
						if ( $categoryVendID == $vendid ) {

							$showEditDeleteButton = true;

						}


					} else {

						$showEditDeleteButton = true;

					}


				}


			}


			if ( !$showEditDeleteButton ) {

				
				$roleHelper = WRole::get();

				$showEditDeleteButton = WRole::hasRole( 'storemanager' );

			}


			
			if ( $showEditDeleteButton ) {



				$prodtypid = $this->getValue('prodtypid');

				if ( empty($prodtypid) ) {

					
					$itemQueryC = WClass::get( 'item.query' );

					$total = $itemQueryC->count( true );

					if ( $total <= 1 ) {

						$typePublished = $itemQueryC->getPublishedType();

						$itemTypeC = WClass::get('item.type');

						$this->setValue( 'newButton', WText::t('1206732361LXFD') . ' ' . $itemTypeC->loadData( $typePublished, 'name' ) );

					} else {	
						$this->setValue( 'newButton', WText::t('1395715485CICC') );

					}


				} else {

					
					$itemTypeC = WClass::get('item.type');

					$this->setValue( 'newButton', WText::t('1206732361LXFD') . ' ' . $itemTypeC->loadData( $prodtypid, 'name' ) );

				}




					$myLink = WPage::routeURL( 'controller=item&task=nuevo&categoryid=' . $this->_catid . '&prodtypid=' . $prodtypid, 'home', 'popup', false, false, null, true );





				$this->setValue( 'newButtonLink', $myLink );



			}
		}


		return true;



	}








	private function _loadSubCategories() {


		$categoryPrmsO = $this->_categoryPrmsO;



		
		if ( !$categoryPrmsO->ctyitems ) return false;



		if ( empty($this->_subcategoryCount)

			&& ( empty($categoryPrmsO->ctyremoteurl) || empty($categoryPrmsO->ctyremotecatid) ) ) return false;




		
		$allParamsO = new stdClass;

		$allParamsO->themeType = 'node';	
		$allParamsO->nodeName = 'catalog';




		
		WGlobals::set( 'ctytitle', $categoryPrmsO->ctytitle, 'global' );

		$this->setValue( 'categoryTitle', WText::t('1304526973ACEV') );



		$uniqueNameState = 'catalogCategorySubCat' . $this->_catid;	


		
		if ( $categoryPrmsO->ctypagi ) {

			











			
			

			$allParamsO->nb = $categoryPrmsO->ctynbdisplay;
			
			if ( empty($allParamsO->nb) ) $allParamsO->nb = 10;	
			elseif ( $allParamsO->nb > 500 ) $allParamsO->nb = 500;



			
			$allParamsO->pagination = true;	
			$allParamsO->yid = $uniqueNameState;	


		}


				$allParamsO->borderShow = $categoryPrmsO->ctybordershow;
		$allParamsO->borderColor = $categoryPrmsO->ctybordercolor;	

		$allParamsO->sorting = $categoryPrmsO->ctysorting;

		$allParamsO->parent = WGlobals::get('eid');

		$allParamsO->layout = $categoryPrmsO->ctylayout;

		$allParamsO->layoutname = $categoryPrmsO->ctylayoutname;

		$allParamsO->layoutNbColumn = $categoryPrmsO->ctylayoutcol;

		$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

		$allParamsO->carrouselArrow = 1;


		
		$allParamsO->nb = (!empty($categoryPrmsO->ctynbdisplay) ? $categoryPrmsO->ctynbdisplay : 500);
		$allParamsO->hasItems = $categoryPrmsO->ctyhasitems;
		$allParamsO->subCatPopOver = $categoryPrmsO->ctysubcatpopover;


		$allParamsO->level = $categoryPrmsO->ctynblevel;

		$allParamsO->display = $categoryPrmsO->ctydisplay;

		$allParamsO->showNoName = ! $categoryPrmsO->ctyshowname;

		$allParamsO->showDesc = $categoryPrmsO->ctyshowdesc;

		$allParamsO->showNoItem = ! $categoryPrmsO->ctyshownbitm;
		$allParamsO->showNoItemSub = ! $categoryPrmsO->ctyshownbitmsub;
		if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) $allParamsO->showNoItemSub = true;

		$allParamsO->nbItems = $categoryPrmsO->ctynbitems;
		if ( !empty($categoryPrmsO->ctyitemimage) ) $allParamsO->itemImage = $categoryPrmsO->ctyitemimage;	

		$allParamsO->climit = $categoryPrmsO->ctyclimit;

		$allParamsO->nlimit = $categoryPrmsO->ctynlimit;
		$allParamsO->showNoImage = ! $categoryPrmsO->ctyshowimage;

		$allParamsO->imageWidth = $categoryPrmsO->ctyimagewidth;

		$allParamsO->imageHeight = $categoryPrmsO->ctyimageheight;

		$allParamsO->showHeader = $categoryPrmsO->ctyshowcolumn;

		$allParamsO->pageID = $categoryPrmsO->ctypgid;

		$allParamsO->widgetSlug = 'category_subcategories';



		
		if ( !empty($categoryPrmsO->ctyremoteurl) && !empty($categoryPrmsO->ctyremotecatid) ) {

			$myTagText = '{widget:productcat';

			foreach( $categoryPrmsO as $prop => $val ) if ( !empty($val) ) $myTagText .= '|'.$prop.'='.$val;

			$myTagText .= '|remoteURL='.$categoryPrmsO->ctyremoteurl.'|parent='.$categoryPrmsO->ctyremotecatid.'}';

			$tagC = WClass::get('output.process');

			$tagC->replaceTags( $myTagText );

			$this->customContent = $myTagText;

			$this->addData( array( 'dummmy' ) );	
			if ( !empty($allParamsO->totalCount) ) $this->setTotalCount( $allParamsO->totalCount );



	
			
			


			return true;

		}


		
		$productCategoryLoadC = WClass::get( 'item.loadcategory' );

		$categoryA = $productCategoryLoadC->get( $allParamsO );



		if ( empty($categoryA) ) return false;




		
		if ( $categoryPrmsO->ctypagi ) {

			$startLimit = WGlobals::getUserState("wiev-$uniqueNameState-limitstart", 'limitstart'.$uniqueNameState, 0, 'int' );

			$pagiI = WView::pagination( $uniqueNameState, $allParamsO->totalCount, $startLimit, $allParamsO->nb, 0, 'Categories', 'category' );

			$pagiI->setFormName( $this->firstFormName );

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








	private function _loadItems() {



		
		$allParamsO = new stdClass;

		$allParamsO->themeType = 'node';	
		$allParamsO->nodeName = 'catalog';



		$itemPrmsO = $this->_itemPrmsO;

		
		if ( empty($itemPrmsO->itmitems) ) return false;



		$choicesorting = WGlobals::get( 'choicesorting' );



		$allParamsO->sorting = ( !empty($choicesorting) ) ? $choicesorting : $itemPrmsO->itmsorting;

		
		WGlobals::set( 'catItemsSorting', $allParamsO->sorting, 'global' );



		
		$joobiRun = 'return '.WPage::actionJavaScript( 'category', $this->firstFormName );

		$params = new stdClass;

		$params->map = 'choicesorting';	
		$dropdownPL = WView::picklist( 'catalog_category_items_sorting', $joobiRun, $params );

		$this->setValue( 'itemsPicklist', $dropdownPL->display() );



		$allParamsO->showSubCategory = $itemPrmsO->itmsubcat;





		
	




	
	
	
	
	
	
	
	


		$allParamsO->nb = $itemPrmsO->itmnbdisplay;



		$uniqueNameState = 'catalogCategoryItems' . $this->_catid;	


		
		if ( $itemPrmsO->itmpagi ) {	
			
			
			




			
			if ( empty($allParamsO->nb) ) $allParamsO->nb = 10;	
			elseif ( $allParamsO->nb > 1000 ) $allParamsO->nb = 1000;



						$catalogAdvFilterC = WClass::get( 'catalog.advfilter' );
			$uniqueNameState .= $catalogAdvFilterC->getUniqueString();

			
			$allParamsO->pagination = true;	
			$allParamsO->yid = $uniqueNameState;	



		}

				$allParamsO->borderShow = $itemPrmsO->itmbordershow;
		$allParamsO->borderColor = $itemPrmsO->itmbordercolor;	
		$allParamsO->getadvsearch = true;

		$allParamsO->layout = $itemPrmsO->itmlayout;

		$allParamsO->layoutname = $itemPrmsO->itmlayoutname;

		$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

		$allParamsO->carrouselArrow = 1;


		$allParamsO->layoutNbColumn = $itemPrmsO->itmlayoutcol;

		$allParamsO->display = $itemPrmsO->itmdisplay;



		$allParamsO->id = $itemPrmsO->itmpids;

		$allParamsO->search = $itemPrmsO->itmsearch;

		$allParamsO->prodtypid = $itemPrmsO->itmtype;



		$allParamsO->showNoName = ! $itemPrmsO->itmshowname;

		$allParamsO->dontShowFree = ! $itemPrmsO->itmshowfree;

		$allParamsO->showPrice = $itemPrmsO->itmshowprice;

		$allParamsO->showBid = $itemPrmsO->itmshowbid;
		$allParamsO->showcountdown = $itemPrmsO->itmshowcountdown;

		$allParamsO->showPreview = $itemPrmsO->itmshowpreview;

		$allParamsO->showIntro = $itemPrmsO->itmshowintro;

		$allParamsO->showDesc = $itemPrmsO->itmshowdesc;

		$allParamsO->showVendor = $itemPrmsO->itmshowvendor;

		$allParamsO->showQuestion = $itemPrmsO->itmshowquestion;

		$allParamsO->climit = $itemPrmsO->itmclimit;

		$allParamsO->nlimit = $itemPrmsO->itmnlimit;
		$allParamsO->addCart = $itemPrmsO->itmaddcart;

		$allParamsO->showNoRating = ! $itemPrmsO->itmshowrating;

		$allParamsO->showReview = $itemPrmsO->itmfeedback;

		$allParamsO->share = $itemPrmsO->itmshare;

		$allParamsO->showReadMore = $itemPrmsO->itmreadmore;

		$allParamsO->showNoImage = ! $itemPrmsO->itmshowimage;

		$allParamsO->imageWidth = $itemPrmsO->itmimagewidth;

		$allParamsO->imageHeight = $itemPrmsO->itmimageheight;

		$allParamsO->showHeader = $itemPrmsO->itmshowcolumn;

		$allParamsO->mouseOver = $itemPrmsO->itmmouseOver;

		$allParamsO->uniqueSection = $uniqueNameState;


		
		$allParamsO->category = $this->_catid;


		$allParamsO->widgetSlug = 'category_item';


		
		$productLoadC = WClass::get( 'item.load' );

		$productA = $productLoadC->get( $allParamsO );



		if ( empty($productA) ) {
			$productA = array( true );
	
			return '<span class="catalogItemEmpty">' . WText::t('1314356550DDJA') . '</span>';

		}


		
		if ( $itemPrmsO->itmpagi ) {

			$startLimit = WGlobals::getUserState("wiev-$uniqueNameState-limitstart", 'limitstart'.$uniqueNameState, 0, 'int' );

			$pagiI = WView::pagination( $uniqueNameState, $allParamsO->totalCount, $startLimit, $allParamsO->nb, 0, 'Items', 'category' );

			$pagiI->setFormName( $this->firstFormName );

			$this->_itemsPagination = $pagiI->getListFooter();

		}


		
		$productLoadC->extraProcess( $productA, $allParamsO );



		
		$outputThemeC = WClass::get( 'output.theme' );

		$outputThemeC->nodeName = 'catalog';

		$outputThemeC->header = $productLoadC->setHeader();



		return $outputThemeC->createLayout( $productA, $allParamsO );



	}












	private function _loadVendors() {



		$this->setValue( 'vendorTitle', WText::t('1220793715LTKS') );



		
		$allParamsO = new stdClass;

		$allParamsO->themeType = 'node';	
		$allParamsO->nodeName = 'catalog';



		
		$allParamsO->catid = $this->_catid;

		$allParamsO->smartVendor = true;



		$choicesorting = WGlobals::get( 'vendorsorting' );



		if ( $this->_useCustom ) {	
			
			if ( !$this->getValue('vdritems') ) return;

			WGlobals::set( 'categoryVendorsTitle', $this->getValue('vdrtitle'), 'global' );



			$allParamsO->sorting = ( !empty($choicesorting) ) ? $choicesorting : $this->getValue('vdrsorting');

						$allParamsO->borderShow = $this->getValue( 'vdrbordershow' );
			$allParamsO->borderColor = $this->getValue( 'vdrbordercolor' );	

			$allParamsO->layout = $this->getValue('vdrlayout');
			$allParamsO->layoutname = $this->getValue('vdrlayoutname');
			$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

			$allParamsO->carrouselArrow = 1;


			$allParamsO->layoutNbColumn = $this->getValue('vdrlayoutcol');
			$allParamsO->nb = $this->getValue('vdrnbdisplay');
			if ( empty($allParamsO->nb) || $allParamsO->nb > 100 ) $allParamsO->nb = 10;

			$allParamsO->display = $this->getValue('vdrdisplay');
			$allParamsO->showNoName = ! $this->getValue('vdrshowname');
			$allParamsO->showDesc = $this->getValue('vdrshowdesc');
			$allParamsO->showQuestion = $this->getValue('vdrshowquestion');
			$allParamsO->climit = $this->getValue('vdrclimit');
			$allParamsO->nlimit = $this->getValue('vdrnlimit');			$allParamsO->showRating = $this->getValue('vdrshowrating');
			$allParamsO->showReview = $this->getValue('vdrfeedback');
			$allParamsO->share = $this->getValue('vdrshare');
			$allParamsO->showNoImage = ! $this->getValue('vdrshowimage');
			$allParamsO->imageWidth = $this->getValue('vdrimagewidth');
			$allParamsO->imageHeight = $this->getValue('vdrimageheight');
			$allParamsO->showHeader = $this->getValue('vdrshowcolumn');
	
			$generalPageID = $this->getValue('catgenpgid');
			$itemPageID = $this->getValue('catalogpgidvendors');
			$allParamsO->pageID = (!empty( $itemPageID )) ? $itemPageID : ((!empty( $generalPageID )) ? $generalPageID : '');

			if ( empty($allParamsO->layout) ) $allParamsO->layout = 'badgemini';



		} else {

			
			if ( !PCATALOG_NODE_CATVDRITEMS ) return;

			WGlobals::set( 'categoryVendorsTitle', PCATALOG_NODE_CATVDRTITLE, 'global' );



			$allParamsO->sorting = ( !empty($choicesorting) ) ? $choicesorting : PCATALOG_NODE_CATVDRSORTING;


						$allParamsO->borderShow = PCATALOG_NODE_CATVDRBORDERSHOW;
			$allParamsO->borderColor = PCATALOG_NODE_CATVDRBORDERCOLOR;	

			$allParamsO->layout = PCATALOG_NODE_CATVDRLAYOUT;

			$allParamsO->layoutname = PCATALOG_NODE_CATVDRLAYOUTNAME;

			$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

			$allParamsO->carrouselArrow = 1;


			$allParamsO->layoutNbColumn = PCATALOG_NODE_CATVDRLAYOUTCOL;

			$allParamsO->nb = PCATALOG_NODE_CATVDRNBDISPLAY;

			if ( empty($allParamsO->nb) || $allParamsO->nb > 100 ) $allParamsO->nb = 10;

			$allParamsO->display = PCATALOG_NODE_CATVDRDISPLAY;

			$allParamsO->showNoName = ! PCATALOG_NODE_CATVDRSHOWNAME;

			$allParamsO->showDesc = PCATALOG_NODE_CATVDRSHOWDESC;

			$allParamsO->showQuestion = PCATALOG_NODE_CATVDRSHOWQUESTION;

			$allParamsO->climit = PCATALOG_NODE_CATVDRCLIMIT;

			$allParamsO->nlimit = PCATALOG_NODE_CATVDRNLIMIT;
			$allParamsO->showRating = PCATALOG_NODE_CATVDRSHOWRATING;

			$allParamsO->showReview = PCATALOG_NODE_CATVDRFEEDBACK;

			$allParamsO->share = PCATALOG_NODE_CATVDRSHARE;

			$allParamsO->showNoImage = ! PCATALOG_NODE_CATVDRSHOWIMAGE;

			$allParamsO->imageWidth = PCATALOG_NODE_CATVDRIMAGEWIDTH;

			$allParamsO->imageHeight = PCATALOG_NODE_CATVDRIMAGEHEIGHT;

			$allParamsO->showHeader = PCATALOG_NODE_CATVDRSHOWCOLUMN;

	
			$generalPageID = PCATALOG_NODE_CATALOGPGIDGENERAL;

			$itemPageID = PCATALOG_NODE_VDRCATALOGPGIDVENDORS;

			$allParamsO->pageID = (!empty( $itemPageID )) ? $itemPageID : ((!empty( $generalPageID )) ? $generalPageID : '');

			if ( empty($allParamsO->layout) ) $allParamsO->layout = 'badgemini';



		}


		
		$vendorsLoadC = WClass::get( 'vendors.load' );

		$vendorsA = $vendorsLoadC->get( $allParamsO );



		
		$vendorsLoadC->extraProcess( $vendorsA, $allParamsO );



		
		$outputThemeC = WClass::get( 'output.theme' );

		$outputThemeC->nodeName = 'catalog';

		$outputThemeC->layoutPrefix = 'vendor';

		$outputThemeC->header = $vendorsLoadC->setHeader();



		$displayVendors = $outputThemeC->createLayout( $vendorsA, $allParamsO );






		$this->setValue( 'vendors', $displayVendors );



	}


private function _createCarrousel() {



	
	$allParamsO = new stdClass;

	$allParamsO->themeType = 'node';	
	$allParamsO->nodeName = 'catalog';



	
	$allParamsO->category = $this->_catid;



	if ( $this->_useCustom ) {	


		$allParamsO->showSubCategory = $this->getValue('catcrslsubcat');

		$allParamsO->prodtypid = $this->getValue('catcrsltype'); 


		$allParamsO->sorting = $this->getValue('catcrslsorting');	
		$allParamsO->id = $this->getValue('catcrslpids');	
		$allParamsO->search = $this->getValue('catcrslsearch');	
		$itemTypeH = $this->getValue('catcrsltype');

		if ( !empty($this->_categoryType) ) {

			$allParamsO->prodtypid = $this->_categoryType;

		} elseif ( !empty( $itemTypeH ) ) {

			$allParamsO->prodtypid = $itemTypeH;

		}

				$allParamsO->borderShow = $this->getValue( 'catcrslbordershow' );
		$allParamsO->borderColor = $this->getValue( 'catcrslbordercolor' );	

		$allParamsO->layout = $this->getValue('catcrsllayout');	
		$allParamsO->layoutname = $this->getValue('catcrsllayoutname');	
		$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

		$allParamsO->carrouselArrow = 1;


		$allParamsO->nb = $this->getValue('catcrslnbdisplay');	
		if ( empty($allParamsO->nb) || $allParamsO->nb > 100 ) $allParamsO->nb = 10;

		$allParamsO->display = $this->getValue('catcrsldisplay');	
		$allParamsO->showNoName = ! $this->getValue('catcrslshowname');	
		$allParamsO->dontShowFree = ! $this->getValue('catcrslshowfree');	
		$allParamsO->showPrice = $this->getValue('catcrslshowprice');	
		$allParamsO->showBid = $this->getValue('catcrslshowbid');			$allParamsO->showcountdown = $this->getValue('catcrslshowcountdown');
		$allParamsO->showPreview = $this->getValue('catcrslshowpreview');	
		$allParamsO->showIntro = $this->getValue('catcrslshowintro');	
		$allParamsO->showDesc = $this->getValue('catcrslshowdesc');	
		$allParamsO->showVendor = $this->getValue('catcrslshowvendor');	
		$allParamsO->showQuestion = $this->getValue('catcrslshowquestion');	
		$allParamsO->climit = $this->getValue('catcrslclimit');	
		$allParamsO->nlimit = $this->getValue('catcrslnlimit');			$allParamsO->addCart = $this->getValue('catcrsladdcart');	
		$allParamsO->showNoRating = ! $this->getValue('catcrslshowrating');	
		$allParamsO->showReview = $this->getValue('catcrslfeedback');	
		$allParamsO->share = $this->getValue('catcrslshare');	
		$allParamsO->showReadMore = $this->getValue('catcrslreadmore');	
		$allParamsO->showNoImage = ! $this->getValue('catcrslshowimage');	
		$allParamsO->imageWidth = $this->getValue('catcrslimagewidth');	
		$allParamsO->imageHeight = $this->getValue('catcrslimageheight');	
		$generalPageID = $this->getValue('catgenpgid');
		$itemPageID = $this->getValue('catcrslpgid');
		$allParamsO->pageID = (!empty( $itemPageID )) ? $itemPageID : ((!empty( $generalPageID )) ? $generalPageID : '');



		if ( $allParamsO->display == 'standard' ) $allParamsO->display = 'accordion-horizontal';



		if ( empty($allParamsO->layout) ) $allParamsO->layout = 'badgemini';


		$allParamsO->widgetSlug = 'category_carrousel';


		
		$productLoadC = WClass::get( 'item.load' );

		$productA = $productLoadC->get( $allParamsO );



		if ( empty($productA) ) return true;



		
		$productLoadC->extraProcess( $productA, $allParamsO );



		
		$outputThemeC = WClass::get( 'output.theme' );

		$outputThemeC->nodeName = 'catalog';

		$outputThemeC->header = $productLoadC->setHeader();



		$displayCarrousel = $outputThemeC->createLayout( $productA, $allParamsO );

		$this->setValue( 'carrousel', $displayCarrousel );



	} else {



		$allParamsO->showSubCategory = PCATALOG_NODE_CATCRSLSUBCAT; 
		$allParamsO->prodtypid = PCATALOG_NODE_CATCRSLTYPE; 

				$allParamsO->borderShow = PCATALOG_NODE_CATCRSLBORDERSHOW;
		$allParamsO->borderColor = PCATALOG_NODE_CATCRSLBORDERCOLOR;



		$allParamsO->sorting = PCATALOG_NODE_CATCRSLSORTING;

		$allParamsO->id = PCATALOG_NODE_CATCRSLPIDS;

		$allParamsO->search = PCATALOG_NODE_CATCRSLSEARCH;

		if ( !empty($this->_categoryType) ) {

			$allParamsO->prodtypid = $this->_categoryType;

		} elseif ( PCATALOG_NODE_CATCRSLTYPE ) {

			$allParamsO->prodtypid = PCATALOG_NODE_CATCRSLTYPE;

		}
		$allParamsO->layout = PCATALOG_NODE_CATCRSLLAYOUT;

		$allParamsO->layoutname = PCATALOG_NODE_CRSLLAYOUTNAME;

		$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );

		$allParamsO->carrouselArrow = 1;


		$allParamsO->nb = PCATALOG_NODE_CATCRSLNBDISPLAY;

		if ( empty($allParamsO->nb) || $allParamsO->nb > 100 ) $allParamsO->nb = 10;

		$allParamsO->display = PCATALOG_NODE_CATCRSLDISPLAY;

		$allParamsO->showNoName = ! PCATALOG_NODE_CATCRSLSHOWNAME;

		$allParamsO->dontShowFree = ! PCATALOG_NODE_CATCRSLSHOWFREE;

		$allParamsO->showPrice = PCATALOG_NODE_CATCRSLSHOWPRICE;

		$allParamsO->showBid = PCATALOG_NODE_CATCRSLSHOWBID;
		$allParamsO->showcountdown = PCATALOG_NODE_CATCRSLSHOWCOUNTDOWN;
		$allParamsO->showPreview = PCATALOG_NODE_CATCRSLSHOWPREVIEW;

		$allParamsO->showIntro = PCATALOG_NODE_CATCRSLSHOWINTRO;

		$allParamsO->showDesc = PCATALOG_NODE_CATCRSLSHOWDESC;

		$allParamsO->showVendor = PCATALOG_NODE_CATCRSLSHOWVENDOR;

		$allParamsO->showQuestion = PCATALOG_NODE_CATCRSLSHOWQUESTION;

		$allParamsO->climit = PCATALOG_NODE_CATCRSLCLIMIT;

		$allParamsO->nlimit = PCATALOG_NODE_CATCRSLNLIMIT;
		$allParamsO->addCart = PCATALOG_NODE_CATCRSLADDCART;

		$allParamsO->showNoRating = ! PCATALOG_NODE_CATCRSLSHOWRATING;

		$allParamsO->showReview = PCATALOG_NODE_CATCRSLFEEDBACK;

		$allParamsO->showReadMore = PCATALOG_NODE_CATCRSLREADMORE;

		$allParamsO->share = PCATALOG_NODE_CATCRSLSHARE;

		$allParamsO->showNoImage = ! PCATALOG_NODE_CATCRSLSHOWIMAGE;

		$allParamsO->imageWidth = PCATALOG_NODE_CATCRSLIMAGEWIDTH;

		$allParamsO->imageHeight = PCATALOG_NODE_CATCRSLIMAGEHEIGHT;

		$generalPageID = PCATALOG_NODE_CATEGORYPGIDGENERAL;

		$itemPageID = PCATALOG_NODE_CATEGORYPGIDCAROUSEL;

		$allParamsO->pageID = (!empty( $itemPageID )) ? $itemPageID : ((!empty( $generalPageID )) ? $generalPageID : '');


		if ( $allParamsO->display == 'standard' ) $allParamsO->display = 'accordion-horizontal';


		$allParamsO->widgetSlug = 'category_carrousel';


		
		$productLoadC = WClass::get( 'item.load' );

		$productA = $productLoadC->get( $allParamsO );



		if ( empty($productA) ) return true;



		
		$productLoadC->extraProcess( $productA, $allParamsO );



		
		$outputThemeC = WClass::get( 'output.theme' );

		$outputThemeC->nodeName = 'catalog';

		$outputThemeC->header = $productLoadC->setHeader();



		$displayCarrousel = $outputThemeC->createLayout( $productA, $allParamsO );

		$this->setValue( 'carrousel', $displayCarrousel );



	}


}














private function _countSubCategory() {

	
	if ( empty( $this->_catid ) ) return false;



	
	
	static $resultA = array();

	if ( !isset( $resultA[$this->_catid] ) ) {

		static $categoryM = null;

		if ( empty( $categoryM ) ) $categoryM = WModel::get( 'item.category' );


		$categoryM->select( 'catid', 0, null, 'count' );

		$categoryM->whereE( 'parent', $this->_catid );

		$categoryM->whereE( 'publish', 1 );

		$categoryM->checkAccess();

		$coutnStandard = $categoryM->load( 'lr' );

		$multipleParent = WPref::load( 'PITEM_NODE_MULTIPLEPARENT' );
		if ( !empty($multipleParent) ) {
			$categoryParentM = WModel::get( 'item.categoryparent' );
			$categoryParentM->select( 'catidparent', 0, null, 'count' );
			$categoryParentM->whereE( 'catid', $this->_catid );
			$coutnParent = $categoryParentM->load( 'lr' );

		} else {
			$coutnParent = 0;
		}
		$resultA[$this->_catid] = $coutnStandard + $coutnParent;

	}


	$count = isset( $resultA[$this->_catid] ) ? $resultA[$this->_catid] : 0;



	$this->setValue( 'subcategoryCount', $count );

	$this->_subcategoryCount = $count;



	$catTitle = $count > 1 ? WText::t('1304526973ACEV') : WText::t('1340850244HVHU');

	$this->setValue( 'subCategoryTitle', $catTitle );



	return true;


}














	protected function _processList() {



		
		if ( empty( $this->_catid ) ) return false;



		$wishlistGetcountC = WClass::get( 'wishlist.getcount' );

		$typeA = $wishlistGetcountC->countItemTypes( $this->_catid, 'category' );

		foreach( $typeA as $name => $value ) {

			$this->setValue( $name, $value );

		}


		return true;



	}}