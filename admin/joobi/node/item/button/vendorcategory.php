<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_CoreVendorcategory_button extends WButtons_external {
function create() {



	if ( WRoles::isNotAdmin( 'storemanager' ) && ! WPref::load( 'PITEM_NODE_ALLOWVENDORCAT' ) ) return false;



	return parent::create();



}}