<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Main_Requirements_class extends WClasses {





    public function checkServerRequirements() {

    	    	$status = $this->_writableFolders();

    	
    	
    	


	}





    public function displayServerRequirements() {


	}






	private function _writableFolders() {

		$listA = array();
		$listA[] = JOOBI_DS_ROOT;			$listA[] = JOOBI_DS_TEMP;	
		foreach( $listA as $folder ) {
			
		}
	}


}