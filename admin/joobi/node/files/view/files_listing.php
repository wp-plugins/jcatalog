<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Files_Files_listing_view extends Output_Listings_class {
protected function prepareView() {



	if ( WRoles::isNotAdmin( 'storemanager' ) ) $this->removeElements( array('files_listing_vendor') );

	return true;



}}