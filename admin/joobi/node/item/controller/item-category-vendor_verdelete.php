<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_category_vendor_verdelete_controller extends WController {
function verdelete() {



	
	$roleC = WRole::get();

	$status = WRole::hasRole( 'sadmin' );



	if ( $status ) {

		
		$catid = WGlobals::getEID();

		$uid = WGlobals::get( 'id' );

		$name = WUser::get( 'name', $uid );

		$TEXT = WText::t('1228709810QIOH');



		$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

		$vendid = $vendorHelperC->getVendorID( $uid );



		if ( !empty($catid) && !empty($uid) )

		{

			$catName = '';

			$categoryM = WModel::get( 'item.category' );

			$categoryM->whereE( 'catid', $catid );

			$categoryM->whereE( 'vendid', $vendid );

			$result = $categoryM->delete();



			if ( $result )

			{

				$catTransM = WModel::get( 'item.categorytrans' );

				$catTransM->whereE( 'catid', $catid );

				$catName = $catTransM->load( 'lr', 'name' );



				$catTransM->whereE( 'catid', $catid );

				$catTransM->delete();

			}
		}


		
		$param = new stdClass;

		$param->prodName = $catName;

		$param->vendName = $name;

		$param->type = $TEXT;



		
		$emailNamekey = 'vendor_product_delete_notification';



		$vendMemC = WClass::get( 'vendor.email', null, 'class', false );

		if ( !empty($vendMemC) ) $vendMemC->sendNotification( $uid, $emailNamekey, $param );



		$message = WMessage::get();

		$message->adminS( 'Successfully deleted '. $TEXT );



		WPages::redirect( 'controller=vendors-category&task=listing&vendid='. $vendid .'&uid='. $uid .'&titleheader='. $name );

	}


	WPages::redirect( 'controller=vendors&task=listing' );

	return true;

}}