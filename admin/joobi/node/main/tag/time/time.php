<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');













































 class Main_Time_tag {













	public function process($object) {




		$tagsA = array();

		foreach( $object as $tag => $parameters ) {


			$time = '';

			if ( !empty($parameters->timestamp) ) {

				$time = $parameters->timestamp;

			}
			if ( empty($time) ) $time = time();



			if ( !empty($parameters->format) ) {



				if ( is_numeric($parameters->format) ) {


					$format = WTools::dateFormat( $parameters->format );

				} else {

					$format = $parameters->format;

				}


			} else {

				$format = WTools::dateFormat( 'day-date-time' );

			}


			if ( !empty($parameters->time) ) {

				$time = time() - $time + WApplication::stringToTime( $parameters->time );












			}


			if ( !empty($parameters->timezone) ) {

				$time = $time + ( $parameters->timezone );

			} else {

				

				$timezone = WUser::timezone();

				$time = $time + $timezone;



			}


			
			
			$tag = '{widget:time';

			if (!empty($parameters->time) ) $tag .= '|time='.$parameters->time;

			if (!empty($parameters->format) ) $tag .= '|format='.$parameters->format;

			if (!empty($parameters->timezone) ) $tag .= '|timezone='.$parameters->timezone;

			if (!empty($parameters->timestamp) ) $tag .= '|timestamp='.$parameters->timestamp;

			$tag .= '}';



			if ( is_int($time) ) $tagsA[$tag] = WApplication::date( $format, $time );

			else $tagsA[$tag] = '';



		}


		return $tagsA;



	}












	public function initialValue() {



		$newParamsO = new stdClass();

		$newParamsO->time = 'now';

		$newParamsO->timezone = '';

		$newParamsO->format = 2;

		$newParamsO->timestamp = time();

		return $newParamsO;



	}


}