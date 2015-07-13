<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_useful_controller extends WController {










function useful() {

	
	$tkid = WGlobals::get('tkid');

	$case = WGlobals::get('case');

	$useful = WGlobals::get('useful');

	$usefulclick = WGlobals::get('usefulclick');

	$uid = WGlobals::get('uid');			
	$allow = WGlobals::get('allow');

	$loguid = WGlobals::get('loguid');			
	$voteObj = null;


	
	
	if ($allow) {


		if (empty($result)) {						
			
			switch ($case)

			{

				case 'yes':
						$x = 1;

						$voteObj = $this->_useFulClick($x,$tkid,$useful,$usefulclick,$loguid);

						break;

				case 'no':
						$x = 0;

						$voteObj = $this->_useFulClick($x,$tkid,$useful,$usefulclick,$loguid);

						break;

			}
		}
	}

	$usefulness = '<div id="cmtuseful"><span>'.$voteObj->useful.' </span >'. WText::t('1272278972GKND') .'<span>&nbsp;'.$voteObj->usefulclick.'</span>'. WText::t('1272278972GKNE') .'</div>';
	$message = '<div id="cmtuseful-vote">'.WText::t('1251795312BCNX').'</div>';

	$voteDone = $message.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$usefulness;

echo $voteDone;
exit;

	

	return true;

}














function _useFulClick($x,$tkid,$useful,$usefulclick,$loguid) {

	$ticketM = WModel::get('ticket');
	$ticketClickM = WModel::get('ticket.clickyesno');


	if ($x) {						
		
		$usefulrate=((($useful+1)*100)/($usefulclick+1));



		$ticketM->whereE('tkid',$tkid);

		$ticketM->updatePlus('useful',1);		
		$ticketM->updatePlus('usefulclick',1);		
		$ticketM->setVal('usefulrate',$usefulrate);

		$ticketM->update();



	
		$ticketClickM->setVal('tkid',$tkid);

		$ticketClickM->setVal('uid',$loguid);

		$ticketClickM->setVal('yesno',1);		
		$ticketClickM->save();				
	} else {

		
		$usefulrate=((($useful)*100)/($usefulclick+1));



		$ticketM->whereE('tkid',$tkid);

		$ticketM->updatePlus('usefulclick',1);		
		$ticketM->setVal('usefulrate',$usefulrate);

		$ticketM->update();



		$ticketClickM->setVal('tkid',$tkid);

		$ticketClickM->setVal('uid',$loguid);

		$ticketClickM->setVal('yesno',0);		
		$ticketClickM->save();

	}
		$ticketM->select('useful');
		$ticketM->select('usefulclick');
		$ticketM->whereE('tkid',$tkid);
		$vote = $ticketM->load('o');


return $vote;

}}