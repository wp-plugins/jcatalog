<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Ticket_CoreStatus_listing extends WListings_default{


	function create() {

		$publish = $this->getValue( 'status' );

		$status= WType::get('ticket.publish');

		$this->content = WText::t('1206732392OZVH') .': <b>'.$status->publish[$publish] . '<b>';

		return true;
	}









}