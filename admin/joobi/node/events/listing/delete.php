<?php 

* @link joobi.co
* @license GNU GPLv3 */



WView::includeElement('listing.butdeleteall');
class Events_CoreDelete_listing extends WListing_butdeleteall {
function create(){


if( $this->getValue( 'core' )) return false;



return parent::create();



}}