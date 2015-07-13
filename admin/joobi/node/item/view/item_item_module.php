<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Item_item_module_view extends Output_Forms_class {
function prepareView() {



	if ( 'carrousel' != $this->getValue( 'display' ) ) {

		$this->removeElements( 'item_item_module_carrouselarrow' );

	}


	return true;



}}