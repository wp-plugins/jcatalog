<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Item_Promotion_class extends WClasses {







	public function insertNewPromotion($pid,$ftdidA) {

		if ( empty($ftdidA) || empty($pid) ) return true;

		if ( !is_array($ftdidA) ) $ftdidA = array( $ftdidA );

		$itemFeaturedM = WModel::get( 'item.featured' );

				$itemFeaturedM->whereIn( 'ftdid', $ftdidA );
		$featuredA = $itemFeaturedM->load( 'ol', array( 'ftdid', 'featured', 'duration', 'location', 'credits' ) );

		$paid = WPref::load( 'PITEM_NODE_PROMOTIONPAID' );
		$status = '';

		$itemFeatureditemM = WModel::get( 'item.featureditem' );
		$orderedFeaturedA = array();
		foreach( $featuredA as $oneFeature ) $orderedFeaturedA[$oneFeature->ftdid] = $oneFeature;

				foreach( $ftdidA as $ftdid ) {
			$itemFeatureditemM->setVal( 'pid', $pid );
			$itemFeatureditemM->setVal( 'ftdid', $ftdid );

			if ( $paid ) {

				if ( WExtension::exist( 'subscription.node' ) ) {

					$subscriptionCheckC = WObject::get( 'subscription.check' );
					$subscriptionCheckC->credit2Deduct( $orderedFeaturedA[$oneFeature->ftdid]->credits );
					$subscriptionCheckC->restriction( 'vendors_promotion', $pid );

					if ( !$subscriptionCheckC->getStatus() ) {
						$this->userW('1405139921HXZR');
						$link = WPage::link( 'controller=subscription' );
						$SUBSCRIBE_LINK = '<a href="'.  $link .'">' . WText::t('1329161820RPTN') .'</a>';
						$this->userN('1405139921HXZS',array('$SUBSCRIBE_LINK'=>$SUBSCRIBE_LINK));
						continue;

					} else {
						$itemFeatureditemM->setVal( 'status', 9 );
					}
					$itemFeatureditemM->setVal( 'expiration', time() + $orderedFeaturedA[$oneFeature->ftdid]->duration * 86400 );	
				





				}
			}
			$itemFeatureditemM->setVal( $orderedFeaturedA[$oneFeature->ftdid]->location, 1 );
			$itemFeatureditemM->replace();
		}

		if ( !empty( $featuredA ) ) {
			$hasFeatured = false;
			foreach( $featuredA as $oneFeature ) {
				if ( !empty($oneFeature->featured) ) $hasFeatured = true;
			}
			if ( $hasFeatured ) {
				$itemM = WModel::get( 'item' );
				$itemM->whereE( 'pid', $pid );
				$itemM->setVal( 'featured', 1 );
				$itemM->update();
			}
		}

	}

}