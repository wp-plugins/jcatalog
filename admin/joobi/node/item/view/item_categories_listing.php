<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_Item_categories_listing_view extends Output_Listings_class {
function prepareView() {



$multipelType = WPref::load( 'PITEM_NODE_CATMULTIPLETYPE' );

if ( $multipelType ) $this->removeElements( 'item_categories_listing_prodtypid' );




return true;



}}