<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Database_class extends WClasses {



    public function optimizeDB() {

		
   	

		if ( empty($databases) ) $databases = array( JOOBI_DB_NAME );
		foreach( $databases as $database ) {
			
			if ( 'information_schema' == $database ) continue;

			$sqlDB = WTable::get();
			$tableA = $sqlDB->showDBTables( false, $database );
			if ( !empty($tableA) ) {
    	
    	    			foreach( $tableA as $oneTable ) {
    				$sql = WTable::get( $oneTable, $database );
    				$sql->optimizeTable();
    				
    				$sql = WTable::get( $oneTable, $database );
    				$sql->repairTable();
    			}				
			}			
		}		
	}

}