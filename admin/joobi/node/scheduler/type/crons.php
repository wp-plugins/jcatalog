<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');



class Scheduler_Crons_type extends WTypes {
var $crons=array(

		0=>'No Cron',

		5=>'Site Cron',

		10=>'Joobi Cron',

		15=>'External Cron'	

	  );
}