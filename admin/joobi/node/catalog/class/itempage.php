<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Itempage_class extends WClasses {

	private $_itemsRelatedPagination = null;










	public function setupItemInformation(&$pageO,$itemTypeInfoO,$onlySyndication=true) {

		WGlobals::set( 'vendorIdFromItem', $pageO->getValue( 'vendid' ) , 'global' );

	if ( !defined('PCATALOG_NODE_PAGEPRDSHOWLIKE') ) WPref::get( 'catalog.node' );

		$itemGeneralPref = array(
	'showViews' => 'pageprdshowviews',
	'showLike' => 'pageprdshowlike',
	'showTweet' => 'pageprdshowtweet',
	'showBuzz' => 'pageprdshowbuzz',
	'showShareThis' => 'pageprdshowsharethis',
	'showFavorite' => 'pageprdshowfavorite',
	'showWatch' => 'pageprdshowwatch',
	'showWish' => 'pageprdshowwish',
	'showLikeDislike' => 'pageprdshowlikedislike',
	'showShareWall' => 'pageprdshowsharewall',
	'showPrint' => 'pageprdshowprint',
	'showEmail' => 'pageprdshowemail',
	'showImage' => 'pageprdshowimage',

	'borderShow' => 'pageprdbordershow',
	'borderColor' => 'pageprdbordercolor',

	'pageprdimagewidth' => 'pageprdimagewidth',
	'pageprdimageheight' => 'pageprdimageheight',

	'showPreview' => 'pageprdshowpreview',
	'showIntro' => 'pageprdshowintro',
	'showPromo' => 'pageprdshowpromo',
	'showDesc' => 'pageprdshowdesc',
	'showPrice' => 'pageprdprice',
	'showQuantity' => 'pageprdquantity',
	'showStock' => 'pageprdstock',
	'showCartButton' => 'pageprdcartbtn',
	'showVendor' => 'pageprdvendor',
	'showVendorRating' => 'pageprdvendorating',
	'showAskQuestion' => 'pageprdaskquestion',
	'allowReview' => 'pageprdallowreview',
	'showRating' => 'pageprdshowrating',
	'showMap' => 'pageprdshowmap',
	'showMapWidth' => 'pageprdmapwidth',
	'showMapHeight' => 'pageprdmapheight',
	'showMapStreet' => 'pageprdshowmapstreet'

	);

	$pageParams = new stdClass;
	foreach( $itemGeneralPref as $pageProperty => $parameterProperty ) {
		$pageParams->$pageProperty = $pageO->getValue( $parameterProperty );
		if ( $pageParams->$pageProperty == 5 ) $pageParams->$pageProperty = ( !empty($itemTypeInfoO->$parameterProperty) ? $itemTypeInfoO->$parameterProperty : '' );
		$constantName = 'PCATALOG_NODE_' . strtoupper($parameterProperty);
		if ( $pageParams->$pageProperty == 2 ) $pageParams->$pageProperty = constant($constantName);
	}

	$pageCSS = '';
	$pageParams->cssclass = $pageO->getValue('cssclass');
	if ( !empty($itemTypeInfoO->cssclass) ) $pageCSS .= ' ' . $itemTypeInfoO->cssclass;
	if ( !empty($pageParams->cssclass) ) $pageCSS .= ' ' . $pageParams->cssclass;
	$pageParams->cssclass = $pageCSS;

	$pageParams->pageID = $pageO->getValue('pageprdpgid');		if ( empty($pageParams->pageID) ) $pageParams->pageID =  ( !empty($itemTypeInfoO->pageprdpgid) ) ? $itemTypeInfoO->pageprdpgid : '';		if ( empty($pageParams->pageID) ) $pageParams->pageID = PCATALOG_NODE_PAGEPRDPGID;

		$definedImgWidth = ( empty($pageParams->pageprdimagewidth) ? ( empty($itemTypeInfoO->pageprdimagewidth) ? PCATALOG_NODE_PAGEPRDIMAGEWIDTH : $itemTypeInfoO->pageprdimagewidth ) : $pageParams->pageprdimagewidth );
	$definedImgHeight = ( empty($pageParams->pageprdimageheight) ? ( empty($itemTypeInfoO->pageprdimageheight) ? PCATALOG_NODE_PAGEPRDIMAGEHEIGHT : $itemTypeInfoO->pageprdimageheight ) : $pageParams->pageprdimageheight );
	if (!empty($definedImgWidth) ) WGlobals::set( 'maxImageWidth', $definedImgWidth );
	if (!empty($definedImgHeight) ) WGlobals::set( 'maxImageHeight', $definedImgHeight );

	if ( ! WPref::load( 'PITEM_NODE_PROMOMESSAGE' ) ) $pageParams->showPromo = false;

	WGlobals::set( 'itemPageMain', $pageParams, 'global' );

	$useCustom = $pageO->getValue( 'prdgeneral' );
	if ( $useCustom == 5 ) {
		if ( !empty($itemTypeInfoO->prdgeneral) ) $uselCustomType = 'type';
		else $uselCustomType = 'general';
	} elseif ( !empty($useCustom) ) {
				$uselCustomType = 'item';
	} else {
		$uselCustomType = 'general';
	}
	$this->_itemSectionPref = array( 'items','title','type','sorting','display','nbdisplay','pagi',
	'layout','layoutcol','layoutname','showname','showintro','showdesc','climit','nlimit','showpreview',
	'showprice','showbid','showfree','addcart','showrating','showvendor','showquestion','share',
	'showimage','imagewidth','imageheight','showcolumn','readmore', 'showcountdown' );	
	switch( $uselCustomType ) {
		case 'item':
			WGlobals::set( 'listItemsSorting', $pageO->getValue('prdavailsort'), 'global' );
						$this->_processSectionItemPref( 'itemPageRelated', 'prd', $uselCustomType, $pageO, $itemTypeInfoO );
			$this->_processSectionItemPref( 'itemPageBundle', 'bdl', $uselCustomType, $pageO, $itemTypeInfoO );
			break;
		case 'type':
			$prdavailsort = !empty($itemTypeInfoO->prdavailsort) ? $itemTypeInfoO->prdavailsort : '';
			WGlobals::set( 'listItemsSorting', $prdavailsort, 'global' );
			$this->_processSectionItemPref( 'itemPageRelated', 'prd', $uselCustomType, $pageO, $itemTypeInfoO );
			$this->_processSectionItemPref( 'itemPageBundle', 'bdl', $uselCustomType, $pageO, $itemTypeInfoO );
			break;
		default:
		case 'general':
			WGlobals::set( 'listItemsSorting', PCATALOG_NODE_PRDAVAILSORT, 'global' );
			$this->_processSectionItemPref( 'itemPageRelated', 'prd', $uselCustomType, $pageO, $itemTypeInfoO );
			$this->_processSectionItemPref( 'itemPageBundle', 'bdl', $uselCustomType, $pageO, $itemTypeInfoO );
			break;
	}
		$vendorHelperC = WClass::get('vendor.helper',null,'class',false);
	$uid = WUser::get('uid');
	$vendid = $vendorHelperC->getVendorID( $uid );

	if ( !empty($vendid) ) {
		$this->_processSyndication( $pageO, $itemTypeInfoO, 'syndication' );
		if (!$onlySyndication) $this->_processSyndication( $pageO, $itemTypeInfoO, 'resellers' );
	}
	return $pageParams;

}






public function setShippingMethod(&$page,$shippingMethod) {

	switch( $shippingMethod ) {
		case 3:					$page->setValue( 'shippingMessage', WText::t('1328998982ELSR') );
			break;
		case 7:					$page->setValue( 'shippingMessage', WText::t('1330393750MKNF') );
			break;

	}
}







public function askQuestion($vendid,$text='askquestion') {

	if ( empty($vendid) ) return false;

	$ask = WPref::load( 'PVENDOR_NODE_ASKQUESTION' );
	$registered = WUser::get('uid');
	$popup = false; 
	$vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );
	$vendObj = $vendorHelperC->getVendor( $vendid );

	if ( empty($vendObj) ) return '';

	$objButtonO = WPage::newBluePrint( 'prefcatalog' );
	$objButtonO->type = 'buttonQuestionInCatalogPage';
	$objButtonO->icon = 'fa-question-circle';

	if ( !$registered ) { 	
		$questionLink =  WPage::link('controller=users&task=login' );
		if ( $text=='askquestion' ) {
			$textHTML = WText::t('1304526870NAKE');				$objButtonO->icon = 'fa-question-circle';
		} elseif ( 'contactus4price' == $text ) {				$textHTML = WText::t('1317275062QZVL');
			$objButtonO->icon = 'fa-envelope';
		} else {				$textHTML = WText::t('1206732392OZUV');
			$objButtonO->icon = 'fa-envelope';
		}
	}elseif ( !empty( $vendObj->uid ) && $registered == $vendObj->uid ) {		$questionLink =  WPage::linkPopUp('controller=vendor-inbox&task=listing' );
		$popup = true;
		$textHTML = WText::t('1307083039FLMV');
		$objButtonO->icon = 'fa-inbox';
	} else {

		if ( $text=='askquestion' ) {
			$textHTML = WText::t('1304526870NAKE');
			$objButtonO->icon = 'fa-question-circle';
		} else {
			$textHTML = WText::t('1206732392OZUV');
			$objButtonO->icon = 'fa-envelope';
		}
		switch( $ask ) {
			case 'jtickets':
			case 'jticketsmessage': 				$questionLink =  WPage::routeURL( 'controller=ticket&task=add','','popup', null, true, 'jtickets' );
				$popup = true;
				break;
			case 'email':
			case 'emailmessage': 				$questionLink =  'mailto:'.$vendObj->email;
				break;
			case 'jomsocial':
			case 'jomsocialmessage': 								$jomsocialMessageM = WClass::get( 'jomsocial.messaging' );
				if ( !empty($jomsocialMessageM) ) {
					return $jomsocialMessageM->askQuestion( $textHTML, $vendObj->uid );
					break;
									}				break;
			case 'jmarket':
			case 'internalmessage':				default: 				$questionLink =  WPage::linkPopUp('controller=vendor-inbox&task=createmessage&uid='.$vendObj->uid );
				$popup = true;
				break;

		}
	}
	$objButtonO->popUpIs = $popup;		$objButtonO->popUpWidth = '80%';
	$objButtonO->popUpHeight = '80%';
	$objButtonO->link = $questionLink;
	$objButtonO->text = $textHTML;
	$objButtonO->color = 'info';

	$html = WPage::renderBluePrint( 'prefcatalog', $objButtonO );	
	return $html;

}







