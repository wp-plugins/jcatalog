<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Item_Unpublish_scheduler extends Scheduler_Parent_class {







	function process() {


		$unpublishautomatic = WPref::load( 'PVENDORS_NODE_UNPUBLISHAUTOMATIC' );
		if ( empty($unpublishautomatic) ) return false;

		$this->_unPublishItems();


		$this->_unNotifyVendorsOfUpcomingExpiration();


		return true;


	}





	private function _unPublishItems() {


		$featuredDelay = WPref::load( 'PVENDORS_NODE_PUBLISHDURATION' ) * 3600;	
		$vendorHelperC = WClass::get( 'vendor.helper' );
		$storeMangerID = $vendorHelperC->getDefault();


						$itemM = WModel::get( 'item' );
		$itemM->whereE( 'publish', 1 );
		$itemM->where( 'modified', '<', time() - $featuredDelay );
		$itemM->where( 'vendid', '!=', $storeMangerID );
		$itemM->setVal( 'publish', 0 );
		$itemM->update();

	}





	private function _unNotifyVendorsOfUpcomingExpiration() {

		$unpublishnotify = WPref::load( 'PVENDORS_NODE_UNPUBLISHNOTIFY' );
		if ( empty($unpublishnotify) ) return false;


				$publishnotifydelay = WPref::load( 'PVENDORS_NODE_FEATUREDNOTIFYDELAY' ) * 3600;

		$frequencyHalf = $this->element->frequency / 2;

		$minDelay = time() - $publishnotifydelay - $frequencyHalf;
		$maxDelay = time() - $publishnotifydelay + $frequencyHalf;

		$itemM = WModel::get( 'item' );
		$itemM->whereE( 'publish', 1 );
		$itemM->where( 'modified', '<', $maxDelay );
		$itemM->where( 'modified', '>', $minDelay );
		$itemM->where( 'vendid', '!=', $storeMangerID );
		$listOfVendorsItemsA = $itemM->load( 'ol', array( 'vendid', 'pid') );

		if ( empty($listOfVendorsItemsA) ) return true;

		$newSortedVendorItemsA = array();
				foreach( $listOfVendorsItemsA as $oneHHH ) {
			$newSortedVendorItemsA[$oneHHH->vendid][] = $oneHHH->pid;
		}

		$emailParams = new stdClass;
		$link = 'controller=catalog&task=edit&eid=';
		$itemEmailItemsTransC = WClass::get( 'item.emailitemstrans' );
		$itemEmailItemsTransC->emailListOfItems( $newSortedVendorItemsA, 'item_notify_unpublish', $link, $emailParams );

	}

}