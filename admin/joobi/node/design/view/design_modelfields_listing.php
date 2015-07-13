<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Design_modelfields_listing_view extends Output_Listings_class {
function prepareView() {



	$sid = WForm::getPrev( 'sid' );

	if ( empty($sid) ) {

		WPages::redirect( 'controller=design-model' );

	}


	return true;



}}