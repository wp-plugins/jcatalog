<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_toggle_controller extends WController {








function toggle() {



	$taskG = WGlobals::get('task');

	$task = substr($taskG, 7);



	if ($task == 'publish') {

		$commentMID = WModel::getID('comment');					
	    $idG = WGlobals::get( 'tkid_'. $commentMID );		
    	$tkid = $idG[0];										


    	$commentM = WModel::get('comment');

        $commentM->whereE( 'tkid', $tkid);

		$comment = $commentM->load('o');		


		if ($comment->publish) {			
			$score = -($comment->score);		
			$vote = -1;
			$nbreview = -1;					
		}else {									
			$score = $comment->score;			
			$vote = 1;									$nbreview = 1;

		}

		switch ($comment->commenttype) {		
			case 10:							
			    $roleSectionsM = WModel::get('product');
			    $roleSectionsM->updatePlus('nbreviews', $nbreview);

				$roleSectionsM->updatePlus( 'score', $score );

				$roleSectionsM->updatePlus( 'votes', $vote );

				$roleSectionsM->whereE( 'pid', $comment->etid );

				$roleSectionsM->update();

	            break;

	        case 20:						        	if ( JOOBI_FRAMEWORK_TYPE == 'joomla' ) {
				    $roleSectionsM = WModel::get('role.content');
					$roleSectionsM->updatePlus( 'rating_sum', $score );
					$roleSectionsM->updatePlus( 'rating_num', $vote );
					$roleSectionsM->whereE( 'id', $comment->etid);
		            $roleSectionsM->update();
	        	}
	        default:

	         break;

	    	}


	} else {

		
	}


	parent::toggle();


return true;



}}