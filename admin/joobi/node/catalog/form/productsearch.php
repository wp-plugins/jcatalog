<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement( 'form.layout' );
class Catalog_Productsearch_form extends WForm_layout {
function create() {



	$searchbox = WPref::load( 'PCATALOG_NODE_SEARCHBOX' );

	if ( empty($searchbox) ) return false;



	return parent::create();



}}