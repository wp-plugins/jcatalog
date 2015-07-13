<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_ajaxsearch_controller extends WController {

	function ajaxsearch() {





		$var = $this->_getFieldFromRequest('kw');

		$json=false;



		if (!empty($var) ) $this->_getAjaxSearchResults( $json, $var );


		


		return true;



	}












    private function _getAjaxSearchResults($json=false,$var) {

        $tag = '{widget:item|search=' . $var;
    	$ajaxLayout = WPref::load( 'PCATALOG_NODE_AJAXSEARCHITMLAYOUT' );	
    	$AJAXSEARCHITMLAYOUT = PCATALOG_NODE_AJAXSEARCHITMLAYOUT;
    	$layout = ( !empty($AJAXSEARCHITMLAYOUT) ? PCATALOG_NODE_AJAXSEARCHITMLAYOUT : ( !empty($ajaxLayout) ? $ajaxLayout : 'badgemini') ) ;
    	$tag .= '|layout=' . trim($layout);

    	$tag .= '|widgetSlug=search_ajax_item';
    	$tag .= '|layout=' . $ajaxLayout;
    	$tag .= '|showReview=' . PCATALOG_NODE_AJAXSEARCHITMFEEDBACK;	    	$tag .= '|climit=' . PCATALOG_NODE_AJAXSEARCHITMCLIMIT;	    	$tag .= '|nlimit=' . PCATALOG_NODE_AJAXSEARCHITMNLIMIT;	    	$tag .= '|nb=' . PCATALOG_NODE_AJAXSEARCHITMNBDISPLAY;	    	$ajaxsearchitmshowfree = PCATALOG_NODE_AJAXSEARCHITMSHWOFREE;
    	if ( empty($ajaxsearchitmshowfree) ) $tag .= '|dontShowFree=1';	    	$tag .= '|showIntro=' . PCATALOG_NODE_AJAXSEARCHITMSHOWINTRO;	    	$tag .= '|showPrice=' . PCATALOG_NODE_AJAXSEARCHITMSHOWPRICE;	    	$ajaxsearchitmshowrating = PCATALOG_NODE_AJAXSEARCHITMSHOWRATING;
    	if ( empty($ajaxsearchitmshowrating) ) $tag .= '|showNoRating=1';	    	$tag .= '|showVendor=' . PCATALOG_NODE_AJAXSEARCHITMSHOWVENDOR;	    	$tag .= '|sorting=' . PCATALOG_NODE_AJAXSEARCHITMSORTING;	    	$ajaxsearchitmshowimage = PCATALOG_NODE_AJAXSEARCHITMSHOWIMAGE;
    	if ( empty($ajaxsearchitmshowimage) ) $tag .= '|showNoImage=1';	
    	    	$vendor = $this->_getFieldFromRequest('vendid');
    	if ( !empty($vendor) ) $tag .= '|vendor=' . $vendor;

    	$tag .= '|display=vertical|themeType=node}';



    	$tagProcessC = WClass::get('output.process');

    	$tagProcessC->replaceTags( $tag );


    	$stingToEcho = '<div><div id="ajaxresult" style="background-color:#f5f8fa;"><div class="rowSeparator"></div>'.$tag.'</div></div>';
    	

    	echo $stingToEcho;	




    }


















    private function _getFieldFromRequest($name) {



		$searchItem = WForm::getPrev( 'x['.$name.']' );

		if ( empty($searchItem) ) {

			$trucs = WGlobals::get( 'trucs' );

			if (!empty($trucs['x'][$name]) ) $searchItem = $trucs['x'][$name];

		}


		return $searchItem;

    }





}