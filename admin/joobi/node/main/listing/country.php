<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
















class WListing_Corecountry extends WListings_default{




	function create() {

		if ( $this->searchOn && is_array($this->mywordssearched) ) {
			$this->value = preg_replace( '#('.str_replace('#','\#',implode('|',$this->mywordssearched)).')#i' , '<span class="search-highlight">$0</span>', $this->value );
		}

		if ( !empty($this->value) ) {

			$countriesHelper = WClass::get( 'countries.helper' );
			$countryO = $countriesHelper->getData($this->value);

		    if ( !empty($countryO) ) {
		        $img = $countryO->isocode2;
		        $name = $countryO->name;
		        $flag = '<img align="absmiddle" title="'.$name.'" src="'. JOOBI_URL_MEDIA .'images/flags/' .strtolower($img).'.gif">';

		        $isMobile = ( in_array( JOOBI_APP_DEVICE_TYPE, array( 'ph','tb') ) ? true : false );

		        if ( !$isMobile ) $this->content = '<a href="http://en.wikipedia.org/?search='.$name.'" target="_blank">';
		        $this->content .= $name;
		        if ( !$isMobile ) $this->content .= ' </a>';
		        $this->content .= ' ' . $flag . '</span>';

		    }
		}
		return true;

	}
}



