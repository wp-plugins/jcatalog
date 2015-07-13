<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

















class WForm_Coremap extends WForms_default {





	function create() {

				if ( 'mobile' == JOOBI_FRAMEWORK_TYPE ) return false;

		if ( version_compare( phpversion(), '5.3', '<' ) ) {
			$message = WMessage::get();
			$message->userN('1373209094YQB');
			return false;
		}
		$addressMapC = WClass::get( 'address.map' );

		
		$adid = $this->getValue( 'adid' );
		if ( empty( $adid ) ) {
						$longitude = $this->getValue( 'longitude' );
			if ( empty($longitude) || $longitude==0 ) return false;
			$latitude = $this->getValue( 'latitude' );
			$location = $this->getValue( 'location' );
			$addressMapC->setCoordinates( $longitude, $latitude, $location );
		} else {
			$addressMapC->setAddressID( $adid );
		}

		$width = WGlobals::get( 'mapWidth' );
		$height = WGlobals::get( 'mapHeight' );
		$showStreetView = WGlobals::get( 'mapShowStreetView', true );
		$widthStreet = WGlobals::get( 'mapStreetWidth' );
		$heightStreet = WGlobals::get( 'mapStreetHeight' );

		if ( !empty($width) ) $addressMapC->setWidth( $width );
		if ( !empty($height) ) $addressMapC->setHeight( $height );

		$addressMapC->showStreetView( $showStreetView, $widthStreet, $heightStreet );

		if ( !empty($heightStreet) ) $addressMapC->setStreetHeight( $heightStreet );

		$this->content = $addressMapC->renderMap();

		return true;

	}
	function show() {
		return $this->create();
	}




}

