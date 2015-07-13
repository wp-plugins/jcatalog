<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Scheduler_Periodcycle_type extends WTypes {


var $periodcycle=array(

	'1'=> 'minutes',	
	'60'=> 'hours', 	
	'1440'=> 'days',

	'10080'=> 'weeks',

	'43200'=> 'months',

	'525600'=> 'years'	

);
}