<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Edit_controller extends WController {


function edit() {



	$eid = WGlobals::getEID();
	if ( empty($eid) ) $eid = WGlobals::get( 'pid' );

		if ( empty( $this->_eid ) ) {
		WGlobals::setEID( $eid );
		$this->_eid = WGlobals::getEID( true );
	}

	
	$productM = WModel::get( 'item' );

	$productM->makeLJ( 'item.type', 'prodtypid' );

	$productM->select( 'type', 1 );

	$productM->whereE( 'pid', $eid );


	$productDegination = $productM->load( 'lr' );

	$controller = WGlobals::get( 'controller' );

	
	switch ( $productDegination ) {

		case '5':				if ( $controller == 'catalog' ) WPages::redirect( 'controller=subscription&task=edit&eid=' . $eid );
			$this->setView( 'subscription_edit_item' );
			break;

		case '11':				if ( $controller == 'catalog' ) WPages::redirect( 'controller=auction&task=edit&eid=' . $eid );

			$this->setView( 'auction_edit_item' );

			break;

		case '7':				if ( $controller == 'catalog' ) WPages::redirect( 'controller=voucher&task=edit&eid=' . $eid );
			$this->setView( 'voucher_edit_item' );
			break;
		case '16':				if ( $controller == 'catalog' ) WPages::redirect( 'controller=classified&task=edit&eid=' . $eid );
			$this->setView( 'classified_edit_item' );
			break;
		case '17':	
			
			
		case '1':				if ( $controller == 'catalog' ) WPages::redirect( 'controller=product&task=edit&eid=' . $eid );
			$this->setView( 'product_edit_item' );

			break;

		case '100':	
		case '101':	
		case '121':	
			$this->setView( 'item_edit_item' );

			break;

		case '141':				if ( $controller == 'catalog' ) WPages::redirect( 'controller=download&task=edit&eid=' . $eid );

			$this->setView( 'download_edit_item' );

			break;

		default:

			if ( WRoles::isAdmin( 'storemanager' ) ) {

				$this->setView( 'item_edit_item' );

			} else {
				$this->userW('1298350856KAZP');

				WPages::redirect( 'controller=catalog' );

			}
			break;



	}

	return parent::edit();



}
}