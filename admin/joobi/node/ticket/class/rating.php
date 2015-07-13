<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');











class Ticket_Rating_class extends WClasses {






























function checkAccessLevel(){



		
		
		
		
		static $rateC = null;				
		$restricted = null;

		$colorPref = null;

		$type = 0;					


		
		
		
		
		
		if ((empty($this->comment)&& ($this->rolid > 6 || $this->rolid == 4))&& $this->ticketAuthor != $this->uid ){



			if (!isset($rateC )){

				$rateC = WClass::get('output.rating');			
			}


			if (!isset($this->_ratingC)) $this->_ratingC = $rateC ;

			
			if ($this->ticketAuthor == $this->loggedUid && empty($this->trid)){			
				$restricted = 0;						
				$type = 2;							
			} else {

				$restricted = 1;						
			}


			
			if (!defined('PTICKET_NODE_TKRATECOLOR')) WPref::get('ticket.node');

			if (PTICKET_NODE_TKRATECOLOR){					
				$colorPref=PTICKET_NODE_TKRATECOLOR;			
			}


			
			if (!isset($this->_ratingC->colorPref ))		$this->_ratingC->colorPref 	= $colorPref;				
			if (!isset($this->_ratingC->rateController))	$this->_ratingC->rateController	='ticket-reply&tkid='.$this->tkid;		
			
			$this->_ratingC->rating = $this->score;				
			$this->_ratingC->type 	= $type;

			$this->_ratingC->restriction	= $restricted;			
			$this->_ratingC->primaryId 	= $this->tkrid;				


			return $this->_ratingC->createHTMLRating($this);								
		} else {

			return false;					
		}
}}