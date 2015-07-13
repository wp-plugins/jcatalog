<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Main_Migration_class extends WClasses {

    var $colEmailS = '';
    var $curidS = '';
    var $pagingS = '';
    var $perCallNoRecordsS = '';
    var $colListIDS = '';
    var $colMembersIDS = '';
    var $colDateCreatedS = '';
    var $colListNameS = '';
    var $colListDescriptionS = '';
    var $migIDS = '';
	
 


 public function getHC()
 {
	$this->migIDS = 'migID';
	$this->colEmailS = 'colEmail';
	$this->curidS = 'curid';
	$this->pagingS = 'paging';
	$this->perCallNoRecordsS = 'perCallNoRecords';
	$this->colListIDS = 'colListID';
	$this->colMembersIDS = 'colMembersID';
	$this->colDateCreatedS = 'colDateCreated';
	$this->colListNameS = 'colListName';
	$this->colListDescriptionS = 'colListDescription';
	
 }
 
 




 public function getOffsetTime($dateTimeZoneTheirs) 
 {
	        $dateTimeZoneOur = new DateTimeZone(date_default_timezone_get());
    
    	$dateTimeOur = new DateTime("now", $dateTimeZoneOur);
    $dateTimeTheirs = new DateTime("now", $dateTimeZoneTheirs);

    $offset = $dateTimeZoneTheirs->getOffset($dateTimeOur) - $dateTimeZoneOur->getOffset($dateTimeOur);
	
    return $offset;
 }	
	
} 