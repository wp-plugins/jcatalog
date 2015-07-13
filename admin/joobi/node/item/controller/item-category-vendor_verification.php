<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_category_vendor_verification_controller extends WController {


function verification() {

	
	$roleC = WRole::get();

	$status = WRole::hasRole( 'sadmin' );



	if ( $status ) {


		
		$catid = WGlobals::getEID();






		
		$cattransM = WModel::get( 'item.category' );
		$cattransM->makeLJ( 'item.categorytrans', 'catid' );
		$cattransM->whereLanguage();

		$cattransM->whereE( 'catid', $catid );
		$cattransM->select( 'name', 1 );

		$catObj5 = $cattransM->load( 'o', 'uid' );


		$catName = $catObj5->name;

		
		$uid = $catObj5->uid;
		$name = WUser::get( 'name', $uid );



		
		$categoryM = WModel::get( 'item.category' );

		$categoryM->setVal( 'blocked', 0 );

		$categoryM->whereE( 'catid', $catid );


		$categoryM->update();



		
		$param = new stdClass;


		$param->categoryName = $catName;

		$param->name = $name;



		
		$emailNamekey = 'vendor_item_category_approval_notification';



		$vendMemC = WClass::get( 'vendor.email', null, 'class', false );

		if ( !empty($vendMemC) ) $vendMemC->sendNotification( $uid, $emailNamekey, $param );



		$message = WMessage::get();

		$message->adminS( 'Successfully approved category!' );


	}


	WPages::redirect( 'controller=item-category&search=' . $catid );


	return true;

}}