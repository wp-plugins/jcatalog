<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_Distance_class extends WClasses {


public $radLat; public $radLon; 
public $degLat;	public $degLon; 
const EARTHS_RADIUS_KM = 6371.01;
const EARTHS_RADIUS_MI = 3958.762079;

protected static $MIN_LAT; protected static $MAX_LAT; protected static $MIN_LON; protected static $MAX_LON; 
public function __construct() {
	self::$MIN_LAT = deg2rad(-90); 	self::$MAX_LAT = deg2rad(90); 	self::$MIN_LON = deg2rad(-180); 	self::$MAX_LON = deg2rad(180); }












public function getMixMaxLongLatFromLocationRadius($location,$radius,$unitOfMeasurement='km') {

	if ( empty($location) || empty($radius) ) return false;

		$addressMapC = WClass::get( 'address.map' );
	$myCoordinatesO = $addressMapC->getCoordinates( $location, 0, false );
		if ( empty($myCoordinatesO) ) return false;

	return $this->getMixMaxLongLatFromCoordinateRadius( $myCoordinatesO->longitude, $myCoordinatesO->latitude, $radius, $unitOfMeasurement );

}











public function getMixMaxLongLatFromCoordinateRadius($longitude,$latitude,$radius,$unitOfMeasurement='km') {

	if ( empty($longitude) || empty($latitude) || empty($radius) || $longitude==0 || $latitude==0 ) return false;

		if ( 'mi' == $unitOfMeasurement || 'miles' == $unitOfMeasurement ) {
		$radius = Address_Distance_class::MilesToKilometers( $radius );
		$unitOfMeasurement='km';
	}
		$locationObject = Address_Distance_class::fromDegrees( $latitude, $longitude );
	if ( empty($locationObject) ) return false;

	$geoCode = $locationObject->boundingCoordinates( $radius, $unitOfMeasurement );
	$result = new stdClass;
	$result->minCoordinate = new stdClass;
	$result->minCoordinate->longitude = $geoCode[0]->degLon;
	$result->minCoordinate->latitude = $geoCode[0]->degLat;
	$result->maxCoordinate = new stdClass;
	$result->maxCoordinate->longitude = $geoCode[1]->degLon;
	$result->maxCoordinate->latitude = $geoCode[1]->degLat;

	return $result;

}





public static function fromDegrees($latitude,$longitude) {
	$location = new Address_Distance_class();
	$location->radLat = deg2rad($latitude);
	$location->radLon = deg2rad($longitude);
	$location->degLat = $latitude;
	$location->degLon = $longitude;
	$status = $location->checkBounds();

	if ( false === $status ) return false;

	return $location;

}





public static function fromRadians($latitude,$longitude) {

	$location = new Address_Distance_class();
	$location->radLat = $latitude;
	$location->radLon = $longitude;
	$location->degLat = rad2deg($latitude);
	$location->degLon = rad2deg($longitude);
	$status = $location->checkBounds();

	if ( false === $status ) return false;

	return $location;
}
protected function checkBounds() {

	if ( $this->radLat < self::$MIN_LAT || $this->radLat > self::$MAX_LAT ||
	$this->radLon < self::$MIN_LON || $this->radLon > self::$MAX_LON ) {
		$message = WMessage::get();
		$message->codeE( 'Invalid Argument in checkBounds' );
		return false;
	}

}









public function distanceTo($location,$unit_of_measurement) {

	$radius = $this->getEarthsRadius($unit_of_measurement);

	return acos(sin($this->radLat) * sin($location->radLat) +
	cos($this->radLat) * cos($location->radLat) *
	cos($this->radLon - $location->radLon)) * $radius;

}



public function getLatitudeInDegrees() {
	return $this->degLat;
}



public function getLongitudeInDegrees() {
	return $this->degLon;
}



public function getLatitudeInRadians() {
	return $this->radLat;
}



public function getLongitudeInRadians() {
	return $this->radLon;
}
public function __toString() {
	return "(" . $this->degLat . ", " . $this->degLong . ") = (" .
	$this->radLat . " rad, " . $this->radLon . " rad";
}

































public function boundingCoordinates($distance,$unit_of_measurement='km') {

	$radius = $this->getEarthsRadius($unit_of_measurement);
	if ($radius < 0 || $distance < 0) throw new Exception('Arguments must be greater than 0.');

		$radDist = $distance / $radius;

	$minLat = $this->radLat - $radDist;
	$maxLat = $this->radLat + $radDist;

	$minLon = 0;
	$maxLon = 0;
	if ($minLat > self::$MIN_LAT && $maxLat < self::$MAX_LAT) {
	$deltaLon = asin(sin($radDist) /
	cos($this->radLat));
	$minLon = $this->radLon - $deltaLon;
	if ($minLon < self::$MIN_LON) $minLon += 2 * pi();
	$maxLon = $this->radLon + $deltaLon;
	if ($maxLon > self::$MAX_LON) $maxLon -= 2 * pi();
	} else {
		$minLat = max($minLat, self::$MIN_LAT);
	$maxLat = min($maxLat, self::$MAX_LAT);
	$minLon = self::$MIN_LON;
	$maxLon = self::$MAX_LON;
	}

	return array(
		Address_Distance_class::fromRadians($minLat, $minLon),
		Address_Distance_class::fromRadians($maxLat, $maxLon)
	);

}






public static function MilesToKilometers($miles) {
	return $miles * 1.6093439999999999;
}





public static function KilometersToMiles($km) {
	return $km * 0.621371192237334;
}






protected function getEarthsRadius($unit_of_measurement) {
	$u = $unit_of_measurement;
	if ( $u == 'miles' || $u == 'mi' ) return $radius = self::EARTHS_RADIUS_MI;
	elseif ($u == 'kilometers' || $u == 'km') return $radius = self::EARTHS_RADIUS_KM;

	else throw new Exception('You must supply a valid unit of measurement');
}
}