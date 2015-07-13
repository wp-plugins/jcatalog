<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.image' );
class Catalog_Resizeimage_form extends WForm_image {

function show() {



	
	$pageParams = WGlobals::get( 'categoryPageParams', null, 'global' );

	if ( !empty($pageParams->categoryImageWidth) ) $this->resizedWidth = $pageParams->categoryImageWidth;
	if ( !empty($pageParams->categoryImageHeight) ) $this->resizedHeight = $pageParams->categoryImageHeight;

	return parent::show();


}
}