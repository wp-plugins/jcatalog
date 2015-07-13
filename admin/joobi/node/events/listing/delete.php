<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement('listing.butdeleteall');
class Events_CoreDelete_listing extends WListing_butdeleteall {
function create(){


if( $this->getValue( 'core' )) return false;



return parent::create();



}}