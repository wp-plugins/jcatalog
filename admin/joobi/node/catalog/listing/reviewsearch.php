<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_CoreReviewsearch_listing extends WListings_default{
	function create() {

		static $jFeedbackExtensionExist = null;

		if ( WGlobals::checkCandy(50,true) ) return true;


		$nbreviews = $this->getValue( 'nbreviews' );

		$comment = $this->getValue( 'pageprdallowreview' );
		$prodtypid = $this->getValue( 'prodtypid' );

		if ( $comment == 2 ) {				static $itemTypeC = null;
			if ( !isset($itemTypeC) ) $itemTypeC = WClass::get('item.type');
			$comment = $itemTypeC->loadData( $prodtypid, 'pageprdallowreview' );
		}		if ( $comment == 5 ) {				if ( !defined('PCATALOG_NODE_PAGEPRDALLOWREVIEW') ) WPref::get( 'catalog.node' );
			$comment = PCATALOG_NODE_PAGEPRDALLOWREVIEW;
		}


		if ( empty($comment) ) return true;



		if ( !empty( $nbreviews ) ) {

			$reviewsText = ( empty($nbreviews) ||  $nbreviews == 1 ) ? WText::t('1304253943KWEJ') : WText::t('1257243218GPNH');

			$link = WPage::link( 'controller=catalog&task=show&eid=' . $this->getValue( 'pid' ) . '#reiews' );
			$this->content = '<a href="'.$link.'">'. $nbreviews .' '. $reviewsText . '</a>';
		}




		return true;

	}
}