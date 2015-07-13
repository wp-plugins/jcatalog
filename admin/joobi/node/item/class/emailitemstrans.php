<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

class Item_Emailitemstrans_class extends WClasses {








	public function emailListOfItems($listOfVendorsItems,$emailNamekey,$link='',$emailParams=null) {

		if ( empty($listOfVendorsItems) || empty($emailNamekey) ) return false;

		$vendorHelperC = WClass::get( 'vendor.helper',null,'class',false );
		$mailM = WMail::get();
		if ( empty($link) ) $link = 'controller=catalog&task=show&eid=';

		foreach( $listOfVendorsItems as $vendid => $allProducts ) {

			$vendorUID = $vendorHelperC->getVendor( $vendid, 'uid' );
			$vendorLangage = WUser::get( 'lgid', $vendorUID );
			$mainSiteLangage = WApplication::mainLanguage( 'lgid' );
			if ( empty($vendorLangage) ) $vendorLangage = 1;
			if ( empty($mainSiteLangage) ) $mainSiteLangage = 1;

						$itemM = WModel::get( 'itemtrans' );
			$itemM->whereIn( 'pid', $allProducts );
			$itemM->whereE( 'lgid', $vendorLangage, 0, 1, 0 );
			$itemM->whereE( 'lgid', $mainSiteLangage, 0, null, 1, 1 );
			$allTranslationA = $itemM->load( 'ol', array( 'name', 'pid', 'lgid' ) );

			if ( empty($allTranslationA) ) continue;
			
			$HTML = '';
			$newOneA = array();
			foreach( $allTranslationA as $oneProduct ) {
				$newOneA[$oneProduct->pid][$oneProduct->lgid] = $oneProduct->name;
			}
			foreach( $newOneA as $pid => $oneProduct ) {

				if ( !empty( $oneProduct[$vendorLangage] ) ) $name = $oneProduct[$vendorLangage];
				else $name = $oneProduct[$mainSiteLangage];

				$linkFormatted = WPage::linkHome( $link . $pid );
				$html .= '<a href"' . $linkFormatted . '">' . $name . '</a><br />';

			}
			$emailParams->relisted = $html;
			$mailM->setParameters( $emailParams );

			$mailM->sendSchedule( $vendorUID, $emailNamekey, 0, null, 300, false );

		}
	}


}