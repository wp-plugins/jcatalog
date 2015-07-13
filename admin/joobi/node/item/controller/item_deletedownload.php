<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_deletedownload_controller extends WController {
function deletedownload() {



	$pid=WGlobals::get('pid');

	$filid=WGlobals::get('filid');

	$controller = WGlobals::get('tocontroller');



	
	$productImageM=WModel::get('item.downloads');

	$productImageM->whereE('pid', $pid);

	$productImageM->whereE('filid', $filid);

	$productImageM->delete();



	WPages::redirect('controller='.$controller.'&task=edit&eid='.$pid);



	return true;



}}