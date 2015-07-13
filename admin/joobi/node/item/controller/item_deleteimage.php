<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Item_deleteimage_controller extends WController {




	function deleteimage() {




		$pid = WGlobals::get( 'pid' );
		if ( empty($pid) ) $pid = WGlobals::getEID();


		$premium = WGlobals::get( 'premium' );

		$filid = WGlobals::get( 'filid' );

		$controller = WGlobals::get( 'tocontroller', 'item' );

		if ( empty($filid) ) {
			$this->code( 'The id of the file need to be specified!' );
			return false;
		}
				$productImageM = WModel::get( 'item.images' );
		$productImageM->whereE( 'pid', $pid );
		$productImageM->whereE( 'filid', $filid );
		$productImageM->delete();

		if ( $premium==1 ) {

						$productImageM->whereE( 'pid', $pid );
			$productImageM->setVal( 'premium', 1 );
			$productImageM->setLimit( 1 );
			$productImageM->update();
		
	
		}

		WPages::redirect( 'controller=' . $controller . '&task=edit&eid=' . $pid );


		return true;


	}}