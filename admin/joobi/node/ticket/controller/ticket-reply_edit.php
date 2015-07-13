<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_reply_edit_controller extends WController {










function templateedit(){



	$tktid=$this->_eid[0];

	$tkid=WGlobals::get('tkid');



	
	$templateM=WModel::get('ticket.templatetrans');

	$templateM->select('description');

	$templateM->whereE('tktid',$tktid);

	$description=$templateM->load('lr');



	return true;

}}