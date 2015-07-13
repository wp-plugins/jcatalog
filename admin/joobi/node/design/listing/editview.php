<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'listing.butshow' );
class Design_Editview_listing extends WListing_butshow {


function create() {



	
	$fdid = $this->getValue( 'fdid', 'design.viewfields' );

	if ( empty($fdid) ) return false;







	$yid = $this->getValue( 'yid' );

	if ( empty($yid) ) return false;



	$type = WView::get( $yid, 'type' );



	if ( $type == 2 ) {

		
		$layout = 'listings';

		$edit = 'listing';

		$pkey = 'lid';

	} else {

		
		$layout = 'forms';

		$edit = 'form';

		$pkey = 'fid';

	}








	$viewName = WView::get( $yid, 'name' );



	$this->element->lien = 'controller=main-' . $edit . '&task=listing&yid=' . $yid . '&titleheader=' . $viewName;



	return parent::create();



}}