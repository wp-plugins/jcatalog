<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.select' );
class Main_CoreRptinterval_form extends WForm_select {




	





	function create() {







		$trucs = WGlobals::get('trucs');

		$intervalG = (!empty( $trucs['x']['interval'] ) ? $trucs['x']['interval'] : WGlobals::get('interval') );

		if ( empty($intervalG) ) $intervalG = WGlobals::getSession( 'graphFilters', 'interval' );

		if ( empty($intervalG) ) $intervalG = 15;








		$presetDateG = (!empty( $trucs['x']['presetdate'] ) ? $trucs['x']['presetdate'] : 0 );

		if ( empty($presetDateG) ) $presetDateG = WGlobals::getSession( 'graphFilters', 'presetdate' );

		if ( empty($presetDateG) ) $presetDateG = 30;



		$currentPresetDate = null;

		if ( !empty( $intervalG ) ) {

			$currentInterval = $this->value = $intervalG;

			$currentPresetDate = $presetDateG;

		} else {

			$currentInterval = $this->value;		
		}

		$tPresetDate  = WController::getFormValue( 'presetdate' , 'x' );



		if ( !empty( $tPresetDate ) ) $currentPresetDate = $tPresetDate;	


		if ( isset( $currentPresetDate ) ) {

			
			switch ( $currentPresetDate ) {

				case '2': 	
				case '4': 	
					$this->value = 7;

					break;



				case '6':	
				case '12':	
				case '24':	
					if ( $currentInterval == 23 || $currentInterval == 33 ) $this->value = 7;	
					break;



				case '30':	
				case '36':	
						if ( $currentInterval == 33 ) $this->value = 15;	
					break;



				case '42':	
				case '48':	
				default:

					break;



			}


			


		}



		return parent::create();



	}}