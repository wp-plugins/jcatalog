<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_Item_preferences_home_view extends Output_Forms_class {
protected function prepareView() {

	

		if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) $this->removeElements( 'item_preferences_catalog_node_ctyshownbitmsub' );

		

		return true;

	

	}}