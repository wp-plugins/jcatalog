<?php 

* @link joobi.co
* @license GNU GPLv3 */












class Ticket_CorePagetitle_listing extends WListings_default{












function create() {

  
  	
	static $done=true;

  


	
	if ( $done ) {



		if (PTICKET_NODE_TKTITLE){				
			$title = $this->value;

		}elseif (PTICKET_NODE_TKNAMEKEY){			
			$title = '#'.$this->getValue('namekey');

		}elseif (PTICKET_NODE_TKBOTH){							
			$title = $this->value .' #'. $this->getValue('namekey');

		} else {

			return false;

		}
		
		WGlobals::set( 'titleheader', $title, '', true );


		$done = false;

	}
return true;



}}