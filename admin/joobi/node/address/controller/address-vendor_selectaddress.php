<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Address_vendor_selectaddress_controller extends WController {
function selectaddress() {



	$adid= WGlobals::get('adid');

	$vendid= WGlobals::get('vendid');



	if (!empty($vendid)) {

		$itemM = WModel::get( 'vendor' );

		$itemM->whereE('vendid', $vendid);

		$itemM->setVal('adid', $adid);

		$itemM->update();

	}
	

	WPages::redirect('controller=address-vendor&task=listing&vendid='.$vendid);

	

	return true;



}}