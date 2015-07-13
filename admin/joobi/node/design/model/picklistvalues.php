<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Design_Picklistvalues_model extends WModel {












	function validate() {

		
		$this->core = 0;



		
		$picklistM = WModel::get( 'design.picklist' );

		$picklistM->whereE( 'did', $this->did );

		$picklistM->setVal( 'core', 0 );

		$picklistM->update();



		if ( !empty( $this->premium) && !empty($this->did) ) {
						$designPicklistvaluesM = WModel::get( 'design.picklistvalues' );
			$designPicklistvaluesM->whereE( 'did', $this->did );
			$designPicklistvaluesM->setVal( 'premium', 0 );
			$designPicklistvaluesM->update();
		}
		if ( !empty( $this->inputbox) && !empty($this->did) ) {
						$designPicklistvaluesM = WModel::get( 'design.picklistvalues' );
			$designPicklistvaluesM->whereE( 'did', $this->did );
			$designPicklistvaluesM->setVal( 'inputbox', 0 );
			$designPicklistvaluesM->update();
		}

		return true;

	}












function addValidate() {



	if ( empty( $this->value ) ) {

		$this->value = $this->_getDefaultValue();

	}


	
	$designPicklistValueM = WModel::get( 'design.picklistvalues' );

	$designPicklistValueM->whereE( 'did', $this->did );

	$designPicklistValueM->whereE( 'value', $this->value );

	$exist = $designPicklistValueM->exist();


	if ( $exist ) {

		$message = WMessage::get();


		$message->userE('1387417576HDLZ');

		$did = WGlobals::get( 'did' );

		$titleheader = WGlobals::get( 'titleheader' );

		WPages::redirect( 'controller=design-picklistvalues&did=' . $did . '&titleheader=' . $titleheader );

		return false;

	}


	if ( empty($this->namekey) ) {

		
		$designPicklistM = WModel::get( 'design.picklist' );

		$designPicklistM->whereE( 'did', $this->did );

		$namekey = $designPicklistM->load( 'lr', 'namekey' );

		$this->namekey = $namekey . '-' . $this->value;

	}


	return true;



}












function editValidate() {


	
	$designPicklistValueM = WModel::get( 'design.picklistvalues' );

	$designPicklistValueM->whereE( 'did', $this->did );

	$designPicklistValueM->where( 'vid', '!=', $this->vid );

	$designPicklistValueM->whereE( 'value', $this->value );

	$exist = $designPicklistValueM->exist();



	if ( $exist ) {

		$message = WMessage::get();


		$message->userE('1387417576HDLZ');

		$did = WGlobals::get( 'did' );

		$titleheader = WGlobals::get( 'titleheader' );

		WPages::redirect( 'controller=design-picklistvalues&did=' . $did . '&titleheader=' . $titleheader );



	}


	return true;



}









	function extra() {



		
		$extensionHelperC = WCache::get();

		$extensionHelperC->resetCache( 'Views' );



		return true;



	}
















	public function secureTranslation($sid,$eid) {



		$uid = WUser::get( 'uid' );

		if ( empty($uid) ) return false;



		
		$roleHelper = WRole::get();

		if ( WRole::hasRole( 'admin' ) ) return true;



		return false;



	}












	private function _getDefaultValue() {





		$designPicklistValuesM = WModel::get( 'design.picklistvalues' );



		$designPicklistValuesM->select( 'value' );


		$designPicklistValuesM->whereE( 'did', $this->did );

		$maxValueSoFarA = $designPicklistValuesM->load( 'lra' );



		$maxValueSoFar = 0;

		if ( !empty($maxValueSoFarA) ) {

			foreach( $maxValueSoFarA as $oneValue ) {

				if ( is_numeric($oneValue) && $oneValue > $maxValueSoFar ) $maxValueSoFar = $oneValue;

			}
		}


		if ( !empty( $maxValueSoFar ) ) {

			if ( is_numeric($maxValueSoFar) ) {

				$maxValueSoFar++;

			} else {

				$maxValueSoFar .= '9';

			}
		} else {

			$maxValueSoFar = 1;

		}


		return $maxValueSoFar;



	}

}