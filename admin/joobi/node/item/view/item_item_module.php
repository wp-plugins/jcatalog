<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_Item_item_module_view extends Output_Forms_class {
function prepareView() {



	if ( 'carrousel' != $this->getValue( 'display' ) ) {

		$this->removeElements( 'item_item_module_carrouselarrow' );

	}


	return true;



}}