public function handlePageID($pageID,$pid) {

	if ( !empty($pageID) ) {
		$cmsPage = WPage::cmsGetItemId();
		if ( $pageID != $cmsPage ) {
			$catid = WGlobals::get( 'catid' );
			$catid = !empty( $catid ) ? '&catid='.$catid : '';
						WPages::redirect( 'controller=catalog&task=show&eid='. $pid . $catid, $pageID );
		}	}
}





	public function getTerms($itemTypeInfoO,$pageO) {

		$propertyYesNoA = array( 'termsshowlicense', 'termsshowrefund', 'termsrefundallowed', 'termsshowrefundperiod' );
		$propertyOtherA = array( 'termslicense', 'termsrefund', 'termsrefundperiod' );

		$terms = new stdClass;
		foreach( $propertyYesNoA as $property ) {

			$terms->$property = $pageO->getValue( $property );
						if ( empty($terms->$property) || $terms->$property == 1 ) continue;

						if ( $terms->$property == 5 ) {
				$terms->$property = !empty($itemTypeInfoO->$property) ? $itemTypeInfoO->$property : 0;
			}
			if ( $terms->$property == 2 ) $terms->$property = constant( 'PCATALOG_NODE_' . strtoupper( $property ) );

		}
		foreach( $propertyOtherA as $property ) {

			$terms->$property = $pageO->getValue( $property );

						if ( empty($terms->$property) ) continue;

						if ( $terms->$property == 'type' ) {
				$terms->$property = !empty($itemTypeInfoO->$property) ? $itemTypeInfoO->$property : '';
			}
			if ( $terms->$property == 'general' ) $terms->$property = constant( 'PCATALOG_NODE_' . strtoupper( $property ) );

		}

				if ( !empty($terms->termsshowlicense) && !empty($terms->termslicense) ) {
			$licenseTermsHTML = $this->getTermsHTML( $terms->termslicense );
			$pageO->setContent( 'liceneAgreement', $licenseTermsHTML );
		}
				if ( !empty($terms->termsrefundallowed) && !empty($terms->termsshowrefund) && !empty($terms->termsrefund) ) {
			$refundTermsHTML = $this->getTermsHTML( $terms->termsrefund );
			$pageO->setContent( 'refundPolicy', $refundTermsHTML );
		}
				if ( !empty($terms->termsshowrefundperiod) ) {

			if ( empty($terms->termsrefundperiod) ) {
				if ( !empty($itemTypeInfoO->termsrefundperiod) ) {
					$refundPeriodHTML = $itemTypeInfoO->termsrefundperiod . ' ' . WText::t('1310465461SODW');
				} else {
					$termsrefundperiod = WPref::load( 'PCATALOG_NODE_TERMSREFUNDPERIOD' );
					if ( !empty($termsrefundperiod) ) {
						$refundPeriodHTML = $termsrefundperiod . ' ' . WText::t('1310465461SODW');
					} else {
						
						$refundPeriodHTML = WText::t('1398811857OWHA');
					}
				}
			} else {
				$refundPeriodHTML = $terms->termsrefundperiod . ' ' . WText::t('1310465461SODW');
			}
			$pageO->setContent( 'refundPeriod', $refundPeriodHTML );

		} else {
			if ( !empty($terms->termsshowrefund) ) {
				if ( empty($terms->termsrefundallowed) ) $pageO->setContent( 'refundPeriod', WText::t('1310465461SODV') );
				else {
					$pageO->setContent( 'refundPeriod', WText::t('1398811857OWHB') );
				}			}		}
	}






