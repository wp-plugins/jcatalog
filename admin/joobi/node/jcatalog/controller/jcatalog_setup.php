<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Jcatalog_setup_controller extends WController {
	function setup() {



		
		
		$vendorM = WModel::get( 'vendor' );

		$vendorM->select( 'vendid' );

		$vendorM->select( 'premium' );

		$vendorObj = $vendorM->load( 'o' );



		if ( empty( $vendorObj ) || empty( $vendorObj->vendid  ) ) WGlobals::set( 'hidemainmenu', 1 ); 
		else {

			$vendid = isset( $vendorObj->vendid ) ? $vendorObj->vendid : 0;

			$premium = isset( $vendorObj->premium ) ? $vendorObj->premium : 0;



			
			if ( !empty( $vendid ) && ( empty( $premium ) || $premium < 1 ) ) {

				$vendorM = WModel::get( 'vendor' );

				$vendorM->setVal( 'premium', 1 );

				$vendorM->setVal( 'publish', 1 );

				$vendorM->whereE( 'vendid', $vendid );

				$vendorM->update();

			}


			WGlobals::setEID( $vendid );



			if ( WPref::load( 'PJCATALOG_APPLICATION_INSTALLED' ) ) {

				WPages::redirect( 'controller=catalog&task=listing' ); 
			}
			

		}


		return parent::setup();



	}}