<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CoreReply_listing extends WListings_default{












function create() {

	$this->content = $this->value;
	return true;


	
	if (WGlobals::checkCandy(50)) {


		$tkrid = $this->getValue('tkrid');



		$ticketReplyM=WModel::get('ticket.reply');

		$ticketReplyM->whereE('tkrid', $tkrid);

		$comment = $ticketReplyM->load('lr','comment');		


		$ticketReplyM=WModel::get('ticket.replytrans');

		$ticketReplyM->whereE('tkrid', $tkrid);

		$description = $ticketReplyM->load('lr','description');



		if ( empty($comment) ) {

			$this->content = $description;

		} else {

			$comment = '<span style="font-weight:bold; color:orange;">'.WText::t('1219769904NDHD').'</span>';

			$this->content = $comment.'<br/><br/>'.$description;

		}


	}


	return true;

}}