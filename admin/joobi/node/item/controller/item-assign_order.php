<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_assign_order_controller extends WController {




function order() {

	

	parent::order();

	

	$titleheader = WGlobals::get( 'titleheader' );

	$catid = WGlobals::get( 'catid' );



	WPages::redirect( 'controller=item-assign&catid='. $catid .'&titleheader='. $titleheader );



	return true;

}}