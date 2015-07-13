<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_project_savenotify_controller extends WController {










function savenotify(){



	
	$sid = $this->sid;			
	$pjid = $this->_eid[0];			
	$trucs = WGlobals::get('trucs');	
	$oncreation = $trucs[$sid]['oncreation'];	
	$onreplies = $trucs[$sid]['onreplies'];

	$toassigned = $trucs[$sid]['toassigned'];

	$sendcopy = $trucs[$sid]['sendcopy'];

	



	

	
	$tkprojectM=WModel::get('ticket.project');


	$tkprojectM->whereE('pjid',$pjid);

	
	
	$tkprojectM->setVal('oncreation',$oncreation);

	$tkprojectM->setVal('onreplies',$onreplies);

	$tkprojectM->setVal('toassigned',$toassigned);

	$tkprojectM->setVal('sendcopy',$sendcopy);

	$tkprojectM->update();

	

	
	WPages::redirect('controller=ticket-project');

	return true;

}}