<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_vendors_change_controller extends WController {

	function vendors_change() {


		$serialziedList = base64_encode( serialize( WGlobals::getEID( true ) ) );

		WPages::redirect( 'controller=vendors-change&serialListPdID=' . $serialziedList . '&returnLink=' . WGlobals::get( 'controller' ) );


		return true;



	}
}