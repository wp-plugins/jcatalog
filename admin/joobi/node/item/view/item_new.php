<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Item_new_view extends Output_Forms_class {
protected function prepareView() {


	$productNodeExits = WExtension::exist( 'product.node' );
	$subscriptiontExtensionExist = WExtension::exist( 'subscription.node' );
	$auctionExtensionExist = WExtension::exist( 'auction.node' );

	if ( !$productNodeExits && !$subscriptiontExtensionExist && !$auctionExtensionExist ) $this->removeElements( array( 'item_new_delivery', 'item_new_pricing' ) );
	else {			$deliveryType = WPref::load('PPRODUCT_NODE_DELIVERYTYPE');
		if ( !empty( $deliveryType ) ) $this->removeElements( array( 'item_new_delivery', 'product_new_delivery' ) );
	}

	return true;



}}