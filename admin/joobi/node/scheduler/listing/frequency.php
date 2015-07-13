<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Scheduler_CoreFrequency_listing extends WListings_default{




function create(){



	switch ( $this->getValue( 'ptype')){

		case '3' : 
			$this->content=WText::t('1237395235EOTF');

			break;

		case '2' : 
			$cronMap=$this->mapList['cron'];

			$this->content=$this->data->$cronMap;

			break;

		break;

		default : 
			$freqType=WType::get('scheduler.frequency');

			if( $freqType->inValues( $this->value )){

				$this->content=$freqType->getName( $this->value );

			}else{

				$this->content=WText::t('1301380691ICEI') . ' ' . WTools::durationToString( $this->value );

			}


	}


	return true;



}}