<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_Priority_picklist extends WPicklist {


	  

function create(){

 $priority = array(

		 '10'=>'Low',

		 '20'=>'Medium',

		 '30'=>'High',

		 '40'=>'Top'

	  );

	foreach($priority as $index => $priorityValue){

		$this->addElement($index, $priorityValue);



	}


}	  



 

 


































}