public function showRelatedItems($itemPrmsO,$relatedPID,$firstFormName) {

		$allParamsO = new stdClass;
	$allParamsO->themeType = 'node';		$allParamsO->nodeName = 'catalog';
	$allParamsO->widgetSlug = 'catalog_item_related';

	$choicesorting = WGlobals::get( 'choicesorting' );

	$allParamsO->prodtypid = $itemPrmsO->prdtype;

	$allParamsO->sorting = ( !empty($choicesorting) ) ? $choicesorting : $itemPrmsO->prdsorting;
		WGlobals::set( 'homeItemsSorting', $allParamsO->sorting, 'global' );

	$uniqueNameState = 'catalogItemsRelated' . $relatedPID;

		if ( $itemPrmsO->prdpagi ) {	
						if ( empty($relatedPID) ) $relatedPID = 0;

		$allParamsO->relatedPID = $relatedPID;

		$allParamsO->nb = $itemPrmsO->prdnbdisplay;				if ( empty($allParamsO->nb) ) $allParamsO->nb = 10;			elseif ( $allParamsO->nb > 500 ) $allParamsO->nb = 500;

				$allParamsO->pagination = true;			$allParamsO->yid = $uniqueNameState;		}

	$allParamsO->layout = $itemPrmsO->prdlayout;
	$allParamsO->layoutname = $itemPrmsO->prdlayoutname;
	$allParamsO->layout = trim( ( !empty($allParamsO->layoutname) ) ? $allParamsO->layoutname : $allParamsO->layout );
	$allParamsO->layoutNbColumn = $itemPrmsO->prdlayoutcol;

	$allParamsO->carrouselArrow = 1;

	$allParamsO->nb = $itemPrmsO->prdnbdisplay;
	if ( empty($allParamsO->nb) || $allParamsO->nb > 200 ) $allParamsO->nb = 10;
	$allParamsO->display = $itemPrmsO->prddisplay;

	$allParamsO->showNoName = ! $itemPrmsO->prdshowname;
	$allParamsO->showIntro = $itemPrmsO->prdshowintro;
	if ( WPref::load( 'PITEM_NODE_PROMOMESSAGE' ) && !empty($itemPrmsO->prdshowpromo) ) $allParamsO->showPromo = $itemPrmsO->prdshowpromo;
	else $allParamsO->showPromo = false;
	$allParamsO->showDesc = $itemPrmsO->prdshowdesc;
	$allParamsO->climit = $itemPrmsO->prdclimit;
	$allParamsO->nlimit = $itemPrmsO->prdnlimit;

	$allParamsO->showPreview = $itemPrmsO->prdshowpreview;
	$allParamsO->showPrice = $itemPrmsO->prdshowprice;
	if (!empty($itemPrmsO->prdshowbid) ) $allParamsO->showBid = $itemPrmsO->prdshowbid;
	if (!empty($itemPrmsO->prdshowcountdown) ) $allParamsO->showcountdown = $itemPrmsO->prdshowcountdown;
	$allParamsO->dontShowFree = ! $itemPrmsO->prdshowfree;
	$allParamsO->addCart = $itemPrmsO->prdaddcart;

	$allParamsO->showNoRating = ! $itemPrmsO->prdshowrating;
	if (!empty($itemPrmsO->prdfeedback) ) $allParamsO->showReview = $itemPrmsO->prdfeedback;
	$allParamsO->showVendor = @$itemPrmsO->prdshowvendor;
	$allParamsO->showQuestion = @$itemPrmsO->prdshowquestion;
	$allParamsO->showReadMore = @$itemPrmsO->prdreadmore;
	$allParamsO->share = @$itemPrmsO->prdshare;
	$allParamsO->mouseOver = @$itemPrmsO->prdmouseover;

	$allParamsO->showNoImage = ! $itemPrmsO->prdshowimage;
	$allParamsO->imageWidth = $itemPrmsO->prdimagewidth;
	$allParamsO->imageHeight = $itemPrmsO->prdimageheight;
	$allParamsO->showHeader = $itemPrmsO->prdshowcolumn;
	$allParamsO->relatedPID = $relatedPID;
		$productLoadC = WClass::get( 'item.load' );
	$productA = $productLoadC->get( $allParamsO );
	if ( empty($productA) ) return false;

		if ( $itemPrmsO->prdpagi ) {
		$startLimit = WGlobals::getUserState("wiev- $allParamsO->yid-limitstart", 'limitstart'. $allParamsO->yid, 0, 'int' );
		$pagiI = WView::pagination(  $allParamsO->yid, $allParamsO->totalCount, $startLimit, $allParamsO->nb, 0, 'RelatedItems', 'show' );
		$pagiI->setFormName( $firstFormName );
		$this->_itemsRelatedPagination = $pagiI->getListFooter();
	}
		$productLoadC->extraProcess( $productA, $allParamsO );

		$outputThemeC = WClass::get( 'output.theme' );
	$outputThemeC->nodeName = 'catalog';
	$outputThemeC->header = $productLoadC->setHeader();


	return $outputThemeC->createLayout( $productA, $allParamsO );

}
public function paginationRelatedItems() {
	return $this->_itemsRelatedPagination;
}











