<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Item_types_form_view extends Output_Forms_class {

	protected function prepareView() {



		$type = $this->getValue( 'type' );

		
		$eExtensionExist = WExtension::exist( 'vendors.node' );

		if ( !$eExtensionExist || empty($type) ) $this->removeElements( array( 'item_type_syndicate_fieldset', 'item_type_allowsyndication', 'item_type_allowresellers' ) );

		else {
						if ( $type == 11 || $type >= 100 ) $this->removeElements( array( 'item_type_allowresellers', 'item_type_reseller_discount', 'item_type_reseller_percent', 'item_type_reseller_rate', 'item_type_reselller_markup', 'item_type_reselller_percent', 'item_type_reselller_rate' ) );
			$allowSyndicate = WPref::load('PCATALOG_NODE_ALLOWSYNDICATION');
			if ( $allowSyndicate == 5 ) $allowSyndicate = 1;
			else  $allowSyndicate = 0;
			$allowResellers = PCATALOG_NODE_ALLOWRESELLERS;
			if ( $allowResellers == 5 ) $allowResellers = 1;
			else  $allowResellers = 0;
			if ( empty($allowSyndicate) ) $this->removeElements( array( 'item_type_allowsyndication' ) );
			if ( empty($allowResellers) ) {
				$this->removeElements( array( 'item_type_allowresellers', 'item_type_reseller_discount', 'item_type_reseller_percent', 'item_type_reseller_rate', 'item_type_reselller_markup', 'item_type_reselller_percent', 'item_type_reselller_rate' ) );
				if ( empty($allowSyndicate) ) $this->removeElements( array( 'item_type_syndicate_fieldset' ) );
			}
		}


		
		$auctionExtensionExist = WExtension::exist( 'auction.node' );

		if ( !$auctionExtensionExist || ( !in_array( $type, array( 0, 11) ) ) ) $this->removeElements( array('item_type_prdshowbid' ) );



		


		
		if ( $type > 30 ) {
			$this->removeElements( array('type_form_terms_checkout', 'item_types_form_item_type_payid' ) );
				} else {
							if ( ! WPref::load('PBASKET_NODE_PAYMENTITEMTYPE' ) || WPref::load( 'PBASKET_NODE_DIRECTPAY' ) ) $this->removeElements( array( 'item_types_form_item_type_payid' ) );
		}

				if ( WGlobals::checkCandy(50,true) ) {
			$this->removeElements( array( 'item_types_form_pageprdallowreview', 'item_types_form_pageprdshowreview', 'item_types_form_pageprdshowrating' ) );
		}
				$productExtensionExist = WExtension::exist( 'product.node' );
		if ( !$productExtensionExist ) $this->removeElements( array( 'item_type_product_node_can_view_price', 'item_type_product_node_can_buy' ) );




		return true;



	}
}