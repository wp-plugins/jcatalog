<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_related_order_controller extends WController {
function order() {

	$eid=WGlobals::getEID();

	parent::order();



	WPages::redirect('controller=item-related&eid='.$eid);

	return true;

}}