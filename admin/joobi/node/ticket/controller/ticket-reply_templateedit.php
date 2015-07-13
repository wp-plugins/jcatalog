<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_reply_templateedit_controller extends WController {










function templateedit(){



	$tktid=$this->_eid[0];

	$tkid=WGlobals::get('tkid');				
	$priority=WGlobals::get('priority');			
	$type=WGlobals::get('tktypeid');				




	
	$templateM=WModel::get('ticket.templatetrans');


	$templateM->select('description');

	$templateM->whereE('tktid',$tktid);

	$description=$templateM->load('lr');



	$redirect='controller=ticket-reply&task=listing&private=false&tkid='.$tkid.'&priority='.$priority.'&tktypeid='.$type. '&description='.$description;


	WPages::redirect($redirect);



	return true;

}}