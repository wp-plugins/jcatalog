<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.text' );
class Catalog_Homesearch_form extends WForm_text {

function create() {

		$ajaxsearch = WPref::load( 'PCATALOG_NODE_AJAXSEARCH' );
	if ( !empty($ajaxsearch) ) {

				$jsString = $this->_getJSString();
		WPage::addJS( $jsString, 'text/javascript', true );

	        	        WPage::addJSLibrary( 'jquery' );

						$content = '<div id="results" style="float:left;width:100%"></div><div class="overlay"></div>';
			
	} 
	$size = WGlobals::get( 'catalogSearchInputSize', '100%' );
	$this->element->width = $size;



	if ( empty($this->value) ) {

		$this->value = WText::t('1206732365OQJI') . '...';

		$this->extras = ' onblur="if (this.value==\'\') this.value=\'' . $this->value .'\';" onfocus="if (this.value==\'' . $this->value .'\') this.value=\'\';"';
	}

	$status = parent::create();

	if ( !empty($content) ) $this->content .= $content;

	return $status;


}






    private function _getJSString() {

    	$itemType = WGlobals::get( 'type' );
    	$vendid = WGlobals::get( 'eid' );
    	$page = WGlobals::get( 'controller' );

    	$link = 'controller=catalog&task=ajaxsearch';

    	    	    	if(!empty($page) && $page == 'vendors') $link .= '&vendid=' . $vendid;

    	if ( !empty($itemType) ) $link .= '&type=' . $itemType;

	    $route = WPage::linkAjax( $link );

    	$jsString = '

jQuery(document).ready(function(){
jQuery("#' . $this->idLabel . '").keyup(function(){
var kw = jQuery("#' . $this->idLabel . '").val();
if (kw != ""){
jQuery.ajax
({
url:"' . $route . '",
dataType:"html",
data:"kw="+ kw,
success: function(response){
var res = response;
jQuery("#results").html("");
var ajaxresres = jQuery(res).find("#ajaxresult");
jQuery("#results").append(ajaxresres);
},
error: function(jqXHR, exception){
var acb = 12;
}
});
}else{
jQuery("#results").html("");
}
return false;
});
});
';

    	return $jsString ;

    }
}