<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');




class Comment_Content_plugin extends WPlugin {









function onContentBeforeDisplay($context,&$article,&$params,$limitstart) {

	if ( JOOBI_FRAMEWORK_TYPE != 'joomla' ) return '';

		if ( !WExtension::exist( 'jfeedback.application' ) ) return '';

	$option = WGlobals::getApp();
	if ( $option != 'com_content' && $option != 'com_k2' ) return '';

		WPage::addCSSFile( 'css/style.css' );

	$CMTArtcile = WPref::load( 'PCOMMENT_NODE_CMTARTICLE' );
	
	if ( !$CMTArtcile ) return false;

	if ( empty($article->catid) ) $article->catid = 0;

	$articleView = ( WGlobals::get('view') == 'article' ) ? true : false;

	$catid = ( !empty($article->catid) ? $article->catid : 0 );

	if ( true ) {

		       	static $roleCategoryM = null;
       	static $allowCategoryA = array();

		if ( !isset($allowCategoryA[$catid]) ) {
			if (!isset($roleCategoryM)) $roleCategoryM = WModel::get('role.categories');
		  	$roleCategoryM->select( 'comment');
	 		$roleCategoryM->whereE( 'id', $catid );
			$allowCategoryA[$catid] = $roleCategoryM->load('lr');
		}
		if ( empty($allowCategoryA[$catid]) ) {
	       	static $roleArticleM = null;
	       	static $allowArticleA = array();

	       	if ( !isset($allowArticleA[$article->id]) ) {
				if (!isset($roleArticleM)) $roleArticleM = WModel::get('role.content');
				$roleArticleM->select( 'comment');
	 			$roleArticleM->whereE( 'id', $article->id );
				$allowArticleA[$article->id] = $roleArticleM->load('o');
			}
			if (empty($allowArticleA[$article->id]->comment)) {
				if ( $articleView ) {								$this->_listComments( $article );
				} else {									$this->_mainComments( $article );
				}			}		}	}else {

		if ( $articleView ) {							$article->parameters->_registry['_default']['data']->show_vote = 0;				$this->_listComments( $article );
		} else {
			if (PCOMMENT_NODE_CMTAVERATING) {
				$article->params->_registry['_default']['data']->show_vote = 0;
			}			$this->_mainComments( $article );			}	}

    return '';

}











function onBeforeDisplayContent(&$article,&$params,$limitstart) {

	if ( JOOBI_FRAMEWORK_TYPE != 'joomla' ) return '';

	$CMTArtcile = WPref::load('PCOMMENT_NODE_CMTARTICLE');
	
	if ( !$CMTArtcile ) return false;

	if ( empty($article->sectionid) ) $article->sectionid = 0;
	if ( empty($article->catid) ) $article->catid = 0;

	$articleView = ( WGlobals::get('view') =='article' ) ? true : false;

	$catid = !empty($article->catid) ? $article->catid : 0;

	if ( true ) {
       	static $roleSectionM = null;
       	static $allowSectionA = array();

		        if ( !isset($allowSectionA[$article->sectionid]) ) {
	        if (!isset($roleSectionM)) $roleSectionM = WModel::get('role.sections');				  	$roleSectionM->select( 'comment');
	 		$roleSectionM->whereE( 'id', $article->sectionid );
			$allowSectionA[$article->sectionid] = $roleSectionM->load('lr');
        }
				if (empty($allowSectionA[$article->sectionid])) {
	       	static $roleCategoryM = null;
	       	static $allowCategoryA = array();
			if ( !isset($allowCategoryA[$catid]) ) {
				if (!isset($roleCategoryM)) $roleCategoryM = WModel::get('role.categories');
			  	$roleCategoryM->select( 'comment');
		 		$roleCategoryM->whereE( 'id', $catid );
				$allowCategoryA[$catid] = $roleCategoryM->load('lr');
			}
			if (empty($allowCategoryA[$catid])) {
		       	static $roleArticleM = null;
		       	static $allowArticleA = array();
				if ( !isset($allowArticleA[$article->id]) ) {
					if (!isset($roleArticleM)) $roleArticleM = WModel::get('role.content');
			  		$roleArticleM->select( 'comment');
		 			$roleArticleM->whereE( 'id', $article->id );
					$allowArticleA[$article->id] = $roleArticleM->load('o');
				}
				if (empty($allowArticleA[$article->id]->comment)) {
					if ( $articleView ) {									$this->_listComments( $article );
					} else {										$this->_mainComments( $article );
					}				}			}		}	}else {

		if ( $articleView ) {							$article->parameters->_registry['_default']['data']->show_vote = 0;				$this->_listComments( $article );
		} else {
			if (PCOMMENT_NODE_CMTAVERATING) {
				$article->params->_registry['_default']['data']->show_vote = 0;
			}			$this->_mainComments( $article );			}	}
    return '';

}





private function _listComments(&$article) {


	WPage::addJSLibrary( 'validation' );

	$articleID = WGlobals::setEID(  $article->id );		$memberId =WUser::get('uid');								$returnId = WView::getURI();							$realVal = base64_encode($returnId);					$commenttype = '20';

	WGlobals::set( 'commenttype', 20 );						WGlobals::set( 'eid', $articleID );						WGlobals::set( 'uid', $memberId );						WGlobals::set( 'extensionKEY', 'comment.node', 'global' );		


		$integrationV = WView::getHTML( 'comment_fe' );
	if ( empty($integrationV) ) return '';

	$formObj = WView::form( $integrationV->firstFormName );
	$formObj->hidden( JOOBI_URLAPP_PAGE, WGlobals::getApp() );
	$formObj->hidden( 'limitstart' . $integrationV->yid, 0 );


	$existingComments = $integrationV->make();

	$type = ( empty($existingComments) ) ? 'first' : 'addcomment';

	$commentC = WClass::get( 'comment.button', null, 'class', false );
	if ( empty($commentC) ) return true;
	$commentRestrictionsC= WClass::get('comment.restrictions');
	$total = $commentRestrictionsC->count( $article->id );		
	$article->text .= $commentC->getTitle( $total, 'comment' );
	$article->text .= $existingComments;
	$article->text .= $commentC->addComment( $type );

}






private function _mainComments(&$article) {

	WText::load( 'comment.node' );


	$text = 'introtext';

	$slug = !empty($article->slug) ? $article->slug : 0;
	$commentC= WClass::get('comment.restrictions');
	if (!isset($total)) $total = $commentC->count($article->id);
	$itemId = WGlobals::get( JOOBI_PAGEID_NAME );
	$catslug = !empty($article->catslug) ? $article->catslug : 0;



	$route = WPage::link( 'index.php?option=com_content&view=article&id=' . $slug . '#comment' );
	if ( empty($total)) {
		$myText = WText::t('1307673208ILBE');
	} else {
		$myText = WText::t('1206961912MJQH');
		$myText .= ' <span class="badge">' . $total . '</span>';
	}
	$objButtonO = WPage::newBluePrint( 'button' );
	$objButtonO->type = 'standard-question';
	$objButtonO->link = $route;
	$objButtonO->text = $myText;
	$objButtonO->icon = 'fa-comment';
	$objButtonO->color = 'primary';
	$content = WPage::renderBluePrint( 'button', $objButtonO );

	$article->$text .=' <br /><div class="cmtfirst">' . $content . '</div><br />';

	$article->introtext .= '<br \>';

	$rolisd = WUser::roles();
	$this->_showAverage( $article );

}






private function _showAverage(&$article) {

	if (!defined('PCOMMENT_NODE_CMTNAVERATING')) WPref::get('comment.node');
	if (PCOMMENT_NODE_CMTAVERATING) {

	   	   static $rateClass = null;
	   static $roleArticlesM = null;
	   static $modID = null;
	   $etid = WGlobals::getEID();

	   	   if ( !isset($rateClass) ) $rateClass= WClass::get('output.rating');
	   $this->_rateC = $rateClass;

	       if (!isset( $roleArticleM )) $roleArticlesM = WModel::get('role.content');
		$roleArticlesM->select('rating_num');
		$roleArticlesM->select('rating_sum');
		$roleArticlesM->whereE( 'id', $article->id );
		$sections = $roleArticlesM->load('o');
		if ( !empty($sections) ) {
		   			   	$rating = $sections->rating_sum;
		   	if ($rating > 1 && $sections->rating_num != 0 ) {
		      		$rating=($rating/$sections->rating_num);
		   	}

		   		   		$this->_rateC->primaryId = $etid;
		    $this->_rateC->restriction = 1;
	   		$this->_rateC->rating = $rating;
	   		$this->_rateC->option = 0;
	   		$this->_rateC->type = 0;


	   		$commentC= WClass::get('comment.restrictions');
	   		$totalR =$commentC->count( $article->id, true );			   		

			$text = 'introtext';

			$slug = !empty($article->slug) ? $article->slug : 0;
			$catslug = !empty($article->catslug) ? $article->catslug : 0;

			$itemId = WGlobals::get( JOOBI_PAGEID_NAME );

		  

			$route = WPage::link( 'index.php?option=com_content&view=article&id=' . $slug . '#comment' );

			if ( $totalR > 1 ) {
				$REVIEW = WText::t('1246243852IPUS');
			} else {
				$REVIEW = WText::t('1260242519OFEU');
			}
	   		$article->$text = '<div id="cmtaverage-rate">'.$this->_rateC->createHTMLRating($this->_rateC). '<a href= ' . $route . '> <span class="badge">'.$totalR.'</span> ' . $REVIEW . '</a></div>'.'<br /><br />'. $article->$text;

	 	}	}
	return true;

}

}