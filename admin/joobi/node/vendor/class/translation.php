<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Vendor_Translation_class extends WClasses {






	
	public function secureTranslation($itemO,$sid,$eid) {

		$uid = WUser::get( 'uid' );
		if ( empty($uid) ) return false;
		
						$roleHelper = WRole::get();
		if ( WRole::hasRole( 'storemanager' ) ) return true;

		if ( !WRole::hasRole( 'vendor' ) ) return false;
		
				$vendorHelperC = WClass::get('vendor.helper',null,'class',false);				
		$vendid = $vendorHelperC->getVendorID( $uid );
		if ( empty($vendid) ) return false;
		
		if ( $eid == $vendid ) return true;		
		
		return false;
		
	}	
	
}