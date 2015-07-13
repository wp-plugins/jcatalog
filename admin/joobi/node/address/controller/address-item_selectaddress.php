<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_item_selectaddress_controller extends WController {
function selectaddress() {



	$eid = WGlobals::get('pid');

	$adid= WGlobals::get('adid');

	$vendid= WGlobals::get('vendid');



	if (!empty($eid)) {

		$itemM = WModel::get('item');

		$itemM->whereE('pid', $eid);

		$itemM->setVal('adid', $adid);

		$itemM->update();

	}


	WPages::redirect('controller=address-item&task=listing&pid=' . $eid . '&vendid=' . $vendid );



	return true;



}}