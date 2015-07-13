<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');






class Scheduler_Frequency_type extends WTypes {








	var $frequency=array(

		604800=> 'Every week',

		86400=>'Every day',

		43200=>'Twice a day',

		21600=>'Four times a day',

		7200=>'Every Two Hours',

		3600=>'Every Hours',

		1800=>'Every Thirty Minutes',

		900=>'Every Fifteen Minutes',

		600=>'Every Ten Minutes',

		300=>'Every Five Minutes',

		120=>'Every Two Minutes',

		60=>'Every Minutes',

	  );







 
}