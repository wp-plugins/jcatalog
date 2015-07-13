<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_related_order_controller extends WController {
function order() {

	$eid=WGlobals::getEID();

	parent::order();



	WPages::redirect('controller=item-related&eid='.$eid);

	return true;

}}