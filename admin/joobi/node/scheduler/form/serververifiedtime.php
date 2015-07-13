<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


WView::includeElement( 'form.datetime' );
class Scheduler_Serververifiedtime_form extends WForm_datetime {

	function show(){

		$date=WApplication::date( WTools::dateFormat( 'time-unix' ),  time());

		$this->value=WApplication::stringToTime( $date );



		if( $this->value !=time()){

			parent::show();

			$this->content=WText::t('1382065652HZGO') . '<br />' . $this->content;

		}else{

			return false;

		}


	}
}