<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

 defined('JOOBI_SECURE') or die('J....');






class Mailbox_Searchin_type extends WTypes {
 var $searchin = array(
         
 	0=>'All Parts',
 	 	 	 	
    	1 => 'Both Subject and Body',
    	    	
	2 => 'Subject',
		
	3 => 'Body'
	);
}