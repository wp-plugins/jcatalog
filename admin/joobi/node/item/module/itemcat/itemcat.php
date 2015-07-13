<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');












class Item_CoreItemcat_module extends WModule {

public function create() {

	WPage::addCSSFile( 'node/catalog/css/style.css' );

	$tag = '{widget:itemcat';
	if ( !empty( $this->sorting ) ) $tag .= '|sorting=' . $this->sorting;

	if ( !empty( $this->ids ) ) {
		$this->ids = str_replace( ' ', '', $this->ids );
		$tag .= '|id=' . $this->ids;
	}
	if ( !empty( $this->search ) ) $tag .= '|search=' . $this->search;
	if ( !empty( $this->carrouselarrow ) ) $tag .= '|carrouselArrow=' . $this->carrouselarrow;

		if ( empty($this->showname) && !empty( $this->sorting ) ) $tag .= '|showNoName=1';
	if ( !empty( $this->showcolumn ) ) $tag .= '|showHeader=1';
	if ( !empty( $this->numdisplay ) ) $tag .= '|nb=' . $this->numdisplay;
	if ( empty($this->showimage) ) $tag .= '|showNoImage=1';

	if ( !empty( $this->showdesc ) ) $tag .= '|showDesc='.$this->showdesc;

		if ( !empty($this->auto) ) {
		$catid = WGlobals::get( 'catid' );
		if ( empty($catid) ) {
			$controller = WGlobals::get( 'controller');
			$task = WGlobals::get( 'task');
			if ( $controller=='catalog' && $task=='category' ) {
				$catid = WGlobals::get( 'eid' );
			}		}		if ( !empty( $catid ) ) $tag .= '|parent='.$catid;
		elseif ( !empty( $this->parent ) ) $tag .= '|parent='.$this->parent;
	} else {
		if ( !empty( $this->parent ) ) $tag .= '|parent='.$this->parent;
	}
		if ( !empty( $this->bordershow ) ) $tag .= '|borderShow=1';
	if ( !empty( $this->bordercolor ) ) $tag .= '|borderColor=' . $this->bordercolor;


	if ( !empty( $this->imagewidth ) ) $tag .= '|imageWidth=' . $this->imagewidth;
	if ( !empty( $this->imageheight ) ) $tag .= '|imageHeight=' . $this->imageheight;

	$layout = ( !empty($this->layoutname) ? $this->layoutname : ( !empty($this->layout) ? $this->layout : '') ) ;
	if ( !empty( $layout ) ) $tag .= '|layout=' . trim($layout);
	else $tag .= '|layout=badgemini';

	if ( !empty( $this->layoutcol ) ) $tag .= '|layoutNbColumn=' . $this->layoutcol;
	if ( !empty( $this->layoutnbrow ) ) $tag .= '|layoutNbRow=' . $this->layoutnbrow;
	if ( !empty( $this->subcatpopover ) ) $tag .= '|subCatPopOver=' . $this->subcatpopover;


	if ( !empty( $this->level ) ) $tag .= '|level=' . $this->level;
	if ( !empty( $this->display ) ) $tag .= '|display=' . $this->display;

	if ( !empty( $this->prodtypid ) ) $tag .= '|prodtypid=' . $this->prodtypid;
	if ( !empty( $this->type ) ) $tag .= '|type=' . $this->type;

	if ( !empty( $this->hasitems ) ) $tag .= '|hasItems=' . $this->hasitems;

	if ( !empty( $this->climit ) ) $tag .= '|climit=' . $this->climit;

	if ( !empty( $this->moduleclass_sfx ) ) $tag .= '|classSuffix=' . $this->moduleclass_sfx;
	$tag .= '|themeType=node';

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

	if ( empty( $this->totalitems ) ) $tag .= '|showNoItem=1';
	if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) || empty( $this->totalitemsub ) ) $tag .= '|showNoItemSub=1';

	if ( !empty( $this->nbitems ) ) $tag .= '|nbItems=' . $this->nbitems;
	if ( empty( $this->itemimage ) ) $tag .= '|itemImage=1';

	$tag .= '}';

	$tagProcessC = WClass::get('output.process');
	$tagProcessC->replaceTags( $tag );

	$this->content = $tag;

	return true;
}}