<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Item_Featured_scheduler extends Scheduler_Parent_class {







	function process() {


		$featuredvendors = WPref::load( 'PVENDORS_NODE_FEATUREDVENDORS' );
		if ( empty($featuredvendors) ) return false;

		$this->_unFeaturedItems();


		$this->_unNotifyVendorsOfUpcomingExpiration();


		return true;


	}





	private function _unFeaturedItems() {

		$featuredDelay = WPref::load( 'PVENDORS_NODE_FEATUREDDURATION' ) * 3600;			$vendorHelperC = WClass::get( 'vendor.helper' );
		$storeMangerID = $vendorHelperC->getDefault();


						$itemM = WModel::get( 'item' );
		$itemM->whereE( 'featured', 1 );
		$itemM->where( 'featuredate', '<', time() - $featuredDelay );
		$itemM->whereE( 'vendid', '!=', $storeMangerID );
		$itemM->setVal( 'featured', 0 );
		$itemM->update();

	}





	private function _unNotifyVendorsOfUpcomingExpiration() {

		$unpublishnotify = WPref::load( 'PVENDORS_NODE_FEATUREDNOTIFY' );
		if ( empty($unpublishnotify) ) return false;


				$publishnotifydelay = WPref::load( 'PVENDORS_NODE_FEATUREDNOTIFYDELAY' ) * 3600;

		$frequencyHalf = $this->element->frequency / 2;

		$minDelay = time() - $publishnotifydelay - $frequencyHalf;
		$maxDelay = time() - $publishnotifydelay + $frequencyHalf;

		$itemM = WModel::get( 'item' );
		$itemM->whereE( 'publish', 1 );
		$itemM->where( 'modified', '<', $maxDelay );
		$itemM->where( 'modified', '>', $minDelay );
		$itemM->whereE( 'vendid', '!=', $storeMangerID );
		$listOfVendorsItemsA = $itemM->load( 'ol', array( 'vendid', 'pid') );

		if ( empty($listOfVendorsItemsA) ) return true;

		$newSortedVendorItemsA = array();
				foreach( $listOfVendorsItemsA as $oneHHH ) {
			$newSortedVendorItemsA[$oneHHH->vendid][] = $oneHHH->pid;
		}

		$emailParams = new stdClass;
		$link = 'controller=catalog&task=edit&eid=';
		$itemEmailItemsTransC = WClass::get( 'item.emailitemstrans' );
		$itemEmailItemsTransC->emailListOfItems( $newSortedVendorItemsA, 'item_notify_featured', $link, $emailParams );

	}

}