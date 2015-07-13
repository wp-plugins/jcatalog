<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Address_map_show_controller extends WController {

	function show() {



		$adid = WGlobals::get( 'adid' );

		if ( empty($adid) ) return false;

				if ( 'mobile' == JOOBI_FRAMEWORK_TYPE ) return false;



		$this->dontDisplayView();

		if ( version_compare( phpversion(), '5.3', '<' ) ) {
			$message = WMessage::get();
			$message->userN('1373209094YQB');
			return true;
		}


		$width = WGlobals::get( 'width' );

		$height = WGlobals::get( 'height' );

		$showStreetView = WGlobals::get( 'streetView' );
		$heightStreet = WGlobals::get( 'heightstreet' );


		$addressMapC = WClass::get( 'address.map' );

		$addressMapC->setAddressID( $adid );

		if ( !empty($width) ) $addressMapC->setWidth( $width );

		if ( !empty($height) ) $addressMapC->setHeight( $height );

		if ( !empty($showStreetView) ) $addressMapC->showStreetView();
		if ( !empty($heightStreet) ) $addressMapC->setStreetHeight( $heightStreet );
		$this->content = $addressMapC->renderMap();


		if ( empty($this->content) ) {
			$this->content = '<br />' . WText::t('1398304758MHHQ');
		}


		return true;



	}}