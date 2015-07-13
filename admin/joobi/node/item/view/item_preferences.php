<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Item_preferences_view extends Output_Forms_class {
protected function prepareView() {



		
		$productExtensionExist = WExtension::exist( 'product.node' );

		if ( !$productExtensionExist ) $this->removeElements( array('catalog_preferences_product_nocheckoutdl', 'catalog_preferences_product_price_options', 'catalog_preferences_integration_googlefeed', 'catalog_preferences_shipping_method',

										'item_preferences_product_node_can_view_price', 'item_preferences_product_node_can_buy' ) );



		
		$subscriptiontExtensionExist = WExtension::exist( 'subscription.node' );

		if ( !$subscriptiontExtensionExist ) $this->removeElements( array('catalog_preferences_integration_subscription') );



		
		$auctionExtensionExist = WExtension::exist( 'auction.node' );

		if ( !$auctionExtensionExist ) $this->removeElements( array('catalog_preferences_crslshowbid', 'catalog_preferences_itmshowbid', 'catalog_preferences_catcrslshowbid', 'catalog_preferences_catitmshowbid', 'catalog_preferences_prdshowbid' ) );





		
		$vendorsExtensionExist = WExtension::exist( 'vendors.node' );



		if ( !$vendorsExtensionExist ) {

			$this->removeElements( array( 'catalog_preferences_vendor_layout', 'catalog_preferences_item_vendor_fieldset', 'catalog_preferences_category_vendors_fieldset', 'catalog_preferences_home_vendors_fieldset', 'item_preferences_categorylayout_vendors_fieldset',

				'catalog_preferences_home_carrousel_show_vendor', 'catalog_preferences_home_items_show_vendor', 'catalog_preferences_category_carrousel_show_vendor', 'catalog_preferences_category_items_show_vendor',

				'item_preferences_itemlayout_show_vendor','item_preferences_itemlayout_show_vendor_rating', 'item_preferences_itemlayout_show_vendor_link', 'item_preferences_itemlayout_related_show_vendor', 'item_preferences_itemlayout_bundle_show_vendor',

				'item_preferences_catalog_node_searchvendor', 'item_preferences_vendors_map'	
			) );



			
			$this->removeElements( 'item_preferences_item_node_vendorfeatured' );



			
			$this->removeElements( array( 'item_preferences_item_node_unpublishautomatic', 'item_preferences_item_node_unpublishnotify', 'item_preferences_item_node_publishnotifydelay', 'item_preferences_item_node_publishduration' ) );



		}


		
		if ( !$vendorsExtensionExist || !$productExtensionExist ) $this->removeElements( array('item_preferences_product_node_price_min', 'item_preferences_product_node_price_max') );



		


		if ( WGlobals::checkCandy(50,true) ) {

			$this->removeElements( array( 'item_preferences_catalog_node_pageprdallowreview', 'item_preferences_catalog_node_pageprdshowreview', 'item_preferences_catalog_node_pageprdshowrating' ) );

		}


		
		if ( !$productExtensionExist && !$subscriptiontExtensionExist && !$auctionExtensionExist ) {

			$this->removeElements( 'catalog_preferences_delivery_type' );

		}


		$itemWallC = WClass::get( 'item.wall' );

		if ( false && !$itemWallC->available() ) {

			$JomSocialFieldA = array( 'wall', 'wallitemviews', 'wallcategoryviews',  'wallitemcomment', 'wallitemfavorite', 'wallitemwatch', 'wallitemwish','wallitemsharewall', 'wallitemlikedislike', 'wallitemfieldset',

			'wallcategoryviews', 'wallcategoryviews',  'wallcategoryfavorite', 'wallcategorywatch', 'wallcategorysharewall', 'wallcategorylikedislike', 'wallcategoryfieldset',

			'wallvendorviews', 'wallvendorcomment', 'wallvendorfavorite', 'wallvendorwatch', 'wallvendorwish', 'wallvendorsharewall', 'wallvendorlikedislike', 'wallvendorfieldset' );

			$orign = 'catalog_preferences_integration_jomsocial';

			$myArray = array();

			$myArray[] = $orign;

			foreach( $JomSocialFieldA as $oneField ) {

				$myArray[] = $orign . '_' . $oneField;

			}
			$this->removeElements( $myArray );

		}


				$subscriptionExtensionExist = WExtension::exist( 'subscription.node' );
		$promotion = WPref::load( 'PITEM_NODE_PROMOTIONUSE' );
		if ( !$subscriptionExtensionExist || !$promotion ) $this->removeElements( array('item_preferences_item_node_promotionpaid' ) );



		return true;



	}
}