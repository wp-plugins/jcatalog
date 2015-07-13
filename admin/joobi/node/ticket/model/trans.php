<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */


defined('JOOBI_SECURE') or die('J....');




 class Ticket_Trans_model extends WModel {



















 	function validate() {



 		if ( !empty($this->name) ) {	
			$this->name = ucfirst( $this->name );
			return true;

 		} else {

 			$message= WMessage::get();

 			$message->codeE( 'The translation for your ticket have not been saved.' );

 			return false;

 		}


 	}




 }


