<?php 

* @link joobi.co
* @license GNU GPLv3 */



class Comment_reply_listing_controller extends WController {



function listing(){





	parent::listing();

	$uid =  WUser::get('uid');



	if (empty($uid)){

	$message = WMessage::get();

	$message->userW('1307514215TBVS');

	}


	return true;

}
}