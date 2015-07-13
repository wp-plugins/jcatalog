<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */

defined('JOOBI_SECURE') or die('J....');











class Ticket_reply_rate_controller extends WController {
















function rate(){


			

		
		$restriction=WGlobals::get('restriction');			
		$tkrid=WGlobals::get('primaryId');				
		$tkid=WGlobals::get('tkid');

		$starRate = WGlobals::get('starRate');			
		$uid=WUser::get('uid');					
		

		if (empty($restriction)){

			











			
			$ticketM=WModel::get('ticket');

			$ticketM->whereE('tkid',$tkid);					
			$ticketO=$ticketM->load('ol',array('score','authoruid','assignuid','pjid'));		
			
			

			
			if ($ticketO[0]->authoruid == $uid){				
				$paramO->_tkrid = $tkrid;

				$paramO->_tkid = $tkid;

				$paramO->_supportUid = $ticketO[0]->assignuid;

				$paramO->_pjid = $ticketO[0]->pjid;

				







	

				
				
					switch($starRate){			
						case 1:

							$paramO->_rate=1;

							$this->rateCompute($paramO);

							break;

						case 2:

							$paramO->_rate=2;

							$this->rateCompute($paramO);

							break;

						case 3:

							$paramO->_rate=3;

							$this->rateCompute($paramO);

							break;

						case 4:

							$paramO->_rate=4;

							$this->rateCompute($paramO);

							break;

						case 5:

							$paramO->_rate=5;

							$this->rateCompute($paramO);

							break;

							

					}
						

				
			}
		}
	$link='controller=ticket-reply&tkid='.$tkid;

	
	WPages::redirect($link,true);

	return true;

}



function rateCompute($paramO){




	
	$tkid = $paramO->_tkid;

	$rate = $paramO->_rate;

	$tkrid = $paramO->_tkrid;

	$supportUid = $paramO->_supportUid;

	$pjid = $paramO->_pjid;

	

	
	$ticketM=WModel::get('ticket');

	
	$ticketM->whereE('tkid', $tkid);		

	$ticketM->setVal('score',$rate);			
	$ticketM->updatePlus('votes',1);			
	$ticketM->update();

	

	
	$ticketRatingM=WModel::get('ticket.rating');

	$ticketRatingM->setVal('tkrid',$tkrid);		
	$ticketRatingM->setVal('supportuid',$supportUid);	
	$ticketRatingM->setVal('rate', $rate);		
	$ticketRatingM->setVal('modified',time());	
	$ticketRatingM->setVal('pjid',$pjid);		
	$ticketRatingM->save();

	

	
	$ticketReplyM=WModel::get('ticket.reply');

	
	$ticketReplyM->whereE('tkrid',$tkrid);

	$ticketReplyM->setVal('score',$rate);

	$ticketReplyM->update();

	

	return true;

	

}













}