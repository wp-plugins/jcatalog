<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Item_Terms_model extends WModel {


	public function addValidate() {



		$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

		$this->vendid = $vendorHelperC->getVendorID();



		return true;



	}







	public function validate() {



		$this->core = 0;



		return true;



	}









	public function isOwner() {

		$pKey = $this->getPK();
		$eid = $this->$pKey;

		if ( empty($eid) ) return false;

		$roleHelper = WRole::get();
		$storeManagerRole = WRole::hasRole( 'storemanager' );
		if ( !empty( $storeManagerRole ) ) return true;

		$vendorHelperC = WClass::get( 'vendor.helper' );
		$vendid = $vendorHelperC->getVendorID();

		$itemM = WModel::get( $this->getModelID() );

		if ( is_array($eid) ) $itemM->whereIn( $this->getPK(), $eid );
		else $itemM->whereE( $this->getPK(), $eid );
		$itemM->whereE( 'vendid', $vendid );

		return $itemM->exist();

	}















	public function secureTranslation($sid,$eid) {



		$translationC = WClass::get( 'item.translation', null, 'class', false );

		if ( empty($translationC) ) return false;



		
		if ( !$translationC->secureTranslation( $this, $sid, $eid ) ) return false;

		return true;



	}
}