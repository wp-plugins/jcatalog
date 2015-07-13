<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_nuevo_controller extends WController {

	function nuevo() {



				$myController = WGlobals::get( 'controller' );
		if ( $myController == 'order-products' ) $myController = 'product';

				if ( $myController == 'catalog' ) $myController = '';

		$itemQueryC = WClass::get( 'item.query' );
		$total = $itemQueryC->count( true, $myController );
		$categoryID = WGlobals::get( 'categoryid' );
		$prodtypid = WGlobals::get( 'prodtypid' );

		$productNodeExits = WExtension::exist( 'product.node' );
		if ( $productNodeExits ) $this->setView( 'product_new' );


		if ( empty($total) ) {
			$message = WMessage::get();
			$message->userE('1327273916WPA');
			WPages::redirect( 'previous' );
		} elseif ( $total == 1 ) {

												$this->_checkRestriction();

						$typePublished = $itemQueryC->getPublishedType();
			$link = 'controller=' . $typePublished . '&task=add';
			if ( !empty($prodtypid) ) $link .= '&prodtypid=' . $prodtypid;
			if ( !empty($categoryID) ) $link .= '&categoryid=' . $categoryID;

			WPages::redirect( $link );

		} else {

												$this->_checkRestriction();

			
						if ( !empty($prodtypid) ) {
				$itemTypeC = WClass::get('item.type');
				$itemDesignation = $itemTypeC->loadData( $prodtypid, 'type' );

								$itemDesignationT = WType::get( 'item.designation' );
				$controller2Use = strtolower( $itemDesignationT->getName( $itemDesignation ) );
								if ( empty( $controller2Use ) ) {
					$controller2Use = 'item';
				}
				$link = 'controller=' . $controller2Use . '&task=add&=prodtypid' . $prodtypid;
				if ( !empty($categoryID) ) $link .= '&categoryid=' . $categoryID;

				WPages::redirect( $link );

			}
		}

		$downloadNodeExits = WExtension::exist( 'download.node' );
				if ( !$productNodeExits && $downloadNodeExits ) {
			$link = 'controller=download&task=add';
			if ( !empty($prodtypid) ) $link .= '&prodtypid=' . $prodtypid;
			if ( !empty($categoryID) ) $link .= '&categoryid=' . $categoryID;
			WPages::redirect( $link );
		}


		return true;



	}





	private function _checkRestriction() {

 			$integrate = WPref::load( 'PCATALOG_NODE_SUBSCRIPTION_INTEGRATION' );

 			 			if ( $integrate && WExtension::exist( 'subscription.node' ) ) {
 				$subscriptionCatalogrestrictionC = WClass::get( 'subscription.catalogrestriction' );
 				$subscriptionCatalogrestrictionC->itemCreate( true );
 			}
	}
}