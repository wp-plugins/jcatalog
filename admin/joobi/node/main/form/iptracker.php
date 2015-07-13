<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');

















WView::includeElement( 'form.text' );
class WForm_Coreiptracker extends WForm_text {





	function create() {
				if ( !empty($this->value) ) {
						$this->value = long2ip( $this->value );
		}
		$status = parent::create();

		return $status;

	}




	function show() {

		if ( empty($this->value) ) {
			$this->content = ' ';
			return true;
		}
		$ipClass= WClass::get('iptracker.lookup', null, 'class', false);
		if ( empty($ipClass) || empty($this->value) ) {
			$this->content = $this->value;
			return true;
		}
		$isMobile = ( in_array( JOOBI_APP_DEVICE_TYPE, array( 'ph','tb') ) ? true : false );

		$this->content = '<span style="font-size: x-small;">';

		if ( !$isMobile ) {
			$url = WPage::routeURL('controller=iptracker&task=myip&ip='. $this->value,'smart','popup' );
			$this->content = WPage::createPopUpLink( $url, $this->value, 800, 600 );
		} else $this->content = $this->value;

		if ( !($ipText = $ipClass->ipInfo($this->value,'flag')) ) return true;

		$this->content .= ' ' . $ipText;
		$country = $ipClass->ipInfo( $this->value, 'country' );
		if ( !$isMobile ) $this->content .= '<a href="http://en.wikipedia.org/?search='.$country.'" target="_blank">';
		$this->content .= ' ' . $country;
		if ( !$isMobile ) $this->content .= '</a>';
		$this->content .= '</span>';

		return true;

	}






}

