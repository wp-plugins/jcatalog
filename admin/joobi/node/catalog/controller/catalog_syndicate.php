<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Catalog_syndicate_controller extends WController {

	function syndicate() {



		
		$vendorC = WClass::get( 'vendor.helper' );

		$uid = WUser::get('uid');

		$vendid = $vendorC->getVendorID($uid);

		$pid = $this->getFormValue( 'eid' );




		if ( !empty($vendid) && !empty($pid) ) {

			$catid = $this->getFormValue( 'catid' );
						$itemSyndicateC = WClass::get( 'item.syndicate' );
			$itemSyndicateC->syndicateToItem( $pid, $vendid, $catid );


		}


		WPages::redirect('previous');



		return true;



	}
}