private function _processSyndication($obj,$itemTypeInfoO,$typeSynd='syndication') {

	$constantName = 'PCATALOG_NODE_ALLOW' . strtoupper($typeSynd);
	$constantValue = constant( $constantName );
	$propertyName = 'allow'.$typeSynd;

		if ( $constantValue ) {			$syndicateButton = false;
		if ( $constantValue == 1 ) $syndicateButton = true;
		else {
			$tempSyndicate = $constantValue;
			if ( $constantValue == 5 && !empty($itemTypeInfoO->$propertyName) ) {					if ( $itemTypeInfoO->$propertyName == 1 ) $syndicateButton = true;
				else {
					$tempSyndicate = $itemTypeInfoO->$propertyName;
				}			}
			if ( $tempSyndicate == 23 ) {									$vendorHelperC = WClass::get('vendor.helper');
				$vendorO = $vendorHelperC->getVendor( $obj->getValue( 'vendid' ) );
				$vendorSyndicate = !empty($vendorO->$propertyName) ? $vendorO->$propertyName : 0;
				if ( $vendorSyndicate == 1 )  $syndicateButton = true;
				else $tempSyndicate = $vendorSyndicate;
			}
			if ( $tempSyndicate == 12 ) {					$syndicateButton = $obj->getValue( $propertyName );
			}
		}
				if ( $syndicateButton ) {
			$pid = $obj->getValue('pid');
			if ( 'syndication' == $typeSynd ) {
				$obj->setValue( 'syndicationText', WText::t('1314356540SWBD') );

				$buttonO = WPage::newBluePrint( 'button' );
				$buttonO->type = 'infoLink';
				$buttonO->text = WText::t('1314356540SWBD');
				$buttonO->icon = 'fa-crosshairs';
				$buttonO->color = 'warning';
				$buttonO->popUpIs = true;
				$buttonO->popUpWidth = '500px';
				$buttonO->popUpHeight = '300px';
				$buttonO->link = WPage::linkPopUp( 'controller=catalog&task=syndicatechoice&eid=' . $pid );
				$syndicateLink = WPage::renderBluePrint( 'button', $buttonO );

				$obj->setValue( 'syndicateLink', $syndicateLink );

								$obj->setValue( 'syndicationLink', WPage::linkPopUp( 'controller=catalog&task=syndicatechoice&eid=' . $pid ) );
			} else {
				$obj->setValue( 'resellersText', WText::t('1314356541MEMH') );
				$obj->setValue( 'resellersLink', WPage::link( 'controller=catalog&task=resellers&eid='.$pid ) );
			}		}
	}}






