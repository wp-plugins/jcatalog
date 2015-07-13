<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Item_Approval_class extends WClasses {




	public function emailRequestApproval($pid,$emailNamekey) {

		if ( empty($pid) ) return false;

		if ( !is_array($pid) ) $pid = array( $pid );

		$uid = WGlobals::get( 'uid' );
		$prodList = null;
						$vendorsEmailC = WClass::get( 'vendor.email' );
		$uidStoreManager = $vendorsEmailC->getStoreMangerContact( 'uid' );


				$param = new stdClass;
		$param->vendname = WUser::get( 'name', $uid );
		$param->sitename = JOOBI_SITE_NAME;
		$param->sitelink = '<a href="'. JOOBI_SITE .'">'. JOOBI_SITE .'</a>';

		static $productM = null;
		if ( empty( $productM ) ) $productM = WModel::get( 'product' );
		$productM->makeLJ( 'producttrans', 'pid', 'pid' );
		$productM->whereLanguage();
		$productM->whereIn( 'pid', $pid );
		$productM->select( 'pid', 0 );
		$productM->select( 'name', 1 );
		$prodList = $productM->load( 'ol');

		$prodHTML = '';
		foreach($prodList as $product){
			$prodHTML .=  '<a href="'. WPage::routeURL('controller=product&task=show&eid='. $product->pid ) .'">'. $product->name .'</a><br>';
		}		$param->products = $prodHTML;

		$vendMemC = WClass::get( 'vendor.email' );
		$vendMemC->sendNotification( $uidStoreManager, $emailNamekey, $param );

	}

}