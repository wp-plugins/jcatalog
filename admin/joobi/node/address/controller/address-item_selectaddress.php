<?php 

* @link joobi.co
* @license GNU GPLv3 */



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