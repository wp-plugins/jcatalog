<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class WListing_Coreiptracker extends WListings_default{

	private static $_defaultValue = null;




	function create() {

		if ( !empty($this->value) ) {


				$cty = $this->getValue( 'ctyid' );
								$country = WModel::getElementData( 'countries', $cty, 'name' );
				if ( !empty($country) ) {

					$this->content = '<span style="font-size: x-small;">';
					if ( $this->searchOn && self::$_defaultValue == $this->value ) {
						$this->content .= '<span class="search-highlight">' . $this->value . '</span>';
					} else {
						$this->content .= $this->value;
					}
					$isMobile = ( in_array( JOOBI_APP_DEVICE_TYPE, array( 'ph','tb') ) ? true : false );

					static $ipClass=null;
					if ( !isset($ipClass) ) $ipClass = WClass::get('iptracker.lookup', null, 'class', false);
					if ( !empty($ipClass) ) $flag = $ipClass->getFlagFromCountry( $cty );
					if ( !empty($flag) ) $this->content .= ' ' . $flag;
					if ( !$isMobile ) $this->content .= '<a href="http://en.wikipedia.org/?search=' . $country . '" target="_blank">';
					$this->content .= ' ' . $country;
					if ( !$isMobile ) $this->content .= '</a>';
					$this->content .= '</span>';

					return true;
				} else {
					return parent::create();
				}
		}
		return parent::create();

	}








	public function searchQuery(&$model,$element,$searchedTerms=null,$operator=null) {

				$this->createComplexIds( $element->lid, $element->map . '_' . $element->sid );
		Output_Doc_Document::$advSearchHTMLElementIdsA[$element->lid] = 'srchwz_' . $element->lid;

		if ( !empty($searchedTerms) ) {
			self::$_defaultValue = $searchedTerms;
		} else {
			self::$_defaultValue = WGlobals::getUserState( self::$complexSearchIdA[$element->lid] , self::$complexMapA[$element->lid], '', 'array', 'advsearch' );
		}
		if ( empty(self::$_defaultValue) ) return true;

		$outputHelperC = WClass::get( 'output.helper' );
		$defaultValueUsed = ip2long( self::$_defaultValue );
		$model->whereSearch( $element->map, $defaultValueUsed, $element->asi, '=', $operator );

	}

}