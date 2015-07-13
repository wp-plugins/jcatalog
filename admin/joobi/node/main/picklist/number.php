<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');





class Main_Number_picklist extends WPicklist {
function create() {



	for ($i = 0; $i < 5; $i++) {
		$this->addElement( $i, $i );
	}



	return true;

}
}