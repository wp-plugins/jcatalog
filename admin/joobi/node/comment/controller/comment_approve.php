<?php 
/** @copyright Copyright (c) 2007-2015 Joobi Limited. All rights reserved.
* @link joobi.co
* @license GNU GPLv3 */
defined('JOOBI_SECURE') or die('J....');


class Comment_approve_controller extends WController {



function approve() {



	$commentId = WGlobals::get('tkid');

	$namekey = WGlobals::get('namekey');

	$obj = new stdClass;	
	$obj->score = WGlobals::get('score');

	$obj->etid = WGlobals::get('etid');		
	$obj->commenttype = WGlobals::get('commenttype');



	$commentM = WModel::get('comment');

	$commentM->whereE('tkid', $commentId);

	$published = $commentM->load('lr', 'publish');



	if (!$published) {

		$commentM->whereE('tkid', $commentId);

		$commentM->setVal('publish', 1);

		$commentM->update();



		
		$updateRatingC = WClass::get('comment.rating');

		$updateRatingC->updateRating( $obj, $commentId );



		$message = WMessage::get();

		$message->userS('1273127872RXWA',array('$namekey'=>$namekey));

	} else {

		$message = WMessage::get();

		$message->userN('1273127872RXWB',array('$namekey'=>$namekey));

	}


	return true;

}}