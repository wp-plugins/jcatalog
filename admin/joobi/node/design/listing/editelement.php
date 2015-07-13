<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'listing.butedit' );
class Design_Editelement_listing extends WListing_butedit {
function create() {



	
	$fdid = $this->getValue( 'fdid', 'design.viewfields' );

	if ( empty($fdid) ) return false;



	$yid = $this->getValue( 'yid');



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


	$viewElementM = WModel::get( 'library.view' . $layout );

	$viewElementM->whereE( 'yid', $yid );

	$viewElementM->whereE( 'fdid', $fdid );

	$eid = $viewElementM->load( 'lr', $pkey );



	if ( empty($eid) ) return false;



	$link = 'controller=main-' . $edit . '&task=edit(eid=' . $eid . ')';

	$this->element->lien = $link;



	return parent::create();



}}