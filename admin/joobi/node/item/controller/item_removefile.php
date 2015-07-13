<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_removefile_controller extends WController {
function removefile() {



	$pid = WGlobals::get('pid');

	$controller = WGlobals::get('controllerback');

	

	if (empty($pid)) return false;

	

	
	$modelM = WModel::get('item');

	$modelM->whereE('pid', $pid);

	$modelM->setVal('filid', 0);

	$modelM->update();

	

	$msg = WMessage::get();

	$msg->userS('1317297448JZYW');

	WPages::redirect('controller='.$controller.'&task=edit&eid='.$pid);

	

	return true;



}}