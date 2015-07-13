<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_Showsocial_class extends WClasses {

	private $_link = 'controller=catalog&task=show';
	private $_extraLink = '';
	private $pageURLEncode = '';






	function displayFacebook($item) {

		$this->_setupURL( $item->pid );

		$data = WPage::newBluePrint( 'socialicons' );
		$data->type = 'facebook';
		$data->itemURL = $this->pageURL;
		$data->itemName = WGlobals::filter( $item->name, 'alnum' );
		$data->itemImage = ( !empty($item->image) ? $item->image : '' );

		return WPage::renderBluePrint( 'socialicons', $data );

	}






	function displayTwitter($item) {

		$this->_setupURL( $item->pid );

		$data = WPage::newBluePrint( 'socialicons' );
		$data->type = 'twitter';
		$data->itemURL = $this->pageURLEncode;
		$data->itemName = WGlobals::filter( $item->name, 'alnum' );
		$data->language = $this->languageCode;
		return WPage::renderBluePrint( 'socialicons', $data );

	}






	function displayAddThis($name='',$pid='') {
		$this->_setupURL( $pid );

		$data = WPage::newBluePrint( 'socialicons' );
		$data->type = 'addthis';
		$data->text = WText::t('1227580115NTZC');
		return WPage::renderBluePrint( 'socialicons', $data );

	}






	function displayGoogle($item) {


		$data = WPage::newBluePrint( 'socialicons' );
		$data->itemURL = $this->pageURLEncode;
		$data->itemName = WGlobals::filter( $item->name, 'alnum' );
		$data->type = 'googleplus';
		return WPage::renderBluePrint( 'socialicons', $data );

	}







	public function displayFavorite($pid,$extreaType=0) {

		$totalCount = 0;			$favorite = self::createButton( $pid, 20, $totalCount, $extreaType );
		return $favorite;
	}







	public function displayWish($pid,$extreaType=0) {

		$totalCount = 0;			$favorite = self::createButton( $pid, 30, $totalCount, $extreaType );
		return $favorite;

	}







	public function displayWatch($pid,$extreaType=0) {

		$totalCount = 0;			$favorite = self::createButton( $pid, 10, $totalCount, $extreaType );
		return $favorite;

	}







	public function displayLike($pid,$extreaType=0) {

		$totalCount = 0;			$likeButton = self::createButton( $pid, 40, $totalCount, $extreaType );
		$dislikeButton = self::createButton( $pid, 45, $totalCount, $extreaType );

		$data = WPage::newBluePrint( 'socialicons' );
		$data->type = 'likeDislike';
		$data->text = $likeButton . $dislikeButton;
		return WPage::renderBluePrint( 'socialicons', $data );


	}







	public function displayShare($pid,$extreaType=0) {


		$shareWall = '';
		$isRegistered = WUser::isRegistered();
		if ( $isRegistered ) {				$itemWallC = WClass::get( 'item.wall' );
			if ( $itemWallC->available() ) {
								$type = 50 + $extreaType;
				$pageID = APIPage::cmsGetItemId();
				$link = WPage::routeURL( 'controller=catalog-wall&task=add&type='.$type.'&pid='. $pid . '&item='.$itemName . '&pageid='.$pageID , 'home', 'popup' );
				$text = '<span class="socialRight"><span class="socialCenter">'.WText::t('1227580115NTZC');
				$totalCount = 0;
				if ( $totalCount > 0 ) $text .= '&nbsp;<span> '.  $totalCount .'</span>';
				$text .= '</span></span>';

				$shareWall = WPage::createPopUpLink( $link, $text, 450, 300, '', 'catalogShareWall' );

			}		}		return $shareWall;
	}











function shareDisplay(&$obj,$pid,$itemName,$pageParams,$typeOfElement='item',$hits=0) {	
		if ( empty( $pid ) || empty( $itemName ) ) return false;

	switch( $typeOfElement ) {
		case 'category':
			$this->_link = 'controller=catalog&task=category';
			$extreaType = 100;
			break;
		case 'vendor':
			$this->_link = 'controller=vendors&task=home';
			$extreaType = 200;
			break;
		case 'item':
		default:
			$this->_link = 'controller=catalog&task=show';
			$extreaType = 0;
			break;
	}

	$this->_setupURL( $pid );


		$obj->setValue( 'pageURLEncode', $this->pageURLEncode );
		$obj->setValue( 'nameEncode', urlencode( $itemName ) );


	$item = new stdClass;
	$item->name = $itemName;
	$item->pid = $pid;
	$item->image = WGlobals::get( 'imageURL', '' );


	$extraHTML = '';

	if ( !empty($pageParams->showLike) ) {
		$obj->setValue( 'linkFacebook', $this->displayFacebook( $item ) );
		$extraHTML .= WGlobals::get( 'socialIconsExtraHTML', '', 'global' );
		WGlobals::set( 'socialIconsExtraHTML', '', 'global' );
	}
	if ( !empty($pageParams->showTweet) ) {
		$obj->setValue( 'linkTwitter', $this->displayTwitter( $item ) );
		$extraHTML .= WGlobals::get( 'socialIconsExtraHTML', '', 'global' );
		WGlobals::set( 'socialIconsExtraHTML', '', 'global' );
	}
	if ( !empty($pageParams->showBuzz) ) {
		$obj->setValue( 'linkGoogle', $this->displayGoogle( $item ) );
		$extraHTML .= WGlobals::get( 'socialIconsExtraHTML', '', 'global' );
		WGlobals::set( 'socialIconsExtraHTML', '', 'global' );
	}
	$obj->setValue( 'extraSocialHTML', $extraHTML );

	if ( !empty($pageParams->showShareThis) ) {
		$obj->setValue( 'linkShareThis', $this->displayAddThis() );
	}
	$isRegistered = WUser::isRegistered();

	if ( !empty($pageParams->showFavorite) ) {
		$totalCount = $obj->getValue( 'countFavorite' );
		$favorite = self::createButton( $pid, 20, $totalCount, $extreaType );
		$obj->setValue( 'linkFavorite', $favorite );
	}
	if ( !empty($pageParams->showWish) ) {
		$totalCount = $obj->getValue( 'countWish' );
		$favorite = self::createButton( $pid, 30, $totalCount, $extreaType );
		$obj->setValue( 'linkWish', $favorite );
	}
	if ( !empty($pageParams->showWatch) ) {
		$totalCount = $obj->getValue( 'countWatch' );
		$favorite = self::createButton( $pid, 10, $totalCount, $extreaType );
		$obj->setValue( 'linkWatch', $favorite );
	}
	if ( !empty($pageParams->showLikeDislike) ) {
		$totalCount = $obj->getValue( 'countLike' );
		$likeButton = self::createButton( $pid, 40, $totalCount, $extreaType );

		$totalCount = $obj->getValue( 'countDislike' );
		$dislikeButton = self::createButton( $pid, 45, $totalCount, $extreaType );

		$data = WPage::newBluePrint( 'socialicons' );
		$data->type = 'likeDislike';
		$data->text = $likeButton . $dislikeButton;
		$obj->setValue( 'linkLikeDislike', WPage::renderBluePrint( 'socialicons', $data ) );

	}



	if ( $isRegistered && !empty($pageParams->showShareWall) ) {	
		$itemWallC = WClass::get( 'item.wall' );
		if ( $itemWallC->available() ) {
						$type = 50 + $extreaType;
			$pageID = APIPage::cmsGetItemId();
			$link = WPage::routeURL( 'controller=catalog-wall&task=add&type='.$type.'&pid='. $pid . $this->_extraLink . '&item='.$itemName . '&pageid='.$pageID , 'home', 'popup' );

			$data = WPage::newBluePrint( 'socialicons' );
			$data->type = 'sharewall';
			$data->text = WText::t('1227580115NTZC');
			$data->title = $data->text;
			$data->count = $obj->getValue( 'countShareWall' );
			$data->popUpIs = true;
			$data->link = $link;
			$data->popUpWidth = 450;
			$data->popUpHeight = 300;

			$shareWall = WPage::renderBluePrint( 'socialicons', $data );

			$obj->setValue( 'linkShareWall', $shareWall );

		}
	}
		if ( !empty($pageParams->showViews) ) {

		$data = WPage::newBluePrint( 'socialicons' );
		$data->type = 'views';
		$data->id = 'viewsBtn';
		$data->text = WText::t('1206961854HENY');
		$data->title = $data->text;
		$data->count = (int)$hits;
		$obj->setValue( 'linkViews', WPage::renderBluePrint( 'socialicons', $data ) );

	}
	if ( !empty($pageParams->showEmail) ) {
				$pageID = APIPage::cmsGetItemId();
		$pagelink = base64_encode( WPage::link( 'controller=catalog&show=' . $pid . $this->_extraLink . '&' . JOOBI_PAGEID_NAME . '='.$pageID, 'home' ) );
		$link = 'controller=catalog&task=friend&eid='. $pid .'&model='.$typeOfElement.'&pagelink=' . $pagelink;
		$link = WPage::routeURL( $link, 'home', 'popup', false, false, null, true );

		$data = WPage::newBluePrint( 'socialicons' );
		$data->type = 'email';
		$data->id = 'emailBtn';
		$data->text = WText::t('1206732411EGRU');
		$data->title = $data->text;
		$data->link = $link;
		$data->extraClasses = 'emailBtn';
		$data->popUpIs = true;
		$data->popUpWidth = '80%';
		$data->popUpHeight = '80%';
		$obj->setValue( 'linkEmail', WPage::renderBluePrint( 'socialicons', $data ) );

	}
	if ( !empty($pageParams->showPrint) ) {
				$link = 'controller=catalog&task=show&eid='. $pid .'&printpage=1' . URL_NO_FRAMEWORK;			$link = WPage::routeURL( $link, 'home', 'popup', false, false, null, true );
		$data = WPage::newBluePrint( 'socialicons' );
		$data->type = 'print';
		$data->id = 'printBtn';
		$data->text = WText::t('1242282416HAPS');
		$data->title = $data->text;
		$data->link = $link;
		$obj->setValue( 'linkPrint', WPage::renderBluePrint( 'socialicons', $data ) );


	}
	return true;

}










public static function createButton($pid,$typeValue,$totalCount=0,$extreaType=0,$noButton=false) {		static $count = 0;

	$data = WPage::newBluePrint( 'socialicons' );

	switch( $typeValue ) {
		case 20:			case 220:   		case 120:   			$Label = WText::t('1298350953EMXE');
			$classID = 'catalogShareFavorite';
			$data->type = 'favorite';
			break;
		case 30:				$Label = WText::t('1298350953EMXF');
			$classID = 'catalogShareWish';
			$data->type = 'wish';
			break;
		case 10:			case 210:   		case 110:   			$Label = WText::t('1298350953EMXG');
			$classID = 'catalogShareWatch';
			$data->type = 'watch';
			break;
		case 40:			case 240:   		case 140:   			$Label = WText::t('1337142832RTXT');
			$classID = 'catalogShareLikeLike';
			$data->type = 'like';
			$data->wrapper = false;
			break;
		case 45:			case 245:			case 145:				$data->title = WText::t('1395715489LVAP');
			if (empty( $totalCount) ) $Label = '0';
			else $Label = '';
			$classID = 'catalogShareLikeDislike';
			$data->type = 'dislike';
			$data->wrapper = false;
			break;
		default:
			return false;
			break;
	}

	if ( $noButton ) {
		$data->noButton = true;
	}

	if ( !empty($count) ) $divID = $classID . $count;
	else $divID = $classID;

	$count++;
	WPage::addJSLibrary( 'jquery' );

	$isRegistered = WUser::isRegistered();
	$type = $typeValue + $extreaType;

	if ( !$isRegistered ) {
		$link = WPage::linkHome( 'controller=users&task=home' );
		$extraLinkInfo = ' href="'. $link .'"';
	} else {
		$link = 'controller=wishlist-my-items&task=add&type='.$type.'&eid='. $pid;
		$link = '';
		$jsButton = array( 'ajxUrl'=> $link, 'ajx'=>true, 'ajaxToggle' => true );

		$myJSParam = new stdClass;
		$myJSParam->favoriteType = $type;
		$myJSParam->count = $totalCount;
		$myJSParam->favoriteExtraType = $extreaType;
		$myJSParam->itemID = $pid;
		$myJSParam->divId = $divID;
		if ( $data->wrapper ) $myJSParam->act = 'html';
		else  $myJSParam->act = 'replace';
		$myJSParam->classId = $divID;

		$myJSParam->socialEID = $pid;
		$joobiRun = WPage::actionJavaScript( 'favorite', '', $jsButton , $myJSParam );
		$extraLinkInfo = ' onclick="'. $joobiRun .'"';

	}


	$data->text = $Label;
	if ( empty($data->title) ) $data->title = $Label;
	$data->count = $totalCount;
	$data->id = $divID;
	$data->class = $classID;
	if ( !empty($joobiRun) ) $data->onClick = $joobiRun;
	$html = WPage::renderBluePrint( 'socialicons', $data );

	 return $html;

}






	private function _setupURL($pid) {

				$extraLink = '';
		if ( WExtension::exist( 'affiliate.node') ) {
			$affiliateHelperC = WClass::get( 'affiliate.helper', null, 'class', false );
			$this->_extraLink = $affiliateHelperC->addAffilateToLink();
		}
		$itemURL = WPage::routeURL( $this->_link . '&eid='. $pid . $extraLink, 'home', false, false, false );

		$this->pageURL = $itemURL;
		$this->pageURLEncode = urlencode( $itemURL );
		$this->pageURLJustLink = str_replace( JOOBI_SITE, '', $itemURL );

		$lgid = WUser::get( 'lgid' );
		$data = WLanguage::get( $lgid, 'code' );
		$this->languageCode = $data;

	}
}