<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');






class Ticket_Ticket_class extends WClasses {











	function checkAccessLevel() {

				if ( WPref::load( 'PTICKET_NODE_TKRATINGUSE' ) ) {				
									static $ticketM = null;							static $ticketRreplyM = null;						static $ticketRatingM = null;						static $uid = null;
			static $loggedUid = null;
			static $rateO;
			$rateO = new stdClass;								static $rateC = null;							$colorPref = null;							$restricted = 1;							$option = 0;					
						$uid=$this->getValue('uid');						$loggedUid=WUser::get('uid');							$tkid=$this->getValue('tkid');
			$tkrid=$this->getValue('tkrid');			
						$ticketM=WModel::get('ticket');							$ticketM->whereE('tkid',$tkid);
			$ticketAuthor=$ticketM->load('lr','authoruid');		
			$ticketReplyM=WModel::get('ticket.reply');
			$ticketReplyM->whereE('tkrid',$tkrid);						$replyO = $ticketReplyM->load('ol','score','comment');				$score = $replyO[0]->score;

			$ticketRatingM =WModel::get('ticket.rating');
			$ticketRatingM->whereE('tkrid',$tkrid);						$tkridExist = $ticketRatingM->load('lr');

																		if ($ticketAuthor != $uid && empty($replyO[0]->comment)){
								if (!isset($rateC)|| empty($rateC)){
					$rateC=WClass::get('group.rating',null,'class',false);						}
								if ($ticketAuthor == $loggedUid && empty($tkridExist)){								$restricted = 0;											$option = 1;
									} else {
					$restricted = 1;										}
								if (defined(PTICKET_NODE_TKRATECOLOR)){									$colorPref=PTICKET_NODE_TKRATECOLOR;							}								$rateO->restriction=$restricted;							$rateO->primaryId = $tkrid;								$rateO->colorPref = $colorPref;								$rateO->rating = $score;								$rateO->option = $option;
				$rateO->rateController='ticket-reply&tkid='.$tkid;																		$rating=$rateC->createHTMLRating($rateO,$this);			
								return $rating;
							} else {												return false;
			}
		} else {								return false;
		}
	}
}