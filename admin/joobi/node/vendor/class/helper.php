<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Vendor_Helper_class extends WClasses {






	public function loadVendSession() {
		static $onlyOnce = false;

		if ( $onlyOnce ) return true;
		$onlyOnce = true;

		if ( !isset( $_SESSION['jvendor'] ) ) {
						$_SESSION['jvendor'] = $this->getVendor();

		}
	}





	public function getDefault() {
		return $this->getVendorID( 0, true, false );
	}






	public function getVendor($vendid=0,$return='object') {
		static $vendors=array();

				if ( empty($vendid) ) {
			$vendid = $this->getDefault();
		}
				if ( is_array( $return ) ) {
			$cols = $return;
			$return = 'object';
		}
		if ( !isset( $vendors[$vendid] ) ) {

						static $vendorM = null;
			if ( !isset($vendorM) ) $vendorM = WModel::get( 'vendor' );
			$vendorM->makeLJ( 'vendortrans', 'vendid' );
			$vendorM->whereLanguage();

												$vendorM->select( 'name', 1, 'name2' );
			$vendorM->select( 'description', 1, 'description2' );

			$vendorM->select( '*', 0 );
			if ( is_numeric( $vendid ) ) $vendorM->whereE( 'vendid', $vendid );
			else $vendorM->whereE( 'namekey', $vendid );
			$vendors[$vendid] = $vendorM->load( 'o' );


			if ( empty($vendors[$vendid]) ) return null;

						if ( !empty($vendors[$vendid]->params) ) {
				WTools::getParams( $vendors[$vendid], 'params' );
			}
			$vendors[$vendid]->name = $vendors[$vendid]->name2;
			$vendors[$vendid]->description = $vendors[$vendid]->description2;

		}
		if ( 'object'==$return ) return $vendors[$vendid];
		elseif ( isset($vendors[$vendid]->$return) ) {
			return $vendors[$vendid]->$return;
		}
	}







	public function getVendorIDfromNamekey($namekey,$strict=false) {

		$vendorID = WModel::getElementData( 'vendor', $namekey, 'vendid' );

		if ( $strict ) return $vendorID;
		else {
			if ( empty($vendorID) ) {
				static $defaultVendid = null;
				if ( empty( $defaultVendid ) ) {
					$defaultVendid = $this->getVendorID( 0, true );
				}				return $defaultVendid;
			} else {
				return $vendorID;
			}		}
	}







	public function getVendorPaymentEmail($vendid) {

		$obj = new stdClass;

		$email = $this->getVendor( $vendid, 'paypal' );
		$obj->verifiedEmail = $this->getVendor( $vendid, 'paypalverified' );

		if ( empty($email) ) $email = $this->getVendor( $vendid, 'email' );
		if ( empty($email) ) {
			$email = WUser::get( $this->getVendor( $vendid, 'uid' ), 'email' );
			$obj->verifiedEmail = false;
		}
		$obj->email = $email;
		$obj->name = $this->getVendor( $vendid, 'name' );

		return $obj;

	}






	public function getImage($vendid=1) {
		$imgPath=null;
		static $vendors=array();

		if ( !isset($vendors[$vendid]) ) {

						static $vendorM=null;
			if (empty($vendorM)) $vendorM = WModel::get( 'vendor' );
			$vendorM->makeLJ( 'files', 'filid', 'filid', 0, 1);
			$vendorM->select( 'name', 1);
			$vendorM->select( 'path', 1);
			$vendorM->select( 'type', 1);
			$vendorM->whereE( 'vendid', $vendid );
			$vendorImage = $vendorM->load( 'o' );

						if ( !empty($vendorImage) && !empty($vendorImage->path))
			{
				$correctPath = implode( '/', explode('|', $vendorImage->path));
				$imgPath = JOOBI_URL_MEDIA . $correctPath . '/' . $vendorImage->name .'.'. $vendorImage->type;
			}		}
		return $imgPath;
	}





	public function showImage($vendid=1) {

		$PVENDOR_NODE_VENDORIMAGE = WPref::load( 'PVENDOR_NODE_VENDORIMAGE' );

		if ( $PVENDOR_NODE_VENDORIMAGE ) {
			static $vendors=array();

			if ( isset($vendors[$vendid]) ) {
				return $vendors[$vendid];
			}
						$imgHeight = WPref::load( 'PVENDORS_NODE_SMALLIH' );
			if ( $imgHeight <= 0 ) $imgHeight = 10;

			$imgWidth = WPref::load( 'PVENDORS_NODE_SMALLIW' );				if ( $imgWidth <= 0 ) $imgWidth = 10;

						$imgPath = $this->getImage($vendid);

						if ( !empty($imgPath) ) {

				$data = WPage::newBluePrint( 'image' );
				$data->location = $imgPath;
				$data->width = $imgWidth;
				$data->height = $imgHeight;
				$vendors[$vendid] = WPage::renderBluePrint( 'image', $data );
				
				return $vendors[$vendid];
			}		}
		return null;

	}





	public function getCurrency($vendid=1) {
		static $vendorA=array();

				if ( !isset( $vendorA[$vendid] ) ) {
			static $vendorM=null;
			if ( !isset($vendorM)) $vendorM = WModel::get( 'vendor' );
			$vendorM->whereE( 'vendid', $vendid );
			$vendorA[$vendid] = $vendorM->load( 'r', 'curid' );
		}
		return $vendorA[$vendid];
	}










	public function getVendorID($uid=0,$defaultAdmin=false,$checkRole=true) {
		static $vendor=array();

		$currentUID = WUser::get( 'uid' );
				if ( empty($uid) ) {
			if ( !$defaultAdmin ) $uid = $currentUID;
		}
				if ( $checkRole && $uid == $currentUID ) {
						if ( ! WRole::hasRole( 'vendor', $uid ) ) return false;
		}

		if ( !isset( $vendor[$uid]) ) {

			static $vendorM=null;
			if ( empty($vendorM) ) $vendorM = WModel::get( 'vendor' );

			$vendorID = 0;
			if ( !empty($uid) ) {
				$vendorM->whereE( 'uid', $uid );
				$vendorID = $vendorM->load( 'lr', 'vendid' );
			}
						if ( empty($vendorID) && $defaultAdmin ) {
				$vendorM->whereE( 'premium', 1 );
				$vendorID = $vendorM->load( 'r', 'vendid' );
				if ( empty($vendorID) ) $vendorID = 1;	
			} elseif ( empty($vendorID) ) {
								return 0;
			}
			$vendor[$uid] = $vendorID;

		}
		return $vendor[$uid];

	}






	public function getVendorLocation($vendid=0) {

		$vendor = $this->getVendor( $vendid );

		$addressA = array();
		if ( !empty($vendor->originaddress) ) $addressA[] = $vendor->originaddress;
		if ( !empty($vendor->originaddress2) ) $addressA[] = $vendor->originaddress2;
		if ( !empty($vendor->origincity) ) $addressA[] = $vendor->origincity;
		$cityA = array();
		if ( !empty($vendor->originstate) ) $cityA[] = $vendor->originstate;
		if ( !empty($vendor->originzipcode) ) $cityA[] = $vendor->originzipcode;
		if ( !empty($cityA) ) $addressA[] = implode( ' ', $cityA );
		if ( !empty($vendor->originctyid) ) {
			$countriesHelperC = WClass::get( 'countries.helper', null, 'class', false );
			$addressA[] = $countriesHelperC->getData( $vendor->originctyid, 'name' );
		}
		if ( !empty($addressA) ) return implode( ', ', $addressA );
		return '';

	}








	public function showVendName($vendid=0,$uid=0,$link=null) {
		static $resultA = array();

		if ( empty($vendid) ) return false;


		if ( !isset( $resultA[ $vendid ] ) ) $resultA[ $vendid ] = $this->getVendor($vendid);
		$vendorO = $resultA[ $vendid ];

		

		if ( empty($uid) ) {
			$uid = ( !empty($vendorO->uid) ) ? $vendorO->uid : 0;
		}
						$vendor = ( isset( $vendorO->name ) && !empty( $vendorO->name ) ) ? $vendorO->name : WUser::get('name', $uid);


		switch ( WPref::load( 'PCATALOG_NODE_PAGEPRDVENDLINK' ) ) {
			case 'vendor' :
				$link = 'controller=vendors&task=home&eid='. $vendid;
				$vendor = '<a href="'. WPage::routeURL( $link ) .'">'. $vendor .'</a>';
				break;
			case 'jomsocial' :
				$jomID = WUser::get( 'id', $vendorO->uid );
				$link = 'index.php?option=com_community&view=profile&userid='. $jomID;
				$vendor = '<a href="'. WPage::routeURL( $link ) .'">'. $vendor .'</a>';
				break;
			default :
				$vendor = '';
				break;
		}
		return $vendor;

	}





public function blockStatus($vendid) {
	static $resultA=array();
	$status = 0;

	if ( !isset( $resultA[$vendid] ) ) {
		static $vendorM=null;
		if ( !isset($vendorM) ) $vendorM = WModel::get( 'vendor' );
		$vendorM->whereE( 'vendid', $vendid );
		$statusO = $vendorM->load( 'o', array( 'publish', 'premium' ) );
		$block = true;
		if ( empty($statusO->premium) ) $block = false;
		else {
			if ( empty($statusO->publish) ) $block = false;
		}		$resultA[$vendid] = $block;
	}
	return $resultA[$vendid];
}





public function setStatus($vendid,$status) {

	static $vendorM=null;
	if ( !isset($vendorM) ) $vendorM = WModel::get( 'vendor' );
	$vendorM->setVal( 'publish', $status );
	$vendorM->whereE( 'vendid', $vendid );
	$vendorM->update();

	return true;
}





public function isVendor($vendid) {
	static $resultA=array();

	if ( !isset($resultA[$vendid]) )
	{
		static $vendorM=null;
		if ( !isset($vendorM) ) $vendorM = WModel::get( 'vendor' );
		$vendorM->whereE( 'vendid', $vendid );
		$result = $vendorM->load( 'lr', 'vendid' );

		$resultA[$vendid] = ( !empty($result) && ( $result > 0 ) ) ? true : false;
	}
	return $resultA[$vendid];
}









public function traceVendor() {

   if ( WRoles::isAdmin( 'storemanager' ) ) return 0;
   else {
   		$uid = WUser::get('uid');

   				 		static $userRoleA = array();
 		if ( !isset( $userRoleA[ $uid ] ) ) {
 			$roleC = WRole::get();
			$userRoleA[ $uid ] = WRole::hasRole( 'storemanager' );
 		} 		if ( $userRoleA[ $uid ] ) {
 			 			 			 						return 0;
		}
   		static $vendidA = null;
   		if ( !isset( $vendidA[ $uid ] ) && !empty( $uid ) ) {
			$vendorHelperC = WClass::get( 'vendor.helper', null, 'class', false );
			if ( !empty($vendorHelperC) ) $vendidA[ $uid ] = $vendorHelperC->getVendorID( $uid );
		}
		return isset( $vendidA[ $uid ] ) ? $vendidA[ $uid ] : 0;
  }
}






	public function getMainCategory($vendid=1) {
		static $vendorCat=array();

				if ( !isset( $vendorCat[$vendid] ) ) {
			static $prodCatM=null;
			if ( !isset($prodCatM)) $prodCatM = WModel::get( 'item.category' );
			$prodCatM->whereE( 'vendid', $vendid );
			$prodCatM->orderBy('lft', 'ASC');
			$vendorCat[$vendid] = $prodCatM->load( 'lr', 'namekey' );
		}
		return $vendorCat[$vendid];
	}

}