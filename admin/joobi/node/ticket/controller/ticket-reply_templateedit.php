<?php 

* @link joobi.co
* @license GNU GPLv3 */












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