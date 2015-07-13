<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_vendor_verification_controller extends WController {




function verification() {



	
	$roleC = WRole::get();

	$status = WRole::hasRole( 'sadmin' );



	if ( $status ) {



		
		$pid = WGlobals::getEID();








		
		$producttransM = WModel::get( 'item' );

		$producttransM->makeLJ( 'itemtrans', 'pid' );
		$producttransM->select( 'name', 1 );
		$producttransM->whereE( 'pid', $pid );

		$itemObj = $producttransM->load( 'o', 'uid' );


		$prodName = $itemObj->name;
		$uid = $itemObj->uid;


		
		$name = WUser::get( 'name', $uid );



		
		$productM = WModel::get( 'product' );

		$productM->setVal( 'blocked', 0 );

		$productM->whereE( 'pid', $pid );


		$productM->update();



		
		$param = new stdClass;


		$param->itemName = $prodName;

		$param->name = $name;



		
		$emailNamekey = 'vendor_item_approval_notification';



		$vendMemC = WClass::get( 'vendor.email', null, 'class', false );

		if ( !empty($vendMemC) ) $vendMemC->sendNotification( $uid, $emailNamekey, $param );



		$message = WMessage::get();

		$message->adminS( 'Successfully approved item!' );



	}


	WPages::redirect( 'controller=item&search=' . $pid );



	return true;

}}