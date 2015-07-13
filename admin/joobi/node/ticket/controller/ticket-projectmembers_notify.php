<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_projectmembers_notify_controller extends WController {








function notify(){




	
	$uid=WGlobals::get('uid');			
	$pjid=WGlobals::get('pjid');			
	$notify=WGlobals::get('notify');		
	

	
	$ticketMembersM=WModel::get('ticket.projectmembers');

	$ticketMembersM->whereE('uid',$uid);		
	$ticketMembersM->whereE('pjid',$pjid);

	

	
	if ($notify){					
		$ticketMembersM->setVal('notify','0');

		return $ticketMembersM->update();

	} else {						
		$ticketMembersM->setVal('notify','1');

		return $ticketMembersM->update();

	}

		

	return true;

}}