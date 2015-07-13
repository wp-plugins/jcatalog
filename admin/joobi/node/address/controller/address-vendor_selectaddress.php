<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


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