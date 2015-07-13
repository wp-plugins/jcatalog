<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_Map_class extends WClasses {

	private $_adid = array();

	private $_locationA = array();

	private $_coordinatesA = array();


		private $_addressO = array();

	private $_mapID = 'map';

	private $_width = 0;
	private $_height = 0;
	private $_heightStreet = 0;
	private $_widthStreet = 0;

	private $_mapType = '';

	private $_enableClustering = false;

	private $_showStreetView = true;

	private $_mainMap = '';
	private $_streetViewMap = '';


	private $_addressGeomapC = null;

	private $_mapInstance = null;










public function setAddressID($adid) {

	$this->_adid[] = $adid;

}





public function setAddress($address) {
	$this->_locationA[] = $address;
}







public function setCoordinates($longitude,$latitude,$location='') {
	$cord = new stdClass;
	$cord->longitude = $longitude;
	$cord->latitude = $latitude;
	$cord->location = $location;

	$this->_coordinatesA[] = $cord;
}








public function setClustering($coordinatesA) {
	$this->_enableClustering = true;
	$this->_addressO = $coordinatesA;

}







public function setWidth($width) {
	$this->_width = $width;
}





public function setHeight($height) {
	$this->_height = $height;
}





public function setStreetHeight($height) {
}







public function showStreetView($showStreetView=true,$widthStreet=0,$heightStreet=0) {
	$this->_showStreetView = $showStreetView;
	if ( !empty($heightStreet) ) $this->_heightStreet = $heightStreet;
	if ( !empty($widthStreet) ) $this->_widthStreet = $widthStreet;
}





public function renderMap() {

	$this->prepareMap();

	$html = $this->_mainMap;
	$html .= $this->_streetViewMap;
	return $html;

}





public function renderMapOnly() {
	$this->prepareMap();
	return $this->_mainMap;
}





public function renderStreetView() {
	return $this->_streetViewMap;
}





private function _initiateMapInstance() {

	static $IDCount = 0;
	if ( version_compare( phpversion(), '5.3', '<' ) ) {
		$message = WMessage::get();
		$message->adminE( 'PHP 5.3 is required for Geo Location module to function!' );
		return false;
	}
	$exit = WLoadFile( 'PHPGoogleMaps.Core.Autoloader', JOOBI_DS_INC, true, false );
	if ( ! $exit ) return false;

	$map_loader = new SplClassLoader( 'PHPGoogleMaps', '..' );
	$map_loader->register();

	$mapOptionsA = array();
	$useHTTPS = WGlobals::get( 'HTTPS', 'off', 'server' );
	if ( 'on' == $useHTTPS ) $mapOptionsA['use_https'] = true;

	$lang = WLanguage::get( WUser::get('lgid'), 'code' );
	if ( 'en' != $lang ) $mapOptionsA['language'] = $lang;

	$mainCredentialsC = WClass::get( 'main.credentials' );
	$key = $mainCredentialsC->loadFromID( WPref::load( 'PADDRESS_NODE_GOOGLEKEY'), 'passcode' );
	if ( !empty($key) ) $mapOptionsA['api_key'] = $key;

	$IDCount++;
	$this->_mapID = 'map_' . $IDCount;
	$mapOptionsA['map_id'] = $this->_mapID;

	$this->_mapInstance = new \PHPGoogleMaps\Map( $mapOptionsA );

	return true;

}





public function prepareMap() {

		if ( !$this->_loadAddress() ) {
				return false;
	}
	if ( empty($this->_mapInstance) ) {
		if ( !$this->_initiateMapInstance() ) return false;
	}
	$markersA = array();
	$maxLong = -200;
	$minLong = 200;
	$maxLat = -200;
	$minLat = 200;
	$hasMarker = false;

	foreach( $this->_addressO as $oneOnlyMarket ) {
		if ( empty($oneOnlyMarket) ) continue;

		if ( $oneOnlyMarket->longitude < -180
		|| $oneOnlyMarket->longitude > 180
		|| $oneOnlyMarket->latitude < -180
		|| $oneOnlyMarket->latitude > 180 ) continue;

		$hasMarker = true;

		if ( $oneOnlyMarket->longitude > $maxLong ) $maxLong = $oneOnlyMarket->longitude;
		if ( $oneOnlyMarket->longitude < $minLong ) $minLong = $oneOnlyMarket->longitude;
		if ( $oneOnlyMarket->latitude > $maxLat ) $maxLat = $oneOnlyMarket->latitude;
		if ( $oneOnlyMarket->latitude < $minLat ) $minLat = $oneOnlyMarket->latitude;
		$oneMarker = $this->_createMarker( $oneOnlyMarket );
		$this->_mapInstance->addObject( $oneMarker );

		$markersA[] = $oneMarker;

	}
	if ( ! $hasMarker ) return false;

	$this->_mapInstance->enableCompressedOutput();

		if ( count( $markersA ) <2 ) {
				$this->_mapInstance->setCenter( $markersA[0]->getPosition() );
		$this->_mapInstance->disableAutoEncompass();
		$this->_mapInstance->setZoom( 15 );
		if ( $this->_showStreetView ) $this->_mapInstance->enableStreetView( array( 'position'=>$markersA[0]->getPosition(), 'addressControl' => false, 'enableCloseButton' => true ), $this->_mapID . '_street' );

	} else {
				$this->_mapInstance->enableAutoEncompass();

		$centerLongitude = ( $maxLong + $minLong ) / 2;
		$centerLatitude = ( $maxLat + $minLat ) / 2;
		$this->_mapInstance->setCenterCoords( $centerLatitude, $centerLongitude );

	}
	if ( !empty( $this->_width ) ) $this->_mapInstance->setWidth( $this->_width );
	if ( !empty( $this->_height ) ) $this->_mapInstance->setHeight( $this->_height );
	if ( !empty( $this->_mapType ) )  $this->_mapInstance->setMapType( $this->_mapType );

		if ( $this->_enableClustering ) {

		$cluster_options = array(
			'maxZoom' => 10,
			'gridSize' => null
		);

	}

	WPage::addJS( $this->_mapInstance->getMapJS() );

	$this->_mainMap = $this->_mapInstance->getMap();

		if ( $this->_showStreetView && count($this->_addressO)<2 ) {
		$streetViewId = $this->_mapID . '_street';
		$heightStreet = ( !empty($this->_heightStreet) ? $this->_heightStreet : 300 );
		$widthStreet = ( !empty($this->_widthStreet) ? $this->_widthStreet : $this->_width );

		$CSS = '#' .  $streetViewId  . '{width:'.$widthStreet.'px;height:'.$heightStreet.'px;clear:both;}';
		WPage::addCSSScript( $CSS );
				$this->_streetViewMap = '<div class="streetMap center-block" id="' . $streetViewId . '"></div>';
	}


	$headerJSA = $this->_mapInstance->getHeaderJS();
	foreach( $headerJSA as $oneJS ) WPage::addScript( $oneJS );


	return true;

}






	private function _createMarker($oneOnlyMarket) {

		if ( empty($oneOnlyMarket->location) ) $oneOnlyMarket->location = '';

		$markerName = trim( !empty($oneOnlyMarket->name) ? $oneOnlyMarket->name : '' );
		if ( empty($markerName) || $markerName=='default' ) {
			$markerName = str_replace( array(',' ), ', ', $oneOnlyMarket->location );
			$oneOnlyMarket->name = $markerName;
		}		$addressHelperC = WClass::get( 'address.helper' );
		$markerDescription = trim( $addressHelperC->renderAddress( $oneOnlyMarket, 'html', true, true, true, false ) );
		if ( empty($markerDescription) || $markerDescription=='default' ) $markerDescription = $markerName;


		$marker1_options = array(
		'title'	=> $markerName,
		'content'=> '<div style="padding:5px;">' . $markerDescription . '</div>'
		);


		$position = new PHPGoogleMaps\Core\LatLng( $oneOnlyMarket->latitude, $oneOnlyMarket->longitude, $oneOnlyMarket->location );

		$marker1 = \PHPGoogleMaps\Overlay\Marker::createFromPosition( $position, $marker1_options );
		if ( !empty($oneOnlyMarket->icon) ) {
		}
		return $marker1;

	}





	public function getCoordinates($address='',$adid=0,$showMessage=true) {

		if ( empty($address) && empty($adid) ) return false;

		$geocode = $this->_getCache( $address, $adid );
		if ( $geocode === false || ( empty( $geocode->longitude ) || $geocode->longitude == 0
		|| empty( $geocode->latitude ) || $geocode->latitude == 0 )  ) {

			if ( empty($this->_mapInstance) ) {
				if ( !$this->_initiateMapInstance() ) return false;
			}
												if ( empty($address) && !empty($geocode->location) ) $address = $geocode->location;
			if ( empty($address) ) return false;
			$geocodeResult = \PHPGoogleMaps\Service\Geocoder::geocode( $address );

			if ( $geocodeResult instanceof \PHPGoogleMaps\Service\GeocodeResult ) {
				
				$geocode = $geocodeResult->getLatLng();
				$geocode->latitude = $geocode->lat;
				$geocode->longitude = $geocode->lng;
				unset($geocode->lat);
				unset($geocode->lng);

      		        		if ( empty( $adid ) ) {
        			$adid = $this->_putCache( $address, $geocode->longitude, $geocode->latitude );
        		} else {
        			$this->_updateCache( $adid, $geocode->longitude, $geocode->latitude, $address );
        		}
        		$geocode->adid = $adid;
			} else {
								WMessage::log( 'The location: ' . @$geocode->location . ' could not be found by Google Map. Error: ' . @$geocode->error, 'GoogleGeoLocationFailed' );
				if ( $showMessage ) {
					$this->userN('1373210359RPSF');
				}
				$geocode = new stdClass;
				$geocode->latitude = 0;
				$geocode->longitude = 0;
				$geocode->location = $address;

				return $geocode;
			}
		}

		if ( empty( $geocode ) ) return false;


		return $geocode;

	}






private function _loadAddress() {

		if ( !empty($this->_adid) ) {
		$addressHelperC = WClass::get( 'address.helper' );
		foreach( $this->_adid as $oneADID ) {
			$this->_addressO[$oneADID] = $addressHelperC->getAddress( $oneADID );
		}	}
	if ( !empty( $this->_locationA ) ) {

		$addressHelperC = WClass::get( 'address.helper' );
		foreach( $this->_locationA as $oneNamekey ) {
			$myCoordinatesO = $this->getCoordinates( $oneNamekey );
			if ( empty($myCoordinatesO) || empty($myCoordinatesO->adid) ) continue;
			$this->_addressO[$myCoordinatesO->adid] = $addressHelperC->getAddress( $myCoordinatesO->adid );
		}
	}
		if ( !empty($this->_coordinatesA) ) {
		static $countCood=0;
		$countCood++;

		foreach( $this->_coordinatesA as $oneCoordinate ) {
			$keyC = 'key'.$countCood;
			$this->_addressO[$keyC] = $oneCoordinate;
		}	}

	if ( empty($this->_addressO) ) return false;
			if ( !$this->_checkCoordinates() ) return false;
	return true;

}












    private function _putCache($address,$lon,$lat) {

    	if ( empty($address) || empty($lon) || empty($lat) ) return false;

    	$address = str_replace( array(' ,', ', ' ), ',', $address );

    	$addressM = WModel::get( 'address' );
    	$addressM->setVal( 'location', $address );
    	$addressM->setVal( 'longitude', $lon );
    	$addressM->setVal( 'latitude', $lat );
	    $addressM->setVal( 'found', 1 );
	    $addressM->setVal( 'lastcheck', time() );
	    $addressM->setVal( 'mapservice', 1 );
    	$addressM->insertIgnore();

    	$adid = $addressM->lastId();
    	return ( !empty($adid) ? $adid : null );

    }








    private function _getCache($address,$adid=0) {
    	static $storedA = array();
                $address = str_replace( array(' ,', ', ' ), ',', $address );

        if ( !empty($storedA[$address]) ) return $storedA[$address];

        $addressM = WModel::get( 'address' );
        $addressM->select( 'longitude' );	        $addressM->select( 'latitude' );	        $addressM->select( 'location' );
        $addressM->select( 'adid' );
        if ( !empty($adid) ) {
        	$addressM->whereE( 'adid', $adid );
        } else {
        	$addressM->whereE( 'location', $address );
        }        $resultO = $addressM->load( 'o' );
        if ( empty($resultO) ) return false;

        $storedA[$address] = $resultO;

        return $resultO;

    }









    private function _updateCache($adid,$lon,$lat,$address) {

    	if ( empty($adid) || empty($lon) || empty($lat) ) return false;

    	$addressM = WModel::get( 'address' );
    	$addressM->whereE( 'adid', $adid );

	    $addressM->setVal( 'location', $address );
    	$addressM->setVal( 'longitude', $lon );
    	$addressM->setVal( 'latitude', $lat );
	    $addressM->setVal( 'found', 1 );
	    $addressM->setVal( 'lastcheck', time() );
	    $addressM->setVal( 'mapservice', 1 );
	    $addressM->update();

    	return true;

    }
private function _checkCoordinates() {

	if ( empty($this->_addressO) ) return false;

	foreach( $this->_addressO as $adid => $oneAddress ) {

		if ( empty($oneAddress) ) continue;

		if ( !empty( $oneAddress->longitude ) && $oneAddress->longitude != 0
		&& !empty( $oneAddress->latitude ) && $oneAddress->latitude!= 0 ) {
			continue;
		}
		

						if ( !empty( $oneAddress->lastcheck ) && time() > ( $oneAddress->lastcheck + 7776000 ) ) {
						unset( $this->_addressO[$adid] );
		}
				if ( empty($oneAddress->location) ) {
			$addressNamekeyC = WClass::get( 'address.location' );
			$oneAddress->location = $addressNamekeyC->createAddressLocation( $oneAddress );
			$this->_addressO[$adid]->location = $oneAddress->location;
		}

				$addid = ( !empty($oneAddress->adid) ? $oneAddress->adid : 0 );
		$myCoordinatesO = $this->getCoordinates( $oneAddress->location, $addid );

				if ( !empty($myCoordinatesO->latitude) && ( empty($oneAddress->latitude) || $oneAddress->latitude == 0 || $oneAddress->latitude < -200 || $oneAddress->latitude > 200 ) ) $oneAddress->latitude = $myCoordinatesO->latitude;
		if ( !empty($myCoordinatesO->longitude) && ( empty($oneAddress->longitude) || $oneAddress->longitude == 0 || $oneAddress->longitude < -200 || $oneAddress->longitude > 200 ) ) $oneAddress->longitude = $myCoordinatesO->longitude;

		if ( empty($myCoordinatesO) ) {
						unset( $this->_addressO[$adid] );
		}
	}
	if ( empty($this->_addressO) ) return false;

    return true;

}

}