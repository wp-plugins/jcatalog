<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

WView::includeElement( 'listing.selectone' );
class Main_CoreFormtype_listing extends WListing_selectone {
function create() {



	$status = parent::create();



	if ( empty( $this->content ) ) {

		$this->content = $this->value;

	}


	return true;

	

}}