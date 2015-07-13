<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_CoreItem_module extends WModule {


function create() {


	WPage::addCSSFile( 'node/catalog/css/style.css' );


	$tag = '{widget:item';

	if ( !empty( $this->type ) ) $tag .= '|prodtypid=' . $this->type;

	if ( !empty( $this->sorting ) ) $tag .= '|sorting=' . $this->sorting;



	if ( !empty( $this->share ) ) {

		$this->share = str_replace( ' ', '', $this->share );

		$tag .= '|share=' . $this->share;

	}
	if ( !empty( $this->prodids ) ) {

		$this->prodids = str_replace( ' ', '', $this->prodids );

		$tag .= '|id=' . $this->prodids;

	}


	if ( !empty( $this->search ) ) $tag .= '|search=' . $this->search;

	if ( !empty( $this->carrouselarrow ) ) $tag .= '|carrouselArrow=' . $this->carrouselarrow;

	if ( !empty( $this->advsearchfilter ) ) $tag .= '|getadvsearch=1';


	if ( empty($this->showname) && !empty( $this->sorting ) ) $tag .= '|showNoName=1';

	if ( !empty( $this->showcolumn ) ) $tag .= '|showHeader=1';

	if ( !empty( $this->numdisplay ) ) $tag .= '|nb=' . $this->numdisplay;

	if ( empty($this->showimage) ) $tag .= '|showNoImage=1';

	if ( empty($this->showrating) ) $tag .= '|showNoRating=1';


	if ( !empty( $this->showpreview ) ) $tag .= '|showPreview='.$this->showpreview;

	if ( !empty( $this->showfeedback ) ) $tag .= '|showReview='.$this->showfeedback;

	if ( !empty( $this->showintro ) ) $tag .= '|showIntro='.$this->showintro;

	if ( !empty( $this->showdesc ) ) $tag .= '|showDesc='.$this->showdesc;

	if ( !empty( $this->showvendor ) ) $tag .= '|showVendor='.$this->showvendor;

	if ( !empty( $this->showvendorating ) ) $tag .= '|showVendorRating='.$this->showvendorating;

	if ( !empty( $this->showquestion ) ) $tag .= '|showQuestion='.$this->showquestion;

	if ( !empty( $this->showreadmore ) ) $tag .= '|showReadMore='.$this->showreadmore;
	if ( !empty( $this->addcart ) ) $tag .= '|addCart='.$this->addcart;

	if ( !empty( $this->imagewidth ) ) $tag .= '|imageWidth=' . $this->imagewidth;

	if ( !empty( $this->imageheight ) ) $tag .= '|imageHeight=' . $this->imageheight;


		if ( !empty( $this->bordershow ) ) $tag .= '|borderShow=1';
	if ( !empty( $this->bordercolor ) ) $tag .= '|borderColor=' . $this->bordercolor;


	if ( !empty( $this->showmaincategory ) ) $tag .= '|showMainCategory=' . $this->showmaincategory;


	
	if ( !empty( $this->catid ) ) $tag .= '|category='.$this->catid;

	
	if ( !empty( $this->auto ) ) {

		$catid = WGlobals::get( 'catid' );

		if ( empty($catid) ) {

			$controller = WGlobals::get( 'controller');

			$task = WGlobals::get( 'task');

			if ( $controller=='catalog' && $task=='category' ) {

				$catid = WGlobals::get( 'eid' );

			}
		}
		if ( !empty( $catid ) ) $tag .= '|category='.$catid;

	}
		if ( !empty( $this->smartvendor ) ) {
		$vendid = WGlobals::get( 'vendid' );
		if ( empty($vendid) ) {
			$controller = WGlobals::get( 'controller');
			$task = WGlobals::get( 'task');
			if ( $controller=='vendors' && ( $task=='home' || $task=='show' ) ) {
				$vendid = WGlobals::get( 'eid' );
			}		}		if ( !empty( $vendid ) ) $tag .= '|vendor='.$vendid;
	}


	$layout = ( !empty($this->layoutname) ? $this->layoutname : ( !empty($this->layout) ? $this->layout : '') ) ;

	if ( !empty( $layout ) ) $tag .= '|layout=' . trim($layout);
	else $tag .= '|layout=badgemini';



	if ( !empty( $this->layoutcol ) ) $tag .= '|layoutNbColumn=' . $this->layoutcol;
	if ( !empty( $this->layoutnbrow ) ) $tag .= '|layoutNbRow=' . $this->layoutnbrow;



	if ( !empty( $this->display ) ) {

		if ( $this->display == 'default' ) $tag .= '|display=vertical';

		else $tag .= '|display=' . $this->display;

	}


	if ( !empty( $this->climit ) ) $tag .= '|climit=' . $this->climit;

	if ( !empty( $this->nlimit ) ) $tag .= '|nlimit=' . $this->nlimit;


	if ( !empty( $this->moduleclass_sfx ) ) $tag .= '|classSuffix=' . $this->moduleclass_sfx;

	$tag .= '|themeType=node';



	if ( !empty( $this->subcategory ) ) $tag .= '|showSubCategory=' . $this->subcategory;



	if ( !empty( $this->showall ) ) $tag .= '|showAll=' . $this->showall;



		if ( !empty( $this->pageid ) ) $tag .= '|pageID=' . $this->pageid;
	else {
				if ( empty( $this->pagetype ) ) {
						$pageID = WPage::getSpecificItemId( 'catalog' );
			if ( !empty($pageID) ) $tag .= '|pageID=' . $pageID;
		} else {						}	}

		if ( !empty($this->module->id) ) $tag .= '|widgetID=' . $this->module->id;
	elseif ( !empty($this->widgetID) ) $tag .= '|widgetID=' . $this->widgetID;
	if ( !empty($this->module->module) ) $tag .= '|widgetSlug=' . $this->module->module;
	elseif ( !empty($this->widgetSlug) ) $tag .= '|widgetSlug=' . $this->widgetSlug;

	
	if ( !empty( $this->remoteurl ) ) $tag .= '|remoteURL=' . $this->remoteurl;

	if ( !empty( $this->affid ) ) $tag .= '|affilateID=' . $this->affid;


	$tag .= '}';



	$tagProcessC = WClass::get('output.process');

	$tagProcessC->replaceTags( $tag );


	$this->content = $tag;

	return true;



}
}