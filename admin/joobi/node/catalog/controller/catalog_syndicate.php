<?php 

* @link joobi.co
* @license GNU GPLv3 */



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