public function getTermsHTML($termid) {

	$itemTermsM = WModel::get( 'item.terms' );
	$itemTermsM->makeLJ( 'item.termstrans', 'termid' );
	$itemTermsM->whereLanguage();
	$itemTermsM->select( 'name', 1 );
	$itemTermsM->whereE( 'termid', $termid );
	$itemTermsM->whereE( 'publish', 1 );
	$termsInfoO = $itemTermsM->load( 'o', array('url', 'type') );

	if ( empty($termsInfoO) ) return '';

		switch( $termsInfoO->type ) {
		case 2:
			$text = WText::t('1341517732AHOH');
			break;
		case 3:
			$text = WText::t('1310465461SODX');
			break;
		case 1:
		case 4:
		default:
			$text = WText::t('1310465461SODY');
			break;
	}
	$link = WPage::routeURL( 'controller=catalog&task=terms&eid='. $termid . '&titleheader=' . $termsInfoO->name, 'smart', 'popup' );
	$linkHTML = WPage::createPopUpLink( $link, $termsInfoO->name, 900, 550 );	
	$html = '<div class="control-group">
<label class="control-label">
<span>' . $text . '</span>
</label>
<div class="controls">
<span>' . $linkHTML . '</span>
</div>
</div>';
	return $html;

	return  $text . ': ' . WPage::createPopUpLink( $link, $termsInfoO->name, 900, 550, 'smallQuestionLeft' );

}









	private function _processSectionItemPref($globalLocation,$prefix,$uselCustomType,$pageO,$itemTypeInfoO) {
		$params = new stdClass;
		switch( $uselCustomType ) {
			case 'item':
				foreach( $this->_itemSectionPref as $sectionElm ) {
					$name = $prefix.$sectionElm;
					$params->$name = $pageO->getValue( $name );
				}				break;
			case 'type':
				foreach( $this->_itemSectionPref as $sectionElm ) {
					$name = $prefix.$sectionElm;
					$params->$name = !empty($itemTypeInfoO->$name) ? $itemTypeInfoO->$name : '';
				}				break;
			default:
			case 'general':
				foreach( $this->_itemSectionPref as $sectionElm ) {
					$constantName = 'PCATALOG_NODE_' . strtoupper($prefix.$sectionElm);
					$keyProp = $prefix.$sectionElm;
					if (defined($constantName) ) $params->$keyProp = constant($constantName);
				}				break;
		}

				WGlobals::set( $globalLocation, $params, 'global' );


	}

}