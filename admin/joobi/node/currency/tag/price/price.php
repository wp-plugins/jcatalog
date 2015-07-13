<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');

















 class Currency_Price_tag {









 	public $smartUpdate = false;































	function process($givenTagsA) {

		static $curConvertC=null;



		$usedCurrency = WUser::get('curid');

		$replacedTagsA = array();

		foreach( $givenTagsA as $tag => $myTagO ) {



			if ( !isset($myTagO->value) ) {

				$replacedTagsA[$tag] = '';

				continue;

			}




			if ( !isset($myTagO->currency) ) {

				
				
				$replacedTagsA[$tag] = WTools::format( $myTagO->value, 'price', $usedCurrency );

				continue;

			}


			if ( !isset($curConvertC) ) $curConvertC = WClass::get( 'currency.convert', null, 'class', false );



			if ( !empty($curConvertC) ) {

				$value = $curConvertC->currencyConvert( $myTagO->currency, $usedCurrency, $myTagO->value );

				if ( empty( $myTagO->symbol ) ) {

					$symbol = 'currency';

				} elseif ( 'money-code' == $myTagO->symbol ) {

					$symbol = 'moneyCode';

				} else {

					$symbol = $myTagO->symbol;

				}


				
				$decimal = ( isset($myTagO->decimal) ? $myTagO->decimal : null );

				if ( !empty($myTagO->style) ) {

					$useStyle = true;

					$className = ( !empty($myTagO->class) ? $myTagO->class : '' );

				} else {

					$useStyle = false;

					$className = '';

				}




				$replacedTagsA[$tag] = WTools::format( $value, $symbol, $usedCurrency, $decimal, $useStyle, $className );



			} else {

				$replacedTagsA[$tag] = WTools::format( $myTagO->value, 'price', $usedCurrency );

			}


		}

		return $replacedTagsA;



	}


}
