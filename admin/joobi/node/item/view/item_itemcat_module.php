<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_Item_itemcat_module_view extends Output_Forms_class {
function prepareView() {



	if ( 'carrousel' != $this->getValue( 'display' ) ) {

		$this->removeElements( 'item_itemcat_module_carrouselarrow' );

	}




	if ( ! WPref::load( 'PITEM_NODE_CATSUBCOUNT' ) ) $this->removeElements( 'item_itemcat_module_totalitemsub' );



	return true;



}}