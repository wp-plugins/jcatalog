<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Ticket_CoreRating_listing extends WListings_default{














function create() {



	
	if ( WPref::load( 'PTICKET_NODE_TKRATINGUSE' ) ) {				


		$rateC = null;

		static $ticketO= null;



		if (!isset($rateC)|| empty($rateC))$rateC = WClass::get('ticket.rating');

		$this->_rateC = $rateC;

		
		$this->_rateC->uid=$this->getValue('uid');			
		$this->_rateC->loggedUid=WUser::get('uid');			
		$this->_rateC->tkid=$this->getValue('tkid');

		$this->_rateC->ticketAuthor = $this->getValue('authoruid');

		$this->_rateC->tkrid=$this->getValue('tkrid');			
		$this->_rateC->rolid = $this->getValue('rolid');		
		$this->_rateC->score= $this->getValue('score');

		$this->_rateC->comment = $this->getValue('comment');

		$this->_rateC->trid= $this->getValue('trid');



		$this->content = $this->_rateC->checkAccessLevel();		
		return true;

	} else {		
		return '';

	}


}}