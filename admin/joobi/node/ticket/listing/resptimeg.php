<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CoreResptimeg_listing extends WListings_default{




function create() {

	$res='';

	$resptime = $this->getValue( 'resptime' );



	switch ($resptime) {

		case 10:

			$res=PTICKET_NODE_TKRTFREE;

			break;

		case 20:

			$res=PTICKET_NODE_TKRTWITHOUT;

			break;

		case 30:

			$res=PTICKET_NODE_TKRTWITH;

			break;

	}



	$this->content =  $res .' '.  WText::t('1206732357ILFL');

	return true;



}}