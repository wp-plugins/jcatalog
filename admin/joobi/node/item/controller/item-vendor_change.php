<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_vendor_change_controller extends WController {

	function change() {


		$pid = WGlobals::get( 'pid' );

		$vendid = WGlobals::getEID();

		if ( empty($pid) || empty($vendid) ) return false;

		$itemM = WModel::get( 'item' );
		$itemM->whereE( 'pid', $pid );
		$itemM->setVal( 'vendid', $vendid );
		return $itemM->update();


	}
}