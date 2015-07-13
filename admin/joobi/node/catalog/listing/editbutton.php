<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'listing.butedit' );
class Catalog_Editbutton_listing extends WListing_butedit {
function create() {

	static $itemDesignationT = null;

	


	$type = $this->getValue( 'type', 'item.type' );

	if ( !isset($itemDesignationT) ) $itemDesignationT = WType::get( 'item.designation' );

	$designation = $itemDesignationT->getName( $type );





	$this->element->lien = 'controller=' . $designation . '&task=edit(eid=pid)';







	return parent::create();



}}