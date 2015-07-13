<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');















class Countries_Helper_class extends WClasses {



















	public function getData($ctyid,$return='object') {



		if ( empty( $ctyid ) || !is_numeric( $ctyid ) ) return false;

		if ( !is_string( $return ) && !is_array( $return ) ) return false;





		static $countriesInfo = array();



		if ( empty( $countriesInfo[ $ctyid ] ) ) {

			$countryM = WModel::get( 'countries' );

			$countriesInfo[ $ctyid ] = $countryM->loadMemory( $ctyid );




		}


		
		if ( !empty( $countriesInfo[ $ctyid ] ) && !empty( $return ) && is_array( $return ) ) {

			$info = null;

			$country = $countriesInfo[ $ctyid ];

			foreach( $return as $prop ) {

				$info->$prop = ( !empty( $country->$prop ) ) ? $country->$prop : '';

			}


			return $info;

		}
		if ( $return == 'object' ) return $countriesInfo[ $ctyid ];

		elseif ( is_string( $return ) && !empty( $countriesInfo[ $ctyid ]->$return ) ) return  $countriesInfo[ $ctyid ]->$return;

		else return null;



	}














	public function getCountryByCode($isoCode2) {



		return $this->_loadCountriesFromCode( $isoCode2 );



	}






	public function _loadCountriesFromCode($isoCode2) {

		static $reulstA = array();



		if ( !isset($reulstA[$isoCode2]) ) {

			$countryM = WModel::get( 'countries' );

			$countryM->remember( $isoCode2, true, 'Model_joobi_countries' );

			$countryM->whereE( 'isocode2', $isoCode2 );

			$reulstA[$isoCode2] = $countryM->load( 'o' );

		}


		return $reulstA[$isoCode2];



	}














	public function getCountryID($isoCode2) {




		$myCountryO = $this->_loadCountriesFromCode( $isoCode2 );

		if ( !empty($myCountryO) ) return $myCountryO->ctyid;



		return null;



	}








	public function getCountryFlag($ctyid,$link=false) {



		if ( empty($ctyid) ) return '';



		if ( !WExtension::exist('iptracker.node')  || WGlobals::checkCandy(50,true) ) return '';



		$contryDataO = $this->getData( $ctyid );

		if ( empty($contryDataO) ) return '';



		return '<img hspace="5" align="absmiddle" title="' . $contryDataO->name . '" src="'. JOOBI_URL_MEDIA .'images/flags/' .strtolower($contryDataO->isocode2).'.gif"> &nbsp;';



	}






}