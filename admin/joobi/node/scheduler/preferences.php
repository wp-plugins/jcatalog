<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');
class Default_scheduler_preferences {
public $cleanuptime=0;
public $cronfrequency=900;
public $cronparallel=0;
public $last_launched=0;
public $maxfrequency=60;
public $maxprocess=10;
public $maxtasks=10;
public $memlimit=64;
public $minfrequency=10;
public $password='WeLoveWhatWeDoHopeYouWillLoveItToo';
public $report=0;
public $reportemail='';
public $savereport=0;
public $timelimit=120;
public $timeout=40;
public $tokena='';
public $tokencurrent='';
public $tokentime='';
public $usepwd=0;
}
class Role_scheduler_preferences {
public $cleanuptime='allusers';
public $cronfrequency='manager';
public $cronparallel='admin';
public $last_launched='allusers';
public $maxfrequency='allusers';
public $maxprocess='manager';
public $maxtasks='manager';
public $memlimit='manager';
public $minfrequency='allusers';
public $password='manager';
public $report='manager';
public $reportemail='manager';
public $savereport='allusers';
public $timelimit='manager';
public $timeout='allusers';
public $tokena='allusers';
public $tokencurrent='allusers';
public $tokentime='allusers';
public $usepwd='manager';
}