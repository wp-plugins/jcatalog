<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CoreAttach_listing extends WListings_default{



function create() {



	$ticketFilesID = WModel::get( 'ticket.files', 'sid' );

    	$mapCount = 'tkid_'.$ticketFilesID;

    	$path = JOOBI_URL_MEDIA.'attach/tickets/';

    

    
    
    




	if (!empty($this->value)) {	


		$ticketreplysID = WModel::get( 'ticket', 'sid' );

		$map = 'tkid_'.$ticketreplysID;

		$tkid = $this->data->$map;

		



		if ( !isset($filesM) )

			$filesM=WModel::get('ticket');

			$filesM->makeLJ('ticket.files','tkid');

			$filesM->makeLJ('files','filid','filid',1,2);

			$filesM->select('name',2);

			$filesM->select('type',2);

			$filesM->whereE('tkid',$tkid);

			$files=$filesM->load('ol');



		if ( empty($files) || empty($files[0]->name) ) return false;	






		if ( $this->data->$mapCount > 1 ) {	
			$tkid=WGlobals::getSession( 'tickets', 'tkid', '' ) ;

			


			
		
		

			$list='';

			

			foreach($files as $file) {			
				$name=$file->name.'.'.$file->type;

				$icon = '<img src="'.JOOBI_URL_JOOBI_IMAGES . 'mime/'.$file->type.'.png" width=20px height=20px align="middle" border=0 alt="'.$file->name.'" /> ';

				$list.='<br/><a href="'.$path.$name.'" target="_blank">'.$icon . $name.'</a><br/>';

			}
		} else {						


			
			$name = $files[0]->name.'.'.$files[0]->type;

			$icon = '<img src="'.JOOBI_URL_JOOBI_IMAGES . 'mime/'.$files[0]->type.'.png" width=20px height=20px border=0 align="middle" alt="'.$files[0]->name.'" /> ';

			$list='<br/><a href="'.$path .$name.'"target="_blank">'.$icon.$name.'</a><br/>';



		}


		$this->content = $list;

		return true;



	} else {

	    return false;

	}


}}