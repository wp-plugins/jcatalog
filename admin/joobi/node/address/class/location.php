<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_Location_class extends WClasses {






public function createAddressLocation($object) {

	if ( empty($object) ) return false;

		$object->location = '';
	if ( !empty( $object->address1 ) ) $object->location .= $object->address1;
	if ( !empty( $object->address2 ) ) $object->location .= ( !empty($object->location)?',':'' ) . $object->address2;
	if ( !empty( $object->address3 ) ) $object->location .= ( !empty($object->location)?',':'' ) . $object->address3;

		$city = '';
	if ( !empty( $object->city ) ) $city .= $object->city;
	if ( !empty( $object->state ) ) $city .= ( !empty($city) ? ',':'' ) . $object->state;
	if ( !empty( $object->zipcode ) ) $city .= ( !empty($city) ? ' ':'' ) . $object->zipcode;
	if ( !empty( $city ) ) $object->location .= ( !empty($object->location) ? ',':'' ) . $city;

		if ( !empty( $object->ctyid ) ) {
		$countriesHelperC = WClass::get( 'countries.helper', null, 'class', false );
		if ( !empty($countriesHelperC) ) {
			$country = $countriesHelperC->getData( $object->ctyid );
			if ( !empty( $country ) ) {
				$object->location .= ( !empty($object->location)?',':'' ) . $country->name;
			}		}
	}
	return $object->location;

}

}