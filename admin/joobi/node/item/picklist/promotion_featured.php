<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Promotion_featured_picklist extends WPicklist {

	function create() {

				$itemFeaturedM = WModel::get( 'item.featured' );
		$itemFeaturedM->whereE( 'publish', 1 );
		$itemFeaturedM->checkAccess();
		$allFeaturedA = $itemFeaturedM->load( 'ol', array( 'alias', 'ftdid' ) );

		if ( !empty($allFeaturedA) ) {
			foreach( $allFeaturedA as $oneFeatured ) {
				$this->addElement( $oneFeatured->ftdid, $oneFeatured->alias );
			}		}
		$eid = WGlobals::getEID();
				$itemFeatureditemM = WModel::get( 'item.featureditem' );
		$itemFeatureditemM->whereE( 'pid', $eid );
		$existingA = $itemFeatureditemM->load( 'lra', 'ftdid' );
		$this->setDefault( $existingA, true );

		return true;

	}
}