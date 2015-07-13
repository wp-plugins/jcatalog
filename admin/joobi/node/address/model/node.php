<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_Node_model extends WModel {






	function addValidate() {



		if ( empty($this->uid) ) $this->uid = WUser::get('uid');

		$this->vendid = WGlobals::get('vendid');

		if ( empty($this->vendid) ) {

			if ( WExtension::exist( 'vendor.node' ) ) {

				$vendorHelperC = WClass::get('vendor.helper',null,'class',false);

				if ( !empty( $this->uid ) ) $this->vendid = $vendorHelperC->getVendorID( $this->uid );

			}
		}


		$this->setChild( 'address.members', 'uid', $this->uid );

		$this->setChild( 'address.members', 'ordering', 99 );





		
		$addressM = WModel::get( 'address' );

		$addressM->whereE( 'uid', $this->uid );

		$addressM->whereE( 'premium', 1 );

		$premiumExist = $addressM->exist();

		if ( empty($premiumExist) ) $this->premium = 1;



		return true;



	}












	function editValidate() {



		
		$this->longitude = 0;

		$this->latitude = 0;

		$this->found = 0;

		$this->lastcheck = 0;

		$this->mapservice = 0;



		return true;



	}










	function validate() {



		
		if ( !empty($this->premium) ) {

			if ( empty($this->uid) ) $this->uid = WUser::get('uid');

			$otherAddressM = WModel::get( 'address' );

			$otherAddressM->setVal( 'premium', 0 );

			$otherAddressM->whereE( 'uid', $this->uid );

			$otherAddressM->whereE( 'premium', 1 );

			$otherAddressM->update();

		}




		
		if ( !empty($this->state) && !empty( $this->ctyid) && empty( $this->stateid ) ) {

			$statesM = WModel::get( 'countries.states' );

			$statesM->whereE( 'ctyid', $this->ctyid );

			$statesM->openBracket();

			$statesM->whereE( 'code2', $this->state );

			$statesM->operator('OR');

			$statesM->whereE( 'namekey', str_replace( ' ', '_', $this->state ) );

			$statesM->closeBracket();

			$stateid = $statesM->load( 'lr', 'stateid' );

			if ( !empty($stateid) ) $this->stateid = $stateid;

		}

		
		if ( empty( $this->state ) && !empty($this->stateid) ) {

			$statesM = WModel::get( 'countries.states' );

			$statesM->whereE( 'stateid', $this->stateid );

			$this->state = $statesM->load( 'lr', 'code2' );

		}


		$addressNamekeyC = WClass::get( 'address.location' );

		$this->location = $addressNamekeyC->createAddressLocation( $this );



		return true;



	}














	function deleteValidate($eid=0) {

		$this->_x = $this->load( $eid );

		return true;

	}














	function deleteExtra($eid=0) {





		if ( !empty($this->_x->premium) ) {

			
			
			$this->whereE( 'uid', $this->_x->uid );

			$this->orderBy( 'modified', 'DESC' );

			$newPremiumID = $this->load( 'lr', 'adid' );



			if ( !empty($newPremiumID) ) {

				$this->whereE( 'adid', $newPremiumID );

				$this->setVal( 'premium', 1 );

				$this->update();

			}
		}


		return true;

	}}